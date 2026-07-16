<?php

namespace App\Services;

use App\Models\Country;
use App\Models\WeatherHistory;
use App\Models\WeatherRecord;
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

            } catch (\Throwable $e) {

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

    public function syncCountry(
        Country $country
    ): void {

        $response = Http::retry(
            3,
            1000
        )
        ->timeout(60)
        ->get(
            'https://api.open-meteo.com/v1/forecast',
            [
                'latitude' => $country->latitude,
                'longitude' => $country->longitude,

                'current' => implode(',', [
                    'temperature_2m',
                    'wind_speed_10m',
                    'weather_code',
                ]),

                'daily' => 'precipitation_sum',
                'forecast_days' => 1,
                'timezone' => 'auto',
            ]
        );

        if (! $response->successful()) {

            throw new \Exception(
                'Open-Meteo request failed. Status: '
                . $response->status()
            );
        }

        $data = $response->json();

        if (! isset($data['current'])) {

            throw new \Exception(
                'Current weather data not found'
            );
        }

        $current = $data['current'];

        $temperature =
            $current['temperature_2m'] ?? 0;
        $windSpeed =
            $current['wind_speed_10m'] ?? 0;
        $weatherCode =
            $current['weather_code'] ?? 0;

        $rainfall =
            $data['daily']['precipitation_sum'][0]
            ?? 0;

        $riskScore =
            $this->calculateWeatherRisk(
                $temperature,
                $rainfall,
                $windSpeed,
                $weatherCode
            );

        WeatherRecord::updateOrCreate(
            [
                'country_id' => $country->id,
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
        float $temperature,
        float $rainfall,
        float $windSpeed,
        int $weatherCode
    ): int {

        $risk = 0;

        if ($rainfall > 5) {
            $risk += 15;
        }

        if ($rainfall > 20) {
            $risk += 20;
        }

        if ($rainfall > 50) {
            $risk += 25;
        }

        if ($windSpeed > 30) {
            $risk += 15;
        }

        if ($windSpeed > 50) {
            $risk += 20;
        }

        if ($windSpeed > 80) {
            $risk += 25;
        }

        if ($temperature >= 40) {
            $risk += 20;
        }

        if ($temperature <= 0) {
            $risk += 20;
        }

        $dangerousCodes = [
            65,
            67,
            75,
            82,
            86,
            95,
            96,
            99,
        ];

        if (
            in_array(
                $weatherCode,
                $dangerousCodes
            )
        ) {
            $risk += 25;
        }

        return min(
            100,
            $risk
        );
    }
}