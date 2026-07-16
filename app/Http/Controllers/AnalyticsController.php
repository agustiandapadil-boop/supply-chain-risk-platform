<?php

namespace App\Http\Controllers;

use App\Models\RiskHistory;
use App\Models\WeatherHistory;
use App\Models\EconomicHistory;
use App\Models\CurrencyHistory;
use App\Models\NewsSentiment;
use App\Models\Country;
use App\Models\RiskScore;


class AnalyticsController extends Controller
{

    public function risk($countryId)
{
    return \App\Models\RiskHistory::where(
        'country_id',
        $countryId
    )
    ->orderBy(
        'calculated_at'
    )
    ->get([
        'total_score',
        'calculated_at as date'
    ]);
}

    public function weather(int $countryId)
    {
        return WeatherHistory::where(
            'country_id',
            $countryId
        )
        ->orderBy(
            'recorded_at'
        )
        ->get();
    }

    public function economy(int $countryId)
    {
        return EconomicHistory::where(
            'country_id',
            $countryId
        )
        ->orderBy(
            'year'
        )
        ->get();
    }

    public function currency(int $countryId)
    {
        return CurrencyHistory::where(
            'country_id',
            $countryId
        )
        ->orderBy(
            'fetched_at'
        )
        ->get();
    }

    public function news()
    {
        return [
            'positive' => NewsSentiment::where(
                'sentiment',
                'Positive'
            )->count(),

            'negative' => NewsSentiment::where(
                'sentiment',
                'Negative'
            )->count(),

            'neutral' => NewsSentiment::where(
                'sentiment',
                'Neutral'
            )->count(),
        ];
    }

    public function overview()
    {
        return [
            'countries' =>
                Country::count(),

            'high_risk' =>
                RiskScore::where(
                    'risk_level',
                    'HIGH'
                )->count(),

            'medium_risk' =>
                RiskScore::where(
                    'risk_level',
                    'MEDIUM'
                )->count(),

            'low_risk' =>
                RiskScore::where(
                    'risk_level',
                    'LOW'
                )->count(),
        ];
        
    }
    
    
}