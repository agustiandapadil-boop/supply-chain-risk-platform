<?php

namespace App\Services;

use App\Models\Country;

class CountrySyncService
{
    public function sync()
    {
        $api = app(RestCountriesService::class);
        $countries = $api->fetchCountries();
        
        $count = 0;

        foreach ($countries as $item) {

            $iso2 =
                $item['codes']['alpha_2']
                ?? null;

            if (!$iso2) {
                continue;
            }

            Country::updateOrCreate(

                [
                    'iso2' => $iso2
                ],

                [

                    'iso3' =>
                        $item['codes']['alpha_3']
                        ?? null,

                    'country_name' =>
                        $item['names']['common']
                        ??
                        $item['names']['short']
                        ??
                        null,

                    'capital' =>
                        $item['capitals'][0]['name']
                        ?? null,

                    'region' =>
                        $item['region']
                        ?? null,

                    'subregion' =>
                        $item['subregion']
                        ?? null,

                    'population' =>
                        $item['population']
                        ?? 0,

                    'latitude' =>
                        $item['coordinates']['lat']
                        ?? null,

                    'longitude' =>
                        $item['coordinates']['lng']
                        ?? null,

                    'currency_code' =>
                        $item['currencies'][0]['code'] ?? null,

                    'currency_name' =>
                        $item['currencies'][0]['name'] ?? null,

                    'language' =>
                        collect(
                            $item['languages'] ?? []
                        )
                        ->pluck('name')
                        ->implode(', '),

                    'flag_url' =>
                        $item['flag']['url_png']
                        ??
                        $item['flag']['url_svg']
                        ??
                        null,

                    'api_last_synced_at' =>
                        now(),
                ]
            );

            $count++;
        }

        return $count;
    }
}