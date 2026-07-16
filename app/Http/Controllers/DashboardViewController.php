<?php

namespace App\Http\Controllers;

use App\Models\Alert;
use App\Models\Country;
use App\Models\RiskScore;
use App\Models\WeatherRecord;
use App\Models\RecommendationScore;

class DashboardViewController extends Controller
{
    public function index()
    {
        $countries = Country::count();

        $highRisk = RiskScore::where('risk_level', 'High')->count();

        $mediumRisk = RiskScore::where('risk_level', 'Medium')->count();

        $lowRisk = RiskScore::where('risk_level', 'Low')->count();

        $averageRisk = round(RiskScore::avg('total_score'), 2);

        $activeAlerts = Alert::count();

        $weatherAlerts = WeatherRecord::where('weather_risk_score', '>=', 60)->count();

        $topRisks = RiskScore::with('country')
            ->orderByDesc('total_score')
            ->limit(10)
            ->get();

        $alerts = Alert::with('country')
            ->latest()
            ->get();

        $recommendedCountries = RecommendationScore::with('country')
            ->orderByDesc('recommendation_score')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'countries',
            'highRisk',
            'mediumRisk',
            'lowRisk',
            'averageRisk',
            'activeAlerts',
            'weatherAlerts',
            'topRisks',
            'alerts',
            'recommendedCountries',
        ));
    }
}