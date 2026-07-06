<?php

namespace App\Console\Commands;

use App\Models\Country;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ImportCountriesCommand extends Command
{
    protected $signature = 'import:countries';

    protected $description =
        'Import countries from local JSON dataset';

    public function handle(): int
    {
        $path = storage_path(
            'app/data/countries.json'
        );

        if (!File::exists($path)) {

            $this->error(
                'countries.json not found.'
            );

            return self::FAILURE;
        }

        $countries = json_decode(
            File::get($path),
            true
        );

        if (!is_array($countries)) {

            $this->error(
                'Invalid countries.json format.'
            );

            return self::FAILURE;
        }

        $count = 0;

        foreach ($countries as $country) {

            if (empty($country['cca2'])) {
                continue;
            }

            $currencies =
                $country['currencies'] ?? [];

            $currencyCode = null;
            $currencyName = null;

            if (!empty($currencies)) {

                $currencyCode =
                    array_key_first(
                        $currencies
                    );

                $currencyName =
                    $currencies[$currencyCode]['name']
                    ?? null;
            }

            $languages = null;

            if (
                isset($country['languages'])
                && is_array(
                    $country['languages']
                )
            ) {
                $languages =
                    implode(
                        ', ',
                        $country['languages']
                    );
            }

            Country::updateOrCreate(
                [
                    'iso2' =>
                        $country['cca2']
                ],
                [
                    'iso3' =>
                        $country['cca3']
                        ?? null,

                    'slug' =>
                        Str::slug(
                            $country['name']['common']
                            ?? ''
                        ),

                    'country_name' =>
                        $country['name']['common']
                        ?? null,

                    'capital' =>
                        $country['capital'][0]
                        ?? null,

                    'region' =>
                        $country['region']
                        ?? null,

                    'subregion' =>
                        $country['subregion']
                        ?? null,

                    'currency_code' =>
                        $currencyCode,

                    'currency_name' =>
                        $currencyName,

                    'language' =>
                        $languages,

                    'population' =>
                        $country['population']
                        ?? null,

                    'latitude' =>
                        $country['latlng'][0]
                        ?? null,

                    'longitude' =>
                        $country['latlng'][1]
                        ?? null,

                    'flag_url' =>
                        $country['flags']['png']
                        ?? null,

                    'api_last_synced_at' =>
                        now(),
                ]
            );

            $count++;
        }

        $this->info(
            "{$count} countries imported."
        );

        return self::SUCCESS;
    }
}