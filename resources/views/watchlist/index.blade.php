@extends('layouts.app')

@section('content')

<h2 class="page-title mb-4">
    Watchlist Monitoring Center
</h2>

<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card card-custom p-4">
            <small>Countries Watched</small>
            <div class="card-value">
                {{ $totalWatchlist }}
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-custom p-4">
            <small>High Risk</small>
            <div class="card-value">
                {{ $highRisk }}
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-custom p-4">
            <small>Medium Risk</small>
            <div class="card-value">
                {{ $mediumRisk }}
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-custom p-4">
            <small>Active Alerts</small>
            <div class="card-value">
                {{ $activeAlerts }}
            </div>
        </div>
    </div>

</div>

<div class="card card-custom p-4 mb-4 overflow-hidden">

    <h4 class="mb-3">
        Global Watchlist Map
    </h4>

    <div
        id="watchlistMap"
        style="
            height:320px;
            width:100%;
            border-radius:12px;
        "
    ></div>

</div>

<div class="card card-custom p-4">

    <div
        class="
        d-flex
        justify-content-between
        align-items-center
        mb-4
        "
    >

        <h4 class="mb-0">
            Supply Chain Monitoring
        </h4>

        <span class="badge bg-dark">
            {{ $watchlists->count() }} Countries
        </span>

    </div>

    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead>

            <tr>

                <th>Country</th>
                <th>Risk Score</th>
                <th>Risk Level</th>
                <th>GDP</th>
                <th>Inflation</th>
                <th>Export</th>
                <th>Import</th>
                <th>USD Rate</th>
                <th>Alerts</th>
                <th>Action</th>

            </tr>

            </thead>

            <tbody>

            @foreach($watchlists as $watch)

                <tr>

                    <td>

                        <strong>
                            {{ $watch->country->country_name }}
                        </strong>

                    </td>

                    <td>

                        {{
                            optional(
                                $watch->country->riskScore
                            )->total_score
                        }}

                    </td>

                    <td>

                        @php

                            $risk =
                            optional(
                                $watch->country->riskScore
                            )->risk_level;

                        @endphp

                        @if($risk == 'High')

                            <span
                                class="
                                badge
                                badge-high
                                "
                            >
                                High
                            </span>

                        @elseif($risk == 'Medium')

                            <span
                                class="
                                badge
                                badge-medium
                                "
                            >
                                Medium
                            </span>

                        @else

                            <span
                                class="
                                badge
                                badge-low
                                "
                            >
                                Low
                            </span>

                        @endif

                    </td>

                    <td>

                        $
                        {{
                            number_format(
                                optional(
                                    $watch->country
                                    ->economicIndicator
                                )->gdp ?? 0
                            )
                        }}

                    </td>

                    <td>

                        {{
                            optional(
                                $watch->country
                                ->economicIndicator
                            )->inflation_rate
                        }}%

                    </td>

                    <td>

                        $
                        {{
                            number_format(
                                optional(
                                    $watch->country
                                    ->economicIndicator
                                )->export_value ?? 0
                            )
                        }}

                    </td>

                    <td>

                        $
                        {{
                            number_format(
                                optional(
                                    $watch->country
                                    ->economicIndicator
                                )->import_value ?? 0
                            )
                        }}

                    </td>

                    <td>

                        {{
                            optional(
                                $watch->country
                                ->currencyRate
                            )->exchange_rate_usd
                        }}

                    </td>

                    <td>

                        <span
                            class="
                            badge
                            bg-danger
                            "
                        >

                            {{
                                $watch
                                ->country
                                ->alerts
                                ->count()
                            }}

                        </span>

                    </td>

                    <td>

                        <a
                            href="/ui/countries/{{ $watch->country_id }}"
                            class="
                            btn
                            btn-sm
                            btn-outline-dark
                            "
                        >
                            Detail
                        </a>

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    </div>

</div>

@endsection

@section('scripts')

<script>

const map = L.map(
    'watchlistMap'
).setView(
    [20,0],
    2
);

L.tileLayer(
    'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    {
        attribution:
        '&copy; OpenStreetMap'
    }
).addTo(map);

@foreach($watchlists as $watch)

L.marker([
    {{ $watch->country->latitude }},
    {{ $watch->country->longitude }}
])
.addTo(map)
.bindPopup(`
    <b>
        {{ $watch->country->country_name }}
    </b>
    <br>

    Risk:
    {{
        optional(
            $watch->country->riskScore
        )->risk_level
    }}

    <br>

    Score:
    {{
        optional(
            $watch->country->riskScore
        )->total_score
    }}
`);

@endforeach

setTimeout(() => {

    map.invalidateSize();

}, 300);

</script>

@endsection