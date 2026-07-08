<?php

namespace App\Services;

use App\Models\Country;
use App\Models\RiskScore;
use App\Models\WeatherRecord;
use App\Models\NewsSentiment;
use App\Models\RiskHistory;

class DashboardService
{
    public function stats(): array
    {
        return [

            'countries' =>
                Country::count(),

            'high_risk' =>
                RiskScore::where(
                    'risk_level',
                    'High'
                )->count(),

            'medium_risk' =>
                RiskScore::where(
                    'risk_level',
                    'Medium'
                )->count(),

            'low_risk' =>
                RiskScore::where(
                    'risk_level',
                    'Low'
                )->count(),

            'avg_global_risk' =>
                round(
                    RiskScore::avg(
                        'total_score'
                    ),
                    2
                ),

            'weather_alerts' =>
                WeatherRecord::where(
                    'weather_risk_score',
                    '>=',
                    60
                )->count(),

            'negative_news' =>
                NewsSentiment::where(
                    'sentiment',
                    'Negative'
                )->count(),
        ];
    }

    public function topRiskCountries(
        int $limit = 10
    )
    {
        return RiskScore::query()
            ->with('country')
            ->orderByDesc('total_score')
            ->limit($limit)
            ->get()
            ->map(function ($risk) {

                return [
                    'country' =>
                        $risk->country->country_name,

                    'score' =>
                        $risk->total_score,

                    'level' =>
                        $risk->risk_level,
                ];
            });
    }

   public function riskDistribution(): array
{
    return [

        'low' =>
            RiskScore::where(
                'risk_level',
                'Low'
            )->count(),

        'medium' =>
            RiskScore::where(
                'risk_level',
                'Medium'
            )->count(),

        'high' =>
            RiskScore::where(
                'risk_level',
                'High'
            )->count(),
    ];
}

    public function ranking()
    {
        return RiskScore::query()
            ->with('country')
            ->orderByDesc(
                'total_score'
            )
            ->paginate(50);
    }

    public function riskTrend()
    {
        return RiskHistory::query()
            ->selectRaw(
                '
                DATE(calculated_at) as date,
                AVG(total_score) as avg_score
                '
            )
            ->groupByRaw(
                'DATE(calculated_at)'
            )
            ->orderBy(
                'date'
            )
            ->get();
    }
}