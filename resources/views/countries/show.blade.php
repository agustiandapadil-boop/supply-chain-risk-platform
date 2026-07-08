@extends('layouts.app')

@section('content')

@php

$economy = $country->economicIndicator;
$weather = $country->weatherRecord;
$currency = $country->currencyRate;
$risk = $country->riskScore;

$export =
    $economy->export_value ?? 0;

$import =
    $economy->import_value ?? 0;

$tradeBalance =
    $export - $import;

@endphp

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>

        <h1 class="fw-bold">
            {{ $country->country_name }}
        </h1>

        <p class="text-muted mb-0">
            {{ $country->capital }}
            •
            {{ $country->region }}
        </p>

    </div>

    <div>

        <span class="badge bg-danger p-3">

            Risk Level :
            {{ $risk->risk_level ?? '-' }}

        </span>

    </div>

</div>

<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card card-custom p-3">
            <small>GDP</small>
            <h5>
                $
                {{ number_format($economy->gdp ?? 0) }}
            </h5>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-custom p-3">
            <small>Inflation</small>
            <h5>
                {{ $economy->inflation_rate ?? 0 }}%
            </h5>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-custom p-3">
            <small>USD Exchange</small>
            <h5>
                {{ number_format($currency->exchange_rate_usd ?? 0,2) }}
            </h5>
        </div>
    </div>


</div>

<div class="row g-3 mb-4">

    <div class="col-md-3">
        <div class="card card-custom p-3">
            <small>Export Value</small>
            <h5>
                $
                {{ number_format($export,2) }}
            </h5>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-custom p-3">
            <small>Import Value</small>
            <h5>
                $
                {{ number_format($import,2) }}
            </h5>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-custom p-3">
            <small>Trade Balance</small>
            <h5>
                $
                {{ number_format($tradeBalance,2) }}
            </h5>
            <small>
                {{ $tradeBalance >= 0 ? 'Trade Surplus' : 'Trade Deficit' }}
            </small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-custom p-3">
            <small>Total Risk Score</small>
            <h5>
                {{ $risk->total_score ?? 0 }}
            </h5>
        </div>
    </div>

</div>

<div class="row mb-4">

    <div class="col-md-6">

        <div class="card card-custom p-4">

            <h4>
                Risk Breakdown
            </h4>

            <canvas
                id="riskBreakdownChart"
            ></canvas>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card card-custom p-4">

            <h4>
                Country Information
            </h4>

            <hr>

            <p>
                <strong>Capital:</strong>
                {{ $country->capital }}
            </p>

            <p>
                <strong>Region:</strong>
                {{ $country->region }}
            </p>

            <p>
                <strong>Subregion:</strong>
                {{ $country->subregion }}
            </p>

            <p>
                <strong>Language:</strong>
                {{ $country->language }}
            </p>

            <p>
                <strong>Currency:</strong>
                {{ $country->currency_code }}
            </p>

        </div>

    </div>

</div>

<div class="row mb-4">

    <div class="col-md-6">

        <div class="card card-custom p-4">

            <h4>
                Weather Information
            </h4>

            <table class="table">

                <tr>
                    <td>Temperature</td>
                    <td>
                        {{ $weather->temperature ?? 0 }}
                        °C
                    </td>
                </tr>

                <tr>
                    <td>Rainfall</td>
                    <td>
                        {{ $weather->rainfall ?? 0 }}
                    </td>
                </tr>

                <tr>
                    <td>Wind Speed</td>
                    <td>
                        {{ $weather->wind_speed ?? 0 }}
                    </td>
                </tr>

                <tr>
                    <td>Weather Risk</td>
                    <td>
                        {{ $weather->weather_risk_score ?? 0 }}
                    </td>
                </tr>

            </table>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card card-custom p-4">

            <h4>
                Currency Information
            </h4>

            <table class="table">

                <tr>
                    <td>Currency Code</td>
                    <td>
                        {{ $currency->currency_code ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <td>USD Exchange Rate</td>
                    <td>
                        {{ $currency->exchange_rate_usd ?? 0 }}
                    </td>
                </tr>

                <tr>
                    <td>Currency Risk</td>
                    <td>
                        {{ $currency->currency_risk_score ?? 0 }}
                    </td>
                </tr>

            </table>

        </div>

    </div>

</div>

<div class="card card-custom p-4 mb-4">

    <h4>
        Country Location
    </h4>

    <div
        id="map"
        style="height:500px;"
    ></div>

</div>

<div class="card card-custom p-4">

    <h4>
        Active Alerts
    </h4>

    @forelse(
        $country->alerts as $alert
    )

        <div class="alert alert-warning">

            <strong>
                {{ $alert->alert_type }}
            </strong>

            <br>

            {{ $alert->message }}

        </div>

    @empty

        <div
            class="alert alert-success"
        >
            No active alerts
        </div>

    @endforelse

</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(
    document.getElementById(
        'riskBreakdownChart'
    ),
    {
        type:'doughnut',

        data:{
            labels:[
                'Weather',
                'Inflation',
                'Currency',
                'News'
            ],

            datasets:[
                {
                    data:[
                        {{ $risk->weather_score ?? 0 }},
                        {{ $risk->inflation_score ?? 0 }},
                        {{ $risk->currency_score ?? 0 }},
                        {{ $risk->news_score ?? 0 }}
                    ]
                }
            ]
        }
    }
);

</script>

<script>

var map =
    L.map('map').setView(
        [
            {{ $country->latitude }},
            {{ $country->longitude }}
        ],
        5
    );

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
).addTo(map);

L.marker([
    {{ $country->latitude }},
    {{ $country->longitude }}
])
.addTo(map);

</script>

@endsection