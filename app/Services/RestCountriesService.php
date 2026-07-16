<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class RestCountriesService
{
    public function fetchCountries()
    {
        $allCountries = [];
        $limit = 100;
        $offset = 0;
        $more = true;

        while ($more) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.restcountries.key'),
                'Accept' => 'application/json',
            ])->get('https://api.restcountries.com/countries/v5', [
                'limit' => $limit,
                'offset' => $offset,
            ]);

            if (! $response->successful()) {
                throw new \Exception('REST Countries API failed: ' . $response->body());
            }

            $data = $response->json();
            $items = $data['data']['objects'] ?? [];
            $allCountries = array_merge($allCountries, $items);

            $meta = $data['data']['meta'] ?? [];
            $more = !empty($meta['more']) ? $meta['more'] : false;
            
            if ($more) {
                $offset += $limit;
            }
        }

        return $allCountries;
    }
}