<?php

namespace App\Services;

use App\Models\Country;
use App\Models\WeatherRecord;
use App\Models\WeatherHistory;
use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function syncAllCountries(): int
    {
        $countries = Country::query()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $synced = 0;

        foreach ($countries as $country) {

            try {

                $this->syncCountry($country);

                $synced++;

            } catch (\Exception $e) {

                logger()->error(
                    'Weather sync failed',
                    [
                        'country' => $country->country_name,
                        'message' => $e->getMessage(),
                    ]
                );
            }
        }

        return $synced;
    }

    public function syncCountry(Country $country): void
    {
        $response = Http::timeout(30)
            ->get(
                'https://api.open-meteo.com/v1/forecast',
                [
                    'latitude' => $country->latitude,
                    'longitude' => $country->longitude,

                    'current' => implode(',', [
                        'temperature_2m',
                        'rain',
                        'wind_speed_10m',
                        'weather_code'
                    ])
                ]
            );

        if (!$response->successful()) {
            throw new \Exception(
                'Open-Meteo request failed'
            );
        }

        $data = $response->json();

        if (!isset($data['current'])) {
            throw new \Exception(
                'Current weather not found'
            );
        }

        $current = $data['current'];

        $temperature =
            $current['temperature_2m'] ?? 0;

        $rainfall =
            $current['rain'] ?? 0;

        $windSpeed =
            $current['wind_speed_10m'] ?? 0;

        $weatherCode =
            $current['weather_code'] ?? 0;

        $riskScore =
            $this->calculateWeatherRisk(
                $rainfall,
                $windSpeed,
                $weatherCode
            );

        WeatherRecord::updateOrCreate(
            [
                'country_id' => $country->id
            ],
            [
                'temperature' => $temperature,
                'rainfall' => $rainfall,
                'wind_speed' => $windSpeed,
                'weather_code' => $weatherCode,
                'weather_risk_score' => $riskScore,
                'recorded_at' => now(),
                'api_last_synced_at' => now(),
            ]
        );

        WeatherHistory::create([
            'country_id' => $country->id,
            'temperature' => $temperature,
            'rainfall' => $rainfall,
            'wind_speed' => $windSpeed,
            'weather_risk_score' => $riskScore,
            'recorded_at' => now(),
        ]);
    }

    private function calculateWeatherRisk(
        float $rainfall,
        float $windSpeed,
        int $weatherCode
    ): int
    {
        $risk = 0;

        if ($rainfall > 5) {
            $risk += 30;
        }

        if ($rainfall > 15) {
            $risk += 20;
        }

        if ($windSpeed > 40) {
            $risk += 25;
        }

        if ($windSpeed > 70) {
            $risk += 25;
        }

        $dangerousCodes = [
            95,
            96,
            99
        ];

        if (
            in_array(
                $weatherCode,
                $dangerousCodes
            )
        ) {
            $risk += 30;
        }

        return min($risk, 100);
    }
}