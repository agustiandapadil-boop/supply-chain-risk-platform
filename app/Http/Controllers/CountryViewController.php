<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CurrencyHistory;

class CountryViewController extends Controller
{
    public function show($id)
    {
        $country = Country::with([
            'economicIndicator',
            'weatherRecord',
            'currencyRate',
            'riskScore',
            'alerts',
            'ports',
            'ports.congestion',
        ])->findOrFail($id);

        $currencyHistory = CurrencyHistory::where('country_id', $id)
            ->orderBy('fetched_at', 'asc')
            ->get(['exchange_rate_usd', 'fetched_at']);

        return view(
            'countries.show',
            compact('country', 'currencyHistory')
        );
    }
}