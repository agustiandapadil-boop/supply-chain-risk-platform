<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Port;
use App\Models\Country;
use Illuminate\Http\Request;

class PortManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Port::with([
            'country',
            'congestion'
        ]);

        if ($request->filled('search')) {

            $query->where(
                'port_name',
                'like',
                '%' . $request->search . '%'
            );
        }

        if ($request->filled('country')) {

            $query->where(
                'country_id',
                $request->country
            );
        }

        if ($request->filled('type')) {

            $query->where(
                'harbor_type',
                $request->type
            );
        }

        $ports = $query
            ->orderBy('port_name')
            ->paginate(25)
            ->withQueryString();

        $countries = Country::orderBy(
            'country_name'
        )->get();

        $types = Port::select(
            'harbor_type'
        )
        ->whereNotNull('harbor_type')
        ->distinct()
        ->pluck('harbor_type');

        $mapPorts = Port::with([
            'country',
            'congestion'
        ])
        ->whereNotNull('latitude')
        ->whereNotNull('longitude')
        ->limit(300)
        ->get();

        $totalPorts = Port::count();

        $highRiskPorts = Port::whereHas(
            'congestion',
            function ($q) {
                $q->where(
                    'risk_level',
                    'HIGH'
                );
            }
        )->count();

        $mediumRiskPorts = Port::whereHas(
            'congestion',
            function ($q) {
                $q->where(
                    'risk_level',
                    'MEDIUM'
                );
            }
        )->count();

        $lowRiskPorts = Port::whereHas(
            'congestion',
            function ($q) {
                $q->where(
                    'risk_level',
                    'LOW'
                );
            }
        )->count();

        return view(
            'admin.ports.index',
            compact(
                'ports',
                'countries',
                'types',
                'mapPorts',
                'totalPorts',
                'highRiskPorts',
                'mediumRiskPorts',
                'lowRiskPorts'
            )
        );
    }
}