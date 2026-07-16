<?php

namespace App\Http\Controllers;

use App\Models\Port;
use App\Models\Country;

class PortViewController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('country_name')->get(['id', 'country_name']);

        return view('ports.index', compact('countries'));
    }

    public function mapData()
    {
        $ports = Port::with(['country', 'congestion'])
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get();

        return response()->json(
            $ports->map(function ($port) {
                return [
                    'id'           => $port->id,
                    'port_name'    => $port->port_name,
                    'country'      => optional($port->country)->country_name ?? 'Unknown',
                    'country_id'   => $port->country_id,
                    'harbor_type'  => $port->harbor_type,
                    'harbor_size'  => $port->harbor_size,
                    'latitude'     => (float) $port->latitude,
                    'longitude'    => (float) $port->longitude,
                    'risk_level'   => optional($port->congestion)->risk_level ?? 'LOW',
                    'delay_hours'  => optional($port->congestion)->delay_hours ?? 0,
                    'utilization'  => optional($port->congestion)->berth_utilization ?? 0,
                    'waiting'      => optional($port->congestion)->waiting_vessel ?? 0,
                ];
            })
        );
    }
}
