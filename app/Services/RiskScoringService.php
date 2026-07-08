<?php

namespace App\Services;

use App\Models\Country;
use App\Models\CurrencyRate;
use App\Models\EconomicIndicator;
use App\Models\NewsSentiment;
use App\Models\RiskHistory;
use App\Models\RiskScore;
use App\Models\WeatherRecord;

class RiskScoringService
{
    public function calculateAllCountries(): int
    {
        $countries = Country::all();

        $count = 0;

        foreach ($countries as $country) {

            try {

                $this->calculateCountryRisk($country);

                $count++;

            } catch (\Exception $e) {

                logger()->error(
                    'Risk calculation failed',
                    [
                        'country' => $country->country_name,
                        'message' => $e->getMessage(),
                    ]
                );
            }
        }

        return $count;
    }

    public function calculateCountryRisk(
        Country $country
    ): void
    {
        $weatherScore =
            $this->calculateWeatherRisk($country);

        $inflationScore =
            $this->calculateInflationRisk($country);

        $currencyScore =
            $this->calculateCurrencyRisk($country);

        $newsScore =
            $this->calculateNewsRisk();

        $totalScore =
            ($weatherScore * 0.30)
            +
            ($inflationScore * 0.20)
            +
            ($newsScore * 0.40)
            +
            ($currencyScore * 0.10);

        $totalScore = round($totalScore);

        $riskLevel =
            $this->determineRiskLevel(
                $totalScore
            );

        RiskScore::updateOrCreate(
            [
                'country_id' => $country->id,
            ],
            [
                'weather_score' => $weatherScore,
                'inflation_score' => $inflationScore,
                'currency_score' => $currencyScore,
                'news_score' => $newsScore,
                'total_score' => $totalScore,
                'risk_level' => $riskLevel,
                'calculated_at' => now(),
            ]
        );

        RiskHistory::create([
            'country_id' => $country->id,
            'weather_score' => $weatherScore,
            'inflation_score' => $inflationScore,
            'currency_score' => $currencyScore,
            'news_score' => $newsScore,
            'total_score' => $totalScore,
            'risk_level' => $riskLevel,
            'calculated_at' => now(),
        ]);
    }

    private function calculateWeatherRisk(
        Country $country
    ): int
    {
        $weather =
            WeatherRecord::where(
                'country_id',
                $country->id
            )->first();

        if (! $weather) {
            return 0;
        }

        return (int)
            ($weather->weather_risk_score ?? 0);
    }

    private function calculateInflationRisk(
        Country $country
    ): int
    {
        $economy =
            EconomicIndicator::where(
                'country_id',
                $country->id
            )
            ->latest()
            ->first();

        if (
            ! $economy ||
            $economy->inflation_rate === null
        ) {
            return 0;
        }

        $inflation =
            $economy->inflation_rate;

        if ($inflation < 3) {
            return 10;
        }

        if ($inflation < 5) {
            return 30;
        }

        if ($inflation < 10) {
            return 60;
        }

        return 90;
    }

    private function calculateCurrencyRisk(
        Country $country
    ): int
    {
        $currency =
            CurrencyRate::where(
                'country_id',
                $country->id
            )->first();

        if (! $currency) {
            return 0;
        }

        return (int)
            ($currency->currency_risk_score ?? 20);
    }

    private function calculateNewsRisk(): int
    {
        $positive =
            NewsSentiment::where(
                'sentiment',
                'Positive'
            )->count();

        $negative =
            NewsSentiment::where(
                'sentiment',
                'Negative'
            )->count();

        if ($negative > $positive) {
            return 80;
        }

        if ($positive > $negative) {
            return 10;
        }

        return 40;
    }

    private function determineRiskLevel(
        int $score
    ): string
    {
        if ($score <= 30) {
            return 'Low';
        }

        if ($score <= 60) {
            return 'Medium';
        }

        return 'High';
    }
}