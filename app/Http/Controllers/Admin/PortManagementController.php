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

    public function create()
    {
        $countries = Country::orderBy('country_name')->get();
        return view('admin.ports.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'port_name' => 'required|string|max:255',
            'harbor_size' => 'nullable|string|max:50',
            'harbor_type' => 'nullable|string|max:50',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        Port::create($request->all());

        return redirect()->route('ports.index')->with('success', 'Port created successfully.');
    }

    public function edit(Port $port)
    {
        $countries = Country::orderBy('country_name')->get();
        return view('admin.ports.edit', compact('port', 'countries'));
    }

    public function update(Request $request, Port $port)
    {
        $request->validate([
            'country_id' => 'required|exists:countries,id',
            'port_name' => 'required|string|max:255',
            'harbor_size' => 'nullable|string|max:50',
            'harbor_type' => 'nullable|string|max:50',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ]);

        $port->update($request->all());

        return redirect()->route('ports.index')->with('success', 'Port updated successfully.');
    }

    public function destroy(Port $port)
    {
        $port->delete();
        return redirect()->route('ports.index')->with('success', 'Port deleted successfully.');
    }
}