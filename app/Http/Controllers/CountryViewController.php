<?php

namespace App\Http\Controllers;

use App\Models\Country;

class CountryViewController extends Controller
{
    public function show($id)
    {
        $country = Country::with([
            'riskScore',
            'weatherRecord',
            'currencyRate',
            'economicIndicator',
            'alerts'
        ])->findOrFail($id);

        return view(
            'countries.show',
            compact('country')
        );
    }
}