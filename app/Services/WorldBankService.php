<?php

namespace App\Services;

use App\Models\Country;
use App\Models\EconomicHistory;
use App\Models\EconomicIndicator;
use Illuminate\Support\Facades\Http;

class WorldBankService
{
    private array $indicators = [
    'GDP' => 'NY.GDP.MKTP.CD',
    'INFLATION' => 'FP.CPI.TOTL.ZG',
    'EXPORT' => 'NE.EXP.GNFS.CD',
    'IMPORT' => 'NE.IMP.GNFS.CD',
];

    public function syncAllCountries(): int
    {
        $countries = Country::all();

        $count = 0;

        foreach ($countries as $country) {

            try {

                $this->syncCountry($country);

                $count++;

            } catch (\Exception $e) {

                logger()->error(
                    'Economy sync failed',
                    [
                        'country' => $country->country_name,
                        'message' => $e->getMessage(),
                    ]
                );
            }
        }

        return $count;
    }

    public function syncCountry(
        Country $country
    ): void
    {
        $latestData = [];

        foreach (
            $this->indicators
            as $field => $indicatorCode
        ) {

            $result =
                $this->fetchLatestIndicator(
                    $country->iso3,
                    $indicatorCode
                );

            $latestData[$field] =
                $result['value'];

            if (
                $result['year']
                &&
                $result['value'] !== null
            ) {

                EconomicHistory::create([
                    'country_id' => $country->id,

                    'indicator_type' => $field,

                    'indicator_value' =>
                        $result['value'],

                    'year' =>
                        $result['year'],
                ]);
            }
        }
        EconomicIndicator::updateOrCreate(
    [
        'country_id' => $country->id
    ],
    [
        'gdp' =>
            $latestData['GDP'] ?? null,

        'inflation_rate' =>
            $latestData['INFLATION'] ?? null,

        'export_value' =>
            $latestData['EXPORT'] ?? null,

        'import_value' =>
            $latestData['IMPORT'] ?? null,

        'year' =>
            now()->year,

        'api_last_synced_at' =>
            now(),
    ]
);
    }

    private function fetchLatestIndicator(
        string $iso3,
        string $indicator
    ): array
    {
        $url =
            "https://api.worldbank.org/v2/country/{$iso3}/indicator/{$indicator}";

        $response = Http::timeout(30)
            ->get($url, [
                'format' => 'json',
                'per_page' => 100,
            ]);

        if (!$response->successful()) {

            return [
                'value' => null,
                'year' => null,
            ];
        }

        $data = $response->json();

        if (
            !isset($data[1])
            || !is_array($data[1])
        ) {
            return [
                'value' => null,
                'year' => null,
            ];
        }

        foreach ($data[1] as $row) {

            if ($row['value'] !== null) {

                return [
                    'value' =>
                        $row['value'],

                    'year' =>
                        $row['date'],
                ];
            }
        }

        return [
            'value' => null,
            'year' => null,
        ];
    }
}