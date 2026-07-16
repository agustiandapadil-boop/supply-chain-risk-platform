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
            •
            Population: {{ number_format($country->population ?? 0) }}
        </p>

    </div>
    <div>

        <button
            id="addWatchlist"
            class="btn btn-danger"
        >
            Add To Watchlist
        </button>
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
                {{ $economy->inflation_rate ?? 0 }} %
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

    <div class="col-md-3">
        <div class="card card-custom p-3">
            <small>Risk Score</small>
            <h5>
                {{ $risk->total_score ?? 0 }}
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
            <small>Risk Level</small>
            <h5>
                {{ $risk->risk_level ?? '-' }}
            </h5>
        </div>
    </div>
</div>

<div class="col-md-3">
    <div class="card card-custom p-3">
        <small>Total Ports</small>
        <h5>
            {{ $country->ports->count() }}
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

            <div style="width:300px; height:300px; margin:auto;">
                <canvas
                    id="riskBreakdownChart"
                ></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-custom p-4">
            <h4>
                Country Information
            </h4>
            <hr>
            <p>
                <strong>Capital :</strong>
                {{ $country->capital }}
            </p>

            <p>
                <strong>Region :</strong>
                {{ $country->region }}
            </p>

            <p>
                <strong>Sub Region :</strong>
                {{ $country->subregion }}
            </p>

            <p>
                <strong>Language :</strong>
                {{ $country->language }}
            </p>

            <p>
                <strong>Population :</strong>
                {{ number_format($country->population ?? 0) }}
            </p>

            <p>
                <strong>Currency :</strong>
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
                    <td>{{ $weather->temperature ?? 0 }} °C</td>
                </tr>

                <tr>
                    <td>Rainfall</td>
                    <td>{{ $weather->rainfall ?? 0 }}</td>
                </tr>

                <tr>
                    <td>Wind Speed</td>
                    <td>{{ $weather->wind_speed ?? 0 }}</td>
                </tr>

                <tr>
                    <td>Weather Risk</td>
                    <td>{{ $weather->weather_risk_score ?? 0 }}</td>
                </tr>

            </table>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-custom p-4">
            <h4 class="mb-3">Currency Information</h4>
            <div class="d-flex gap-3 flex-wrap mb-3">

                <div class="p-3 rounded-3 text-center flex-fill" style="background:var(--bg-secondary,#f8f9fa);">
                    <div class="text-muted small mb-1">Currency</div>
                    <div class="fw-bold fs-5">{{ $currency->currency_code ?? '-' }}</div>
                </div>

                <div class="p-3 rounded-3 text-center flex-fill" style="background:var(--bg-secondary,#f8f9fa);">
                    <div class="text-muted small mb-1">1 USD =</div>
                    <div class="fw-bold fs-5">{{ number_format($currency->exchange_rate_usd ?? 0, 4) }}</div>
                    <div class="text-muted small">{{ $currency->currency_code ?? '' }}</div>
                </div>

                <div class="p-3 rounded-3 text-center flex-fill" style="background:var(--bg-secondary,#f8f9fa);">
                    <div class="text-muted small mb-1">Currency Risk</div>
                    @php $cRisk = $currency->currency_risk_score ?? 0; @endphp
                    <span class="badge fs-6 {{ $cRisk >= 70 ? 'bg-danger' : ($cRisk >= 40 ? 'bg-warning text-dark' : 'bg-success') }}">
                        {{ $cRisk }}
                    </span>
                </div>

            </div>
            <div class="mt-2">
                <div class="text-muted small mb-2">Exchange Rate History (USD)</div>
                <canvas id="currencyChart" height="130"></canvas>
                @if($currencyHistory->isEmpty())
                    <p class="text-muted text-center small mt-2">No historical data available.</p>
                @endif
            </div>
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
<div class="card card-custom p-4 mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">

        <h4 class="mb-0">
            Port Infrastructure
        </h4>
        <div>

            <button
                id="prevPort"
                class="btn btn-sm btn-outline-secondary"
            >
                <
            </button>

            <button
                id="nextPort"
                class="btn btn-sm btn-outline-secondary"
            >
                >
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
            <tr>

                <th>Port</th>
                <th>Lat</th>
                <th>Lng</th>
                <th>Type</th>
                <th>Size</th>
                <th>Waiting</th>
                <th>Delay(H)</th>
                <th>Utilization</th>
                <th>Risk</th>

            </tr>
            </thead>
            <tbody id="portTableBody">
            @foreach($country->ports as $port)
            <tr class="port-row">

                <td>{{ $port->port_name }}</td>
                <td>{{ $port->latitude }}</td>
                <td>{{ $port->longitude }}</td>
                <td>{{ $port->harbor_type }}</td>
                <td>{{ $port->harbor_size }}</td>

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
$portRisk =
    $port->congestion->risk_level
    ?? 'LOW';
@endphp

@if($portRisk == 'HIGH')

    <span class="badge bg-danger">
        HIGH
    </span>

@elseif($portRisk == 'MEDIUM')

    <span class="badge bg-warning text-dark">
        MEDIUM
    </span>

@else

    <span class="badge bg-success">
        LOW
    </span>

@endif
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
<div class="card card-custom p-4">

    <h4>Active Alerts</h4>
    @forelse($country->alerts as $alert)
        <div class="alert alert-warning">
            <strong>
                {{ $alert->alert_type }}
            </strong>
            <br>
            {{ $alert->message }}
        </div>
    @empty
        <div class="alert alert-success">No active alerts</div>

    @endforelse

</div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
(function(){
    var historyLabels = {!! json_encode($currencyHistory->map(fn($h) => optional($h->fetched_at)->format('d M Y'))) !!};
    var historyRates  = {!! json_encode($currencyHistory->pluck('exchange_rate_usd')->map(fn($v) => round((float)$v, 4))) !!};

    if (historyLabels.length === 0) {
        historyLabels = ['No Data'];
        historyRates  = [0];
    }

    var ctxCurrency = document.getElementById('currencyChart');
    if (ctxCurrency) {
        new Chart(ctxCurrency, {
            type: 'line',
            data: {
                labels: historyLabels,
                datasets: [{
                    label: '1 USD = X {{ $currency->currency_code ?? "" }}',
                    data: historyRates,
                    borderColor: '#6366f1',
                    backgroundColor: 'rgba(99,102,241,0.10)',
                    borderWidth: 2,
                    pointRadius: historyLabels.length > 60 ? 0 : 3,
                    pointHoverRadius: 5,
                    fill: true,
                    tension: 0.35,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => '1 USD = ' + ctx.parsed.y
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: {
                            maxTicksLimit: 8,
                            maxRotation: 0,
                            font: { size: 10 }
                        },
                        grid: { display: false }
                    },
                    y: {
                        ticks: { font: { size: 10 } },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    }
                }
            }
        });
    }
})();
</script>

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

var map =
    L.map('map').setView(
        [
            {{ $country->latitude ?? 0 }},
            {{ $country->longitude ?? 0 }}
        ],
        5
    );

L.tileLayer(
'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
).addTo(map);

L.marker([
    {{ $country->latitude ?? 0 }},
    {{ $country->longitude ?? 0 }}
])
.addTo(map);

document
.getElementById(
    'addWatchlist'
)
.addEventListener(
    'click',
    function(){

        fetch(
            '/watchlist/{{ $country->id }}',
            {
                method:'POST',
                headers:{
                    'X-CSRF-TOKEN':
                        '{{ csrf_token() }}',
                    'Accept':
                        'application/json'
                }
            }
        )
        .then(response => {

            if(!response.ok){
                throw new Error(
                    'Failed'
                );
            }

            return response.json();

        })
        .then(data => {

            alert(
                'Country added to watchlist'
            );

        })
        .catch(error => {

            alert(
                'Failed adding watchlist'
            );
            console.log(error);
        });

    }
);
const rows =
    document.querySelectorAll(
        '.port-row'
    );

let page = 0;
const perPage = 5;
function renderPorts()
{
    rows.forEach(
        (row,index) =>
        {
            row.style.display =
                (
                    index >= page * perPage
                    &&
                    index < (page + 1) * perPage
                )
                ? ''
                : 'none';
        }
    );
}

renderPorts();

document
.getElementById('nextPort')
.addEventListener(
'click',
function(){

    if(
        (page + 1) * perPage
        <
        rows.length
    ){
        page++;
        renderPorts();
    }

});

document
.getElementById('prevPort')
.addEventListener(
'click',
function(){

    if(page > 0){
        page--;
        renderPorts();
    }

});
</script>

@endsection