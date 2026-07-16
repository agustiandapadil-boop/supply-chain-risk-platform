<?php

namespace App\Services;

use App\Models\Country;
use App\Models\CurrencyHistory;
use App\Models\CurrencyRate;
use Illuminate\Support\Facades\Http;

class CurrencyService
{
    public function syncRates(): int
    {
        $response = Http::timeout(60)
            ->get('https://open.er-api.com/v6/latest/USD');

        if (! $response->successful()) {
            throw new \Exception(
                'Failed to fetch exchange rates.'
            );
        }

        $data = $response->json();

        if (
            ! isset($data['rates']) ||
            ! is_array($data['rates'])
        ) {
            throw new \Exception(
                'Invalid exchange rate response.'
            );
        }

        $rates = $data['rates'];

        $count = 0;

        Country::whereNotNull('currency_code')
            ->chunk(100, function ($countries) use ($rates, &$count) {

                foreach ($countries as $country) {

                    $currencyCode =
                        strtoupper($country->currency_code);

                    if (! isset($rates[$currencyCode])) {
                        continue;
                    }

                    $rate = $rates[$currencyCode];

                    $riskScore =
                        $this->calculateCurrencyRisk(
                            $rate
                        );

                    CurrencyRate::updateOrCreate(
                        [
                            'country_id' => $country->id,
                        ],
                        [
                            'currency_code' =>
                                $currencyCode,

                            'exchange_rate_usd' =>
                                $rate,

                            'currency_risk_score' =>
                                $riskScore,

                            'fetched_at' =>
                                now(),

                            'api_last_synced_at' =>
                                now(),
                        ]
                    );

                    CurrencyHistory::create([
                        'country_id' =>
                            $country->id,

                        'exchange_rate_usd' =>
                            $rate,

                        'fetched_at' =>
                            now(),
                    ]);

                    $count++;
                }
            });

        return $count;
    }

    private function calculateCurrencyRisk(
        float $rate
    ): int
    {
        if ($rate < 0.5) {
            return 80;
        }
        if ($rate < 1) {
            return 60;
        }
        if ($rate < 10) {
            return 40;
        }

        return 20;
    }
}