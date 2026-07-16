<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\RiskScore;
use App\Models\EconomicIndicator;

class AnalyticsViewController extends Controller
{
    public function index()
    {
        $riskRanking =
            RiskScore::with('country')
            ->orderByDesc('total_score')
            ->take(10)
            ->get();

        $gdpRanking =
            EconomicIndicator::with('country')
            ->orderByDesc('gdp')
            ->take(10)
            ->get();

        $inflationRanking =
            EconomicIndicator::with('country')
            ->orderByDesc('inflation_rate')
            ->take(10)
            ->get();

        $tradeRanking =
            EconomicIndicator::with('country')
            ->orderByDesc('export_value')
            ->take(20)
            ->get();

        $heatmap =
            Country::with(['riskScore', 'weatherRecord'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        $countries =
            Country::orderBy(
                'country_name'
            )->get();

        return view(
            'analytics.index',
            compact(
                'riskRanking',
                'gdpRanking',
                'inflationRanking',
                'tradeRanking',
                'heatmap',
                'countries'
            )
        );
    }

    public function weatherMapData()
    {
        $countries = Country::with(['weatherRecord', 'riskScore'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($c) {
                return [
                    'id'           => $c->id,
                    'name'         => $c->country_name,
                    'iso2'         => $c->iso2,
                    'lat'          => (float) $c->latitude,
                    'lng'          => (float) $c->longitude,
                    'risk_score'   => optional($c->riskScore)->total_score,
                    'temperature'  => optional($c->weatherRecord)->temperature,
                    'rainfall'     => optional($c->weatherRecord)->rainfall,
                    'wind_speed'   => optional($c->weatherRecord)->wind_speed,
                    'weather_risk' => optional($c->weatherRecord)->weather_risk_score,
                ];
            });

        return response()->json($countries);
    }

    public function currencyHistoryData(\Illuminate\Http\Request $request)
    {
        $countryId = $request->input('country_id');

        if (!$countryId) {
            return response()->json([
                'history' => [],
                'current' => null
            ]);
        }

        $history = \App\Models\CurrencyHistory::where('country_id', $countryId)
            ->orderBy('fetched_at', 'asc')
            ->get(['exchange_rate_usd', 'fetched_at']);

        $historyData = $history->map(function ($h) {
            return [
                'date' => optional($h->fetched_at)->format('d M Y'),
                'rate' => round((float)$h->exchange_rate_usd, 4)
            ];
        });

        $currentCurrency = \App\Models\CurrencyRate::where('country_id', $countryId)->first();
        
        $currentData = null;
        if ($currentCurrency) {
            $currentData = [
                'code' => $currentCurrency->currency_code,
                'rate' => round((float)$currentCurrency->exchange_rate_usd, 4),
                'risk' => (float)$currentCurrency->currency_risk_score
            ];
        }

        return response()->json([
            'history' => $historyData,
            'current' => $currentData
        ]);
    }

}