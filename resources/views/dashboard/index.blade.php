@extends('layouts.app')

@section('content')

<div
class="
d-flex
justify-content-between
align-items-center
mb-4
"
>

    <h2 class="page-title">
        Global Risk Dashboard
    </h2>

    <div
        style="
        width:350px;
        position:relative;
        "
    >

        <input
            type="text"
            class="form-control"
            id="countrySearch"
            placeholder="Search any country..."
        >

        <div
            id="searchResults"
            class="list-group"
            style="
                position:absolute;
                width:100%;
                z-index:999;
            "
        ></div>

    </div>

</div>

<div class="row g-3 mb-4">

    <div class="col-md-3">

        <div class="card card-custom p-4">

            <small>Total Countries</small>

            <div class="card-value">

                {{ $countries }}

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card card-custom p-4">

            <small>High Risk Countries</small>

            <div class="card-value">

                {{ $highRisk }}

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card card-custom p-4">

            <small>Medium Risk Countries</small>

            <div class="card-value">

                {{ $mediumRisk }}

            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="card card-custom p-4">

            <small>Low Risk Countries</small>

            <div class="card-value">

                {{ $lowRisk }}

            </div>

        </div>

    </div>

</div>

<div class="row g-3 mb-4">

    <div class="col-md-4">

        <div class="card card-custom p-4">

            <small>Average Global Risk</small>

            <div class="card-value">

                {{ $averageRisk }}

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card card-custom p-4">

            <small>Active Alerts</small>

            <div class="card-value">

                {{ $activeAlerts }}

            </div>

        </div>

    </div>

    <div class="col-md-4">

        <div class="card card-custom p-4">

            <small>Weather Alerts</small>

            <div class="card-value">

                {{ $weatherAlerts }}

            </div>

        </div>

    </div>

</div>

<div class="row">

    <div class="col-md-5">

        <div class="card card-custom p-4">

            <h5 class="mb-3">
                Risk Distribution
            </h5>

            <div
                style="
                width:300px;
                height:300px;
                margin:auto;
                "
            >

                <canvas
                    id="riskChart"
                ></canvas>

            </div>

        </div>

    </div>

    <div class="col-md-7">

        <div class="card card-custom p-4">

            <h5 class="mb-3">
                Top Risk Countries
            </h5>

            <table class="table">

                <thead>

                <tr>

                    <th>Country</th>

                    <th>Score</th>

                    <th>Risk</th>

                </tr>

                </thead>

                <tbody>

                @foreach($topRisks as $risk)

                    <tr>

                        <td>

                            <a
                                href="/ui/countries/{{ $risk->country_id }}"
                            >

                                {{ $risk->country->country_name }}

                            </a>

                        </td>

                        <td>

                            {{ $risk->total_score }}

                        </td>

                        <td>

                            {{ $risk->risk_level }}

                        </td>

                    </tr>

                @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

<div class="row mt-4">

    <div class="col-md-12">

        <div class="card card-custom p-4">

            <h5 class="mb-3">
                Recent Alerts
            </h5>

            @foreach($alerts as $alert)

                <div
                    class="
                    border-bottom
                    pb-2
                    mb-2
                    "
                >

                    <strong>

                        {{ $alert->country->country_name ?? '-' }}

                    </strong>

                    <br>

                    <small>

                        {{ $alert->message }}

                    </small>

                </div>

            @endforeach

        </div>

    </div>

</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

fetch('/dashboard/distribution')

.then(response => response.json())

.then(data => {

    const ctx =
        document.getElementById(
            'riskChart'
        );

    new Chart(ctx, {

        type: 'doughnut',

        data: {

            labels: [
                'Low',
                'Medium',
                'High'
            ],

            datasets: [{

                label:
                    'Risk Distribution',

                data: [

                    data.low,

                    data.medium,

                    data.high

                ],

                backgroundColor: [

                    '#198754',
                    '#d4a017',
                    '#6d071a'

                ],

                borderColor: '#ffffff',

                borderWidth: 2

            }]
        },

        options: {

            responsive: true,

            maintainAspectRatio: false,

            plugins: {

                legend: {

                    position: 'bottom'

                }
            }
            }

        }
    );

});

document
.getElementById(
    'countrySearch'
)
.addEventListener(
    'keyup',
    function(){

        let keyword =
            this.value;

        if(
            keyword.length < 2
        ){
            return;
        }

        fetch(
            '/countries/search?q='
            + keyword
        )

        .then(
            response =>
            response.json()
        )

        .then(data => {

            let html = '';

            data.forEach(country => {

                html +=
                `
                <a
                href="/ui/countries/${country.id}"
                class="list-group-item list-group-item-action"
                >
                ${country.country_name}
                </a>
                `;

            });

            document
            .getElementById(
                'searchResults'
            )
            .innerHTML =
            html;

        });

    }
);

</script>

@endsection