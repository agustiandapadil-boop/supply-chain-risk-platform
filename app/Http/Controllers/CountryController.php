<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function show($id)
    {
        $country = Country::with([
            'weatherRecord',
            'economicIndicator',
            'currencyRate',
            'riskScore'
        ])->findOrFail($id);

        return response()->json($country);
    }

    public function search(
        Request $request
    )
    {
        $keyword =
            $request->q;

        return Country::query()

            ->where(
                'country_name',
                'like',
                '%' . $keyword . '%'
            )

            ->orderBy(
                'country_name'
            )

            ->limit(20)

            ->get([
                'id',
                'country_name'
            ]);
    }
}