@extends('admin.layouts.app')

@section('content')

<div
class="
d-flex
justify-content-between
align-items-center
mb-4"
>
    <h2>World Port Dataset</h2>

</div>
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card card-admin p-3">
            <small>Total Ports</small>
            <h3>
                {{ number_format($totalPorts) }}
            </h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-3">
            <small>High Risk Ports</small>
            <h3 class="text-danger">
                {{ $highRiskPorts }}
            </h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-3">
            <small>Medium Risk Ports</small>
            <h3 class="text-warning">
                {{ $mediumRiskPorts }}
            </h3>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card card-admin p-3">
            <small>Low Risk Ports</small>
            <h3 class="text-success">
                {{ $lowRiskPorts }}
            </h3>
        </div>
    </div>
</div>
<div class="card card-admin p-4 mb-4">
<form method="GET">
<div class="row g-3">
    <div class="col-md-4">

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search Port..."
            value="{{ request('search') }}"
        >
    </div>
    <div class="col-md-3">

        <select
            name="country"
            class="form-control"
        >

            <option value="">All Countries </option>
            @foreach($countries as $country)
            <option
                value="{{ $country->id }}"
                {{
                    request('country') == $country->id
                    ? 'selected'
                    : ''
                }}
            >
                {{ $country->country_name }}
            </option>

            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select
            name="type"
            class="form-control"
        >

            <option value="">
                All Harbor Types
            </option>

            @foreach($types as $type)

            <option
                value="{{ $type }}"
                {{
                    request('type') == $type
                    ? 'selected'
                    : ''
                }}
            >
                {{ $type }}
            </option>

            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button
            class="
            btn
            btn-danger
            w-100
            "
        >
            Filter
        </button>
    </div>
</div>
</form>
</div>
<div class="card card-admin p-4 mb-4">

    <h5 class="mb-3">Global Port Map</h5>

    <div
        id="portMap"
        style="
        height:600px;
        border-radius:10px;
        "
    ></div>

</div>
<div class="card card-admin p-4">
<div class="table-responsive">
<table
class="
table
table-hover
table-striped
align-middle
"
>

<thead>

<tr>

    <th>ID</th>
    <th>Country</th>
    <th>Port</th>
    <th>Lat</th>
    <th>Lng</th>
    <th>Type</th>
    <th>Size</th>
    <th>Waiting</th>
    <th>Delay (H)</th>
    <th>Utilization</th>
    <th>Risk</th>

</tr>
</thead>
<tbody>

    @foreach($ports as $port)

<tr>
                <td>
                    {{ $port->id }}
                </td>
                <td>
                    {{ $port->country->country_name ?? '-' }}
                </td>
                <td>
                    {{ $port->port_name }}
                </td>
                <td>
                    {{ $port->latitude }}
                </td>
                <td>
                    {{ $port->longitude }}
                </td>
                <td>

                    <span
                        class="
                        badge
                        bg-primary
                        "
                    >
                        {{ $port->harbor_type }}
                    </span>
                </td>
                <td>

                    <span
                        class="
                        badge
                        bg-secondary
                        "
                    >
                        {{ $port->harbor_size }}
                    </span>
                </td>
                <td>
                    {{ $port->congestion->waiting_vessel ?? 0 }}
                </td>
                <td>
                    {{ $port->congestion->delay_hours ?? 0 }}
                </td>
                <td>
                    {{ $port->congestion->berth_utilization ?? 0 }}%
                </td>
                <td>

                    @php
                        $risk =
                            $port->congestion->risk_level
                            ?? 'LOW';
                    @endphp

                    @if($risk == 'HIGH')

                        <span
                            class="
                            badge
                            bg-danger
                            "
                        >HIGH</span>

                    @elseif($risk == 'MEDIUM')

                        <span
                            class="
                            badge
                            bg-warning
                            text-dark
                            "
                        >MEDIUM</span>

                    @else

                        <span
                            class="
                            badge
                            bg-success
                            "
                        >LOW</span>

                    @endif
                </td>
            </tr>
            @endforeach

            </tbody>
        </table>
    </div>

    <div
        class="
        d-flex
        justify-content-center
        mt-4
        "
    >

        {{ $ports->onEachSide(1)->links('pagination::bootstrap-5') }}

    </div>
</div>

@endsection
@section('scripts')
<link
rel="stylesheet"
href="https://unpkg.com/leaflet/dist/leaflet.css"
/>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
var map = L.map(
    'portMap'
).setView(
    [20,0],
    2
);

L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        maxZoom:18
    }
).addTo(map);

@foreach($mapPorts as $port)

L.marker([
    {{ $port->latitude }},
    {{ $port->longitude }}
])

.addTo(map)

.bindPopup(`
<b>{{ addslashes($port->port_name) }}</b>
<br>
{{ addslashes($port->country->country_name ?? '-') }}
<br>
Type : {{ $port->harbor_type }}
<br>
Size : {{ $port->harbor_size }}
<br>
Waiting Vessel : {{ $port->congestion->waiting_vessel ?? 0 }}
<br>
Delay : {{ $port->congestion->delay_hours ?? 0 }} Hours
<br>
Risk : {{ $port->congestion->risk_level ?? 'LOW' }}
`);

@endforeach
</script> 
@endsection