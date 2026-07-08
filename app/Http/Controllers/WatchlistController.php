<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Watchlist;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
   public function index(
    Request $request
)
{
    return Watchlist::with([
        'country.riskScore',
        'country.weatherRecord',
        'country.currencyRate',
        'country.alerts'
    ])
    ->where(
        'user_id',
        $request->user()->id
    )
    ->get();
}
    public function store(
    Request $request,
    int $countryId
)
{
    $country =
        Country::findOrFail(
            $countryId
        );

    $watchlist =
        Watchlist::firstOrCreate([
            'user_id' =>
                $request->user()->id,

            'country_id' =>
                $country->id,
        ]);

    return response()->json([
        'message' =>
            'Added to watchlist',

        'data' =>
            $watchlist,
    ]);
}

    public function destroy(
    Request $request,
    int $countryId
)
{
    Watchlist::where(
        'user_id',
        $request->user()->id
    )
    ->where(
        'country_id',
        $countryId
    )
    ->delete();

    return response()->json([
        'message' =>
            'Removed from watchlist',
    ]);
}

    public function monitoring()
    {
        return Watchlist::with([
            'country.riskScore',
            'country.alerts',
            'country.weatherRecord',
            'country.currencyRate',
        ])->where(
            'user_id',
            1
        )->get();
    }
}