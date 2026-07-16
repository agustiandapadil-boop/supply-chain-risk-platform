<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Port;
use App\Models\AnalysisArticle;
use App\Models\Country;
use App\Models\RiskScore;
use App\Models\RecommendationScore;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();

        $totalPorts = Port::count();

        $totalArticles = AnalysisArticle::count();

        $highRiskCountries = RiskScore::where('risk_level', 'High')->count();

        $topBestCountries = RecommendationScore::with('country')
            ->orderByDesc('recommendation_score')
            ->take(10)
            ->get();

        if ($topBestCountries->isEmpty()) {
            $topBestCountries = RiskScore::with('country')
                ->orderBy('total_score')
                ->take(10)
                ->get()
                ->map(function ($r) {
                    $r->recommendation_score = 100 - $r->total_score;
                    return $r;
                });
        }

        $allRiskScores = RiskScore::with('country')->get();

        return view(
            'admin.dashboard',
            compact(
                'totalUsers',
                'totalPorts',
                'totalArticles',
                'highRiskCountries',
                'topBestCountries',
                'allRiskScores'
            )
        );
    }
}