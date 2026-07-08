<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function index(
        DashboardService $dashboard
    )
    {
        return response()->json(
            $dashboard->stats()
        );
    }

    public function topRisk(
    DashboardService $dashboard
)
{
    return response()->json(
        $dashboard->topRiskCountries()
    );
}
public function distribution(
    DashboardService $dashboard
)
{
    return response()->json(
        $dashboard->riskDistribution()
    );
}
public function ranking(
    DashboardService $dashboard
)
{
    return response()->json(
        $dashboard->ranking()
    );
}
public function trend(
    DashboardService $dashboard
)
{
    return response()->json(
        $dashboard->riskTrend()
    );
}
}