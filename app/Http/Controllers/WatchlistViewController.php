<?php

namespace App\Http\Controllers;

use App\Models\Watchlist;
use App\Models\Alert;
use Illuminate\Support\Facades\Auth;

class WatchlistViewController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $watchlists =
            Watchlist::with([
                'country.riskScore',
                'country.weatherRecord',
                'country.currencyRate',
                'country.economicIndicator',
                'country.alerts'
            ])
            ->where(
                'user_id',
                $userId
            )
            ->get();

        $totalWatchlist =
            $watchlists->count();

        $highRisk =
            $watchlists
            ->filter(function ($item) {

                return optional(
                    $item->country->riskScore
                )->risk_level === 'High';

            })
            ->count();

        $mediumRisk =
            $watchlists
            ->filter(function ($item) {

                return optional(
                    $item->country->riskScore
                )->risk_level === 'Medium';

            })
            ->count();

        $activeAlerts =
            Alert::whereIn(
                'country_id',
                $watchlists
                    ->pluck('country_id')
            )->count();

        return view(
            'watchlist.index',
            compact(
                'watchlists',
                'totalWatchlist',
                'highRisk',
                'mediumRisk',
                'activeAlerts'
            )
        );
    }
}