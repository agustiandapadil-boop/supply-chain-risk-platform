<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryComparisonController extends Controller
{
    public function compare(
        Request $request
    )
    {
        $countryA =
            Country::with([
                'economicIndicator',
                'currencyRate',
                'weatherRecord',
                'riskScore'
            ])
            ->findOrFail(
                $request->country_a
            );

        $countryB =
            Country::with([
                'economicIndicator',
                'currencyRate',
                'weatherRecord',
                'riskScore'
            ])
            ->findOrFail(
                $request->country_b
            );

        return response()->json([
            'a' => $countryA,
            'b' => $countryB
        ]);
    }
}