@extends('admin.layouts.app')

@section('content')

<h2 class="mb-4">
    Admin Dashboard
</h2>

<div class="row g-3">
    <div class="col-md-3">
        <div class="card card-admin p-4">
            <small>Total Users</small>
            <h2>
                {{ $totalUsers }}
            </h2>
        </div>

    </div>
    <div class="col-md-3">
        <div class="card card-admin p-4">
            <small>Total Ports</small>
            <h2>
                {{ $totalPorts }}
            </h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-admin p-4">
            <small>Analysis Articles</small>
            <h2>
                {{ $totalArticles }}
            </h2>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card card-admin p-4">
            <small>High Risk Countries</small>
            <h2>
                {{ $highRiskCountries }}
            </h2>
        </div>
    </div>
</div>

<div class="row mt-4 g-4">
    <div class="col-12">
        <div class="card card-admin p-4">

            <h5 class="mb-1">World Map</h5>
            <p class="text-muted small mb-3">Peta persebaran data</p>

            <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
            <div id="adminWorldMap" style="height:400px; border-radius: 10px; z-index: 1;"></div>
        </div>
    </div>
</div>
    
@endsection
@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    var map = L.map('adminWorldMap').setView([20, 0], 2);
    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap contributors &copy; CARTO'
    }).addTo(map);

    function getRiskColor(level) {
        if (level === 'High') return '#dc3545';
        if (level === 'Medium') return '#ffc107';
        if (level === 'Low') return '#198754';
        return '#6c757d';
    }

    var riskData = [
        @foreach($allRiskScores as $risk)
        @if($risk->country && $risk->country->latitude && $risk->country->longitude)
        {
            name: "{{ addslashes($risk->country->country_name) }}",
            lat: {{ $risk->country->latitude }},
            lng: {{ $risk->country->longitude }},
            level: "{{ $risk->risk_level }}",
            score: {{ $risk->total_score }}
        },
        @endif
        @endforeach
    ];

    riskData.forEach(function(c) {
        var marker = L.circleMarker([c.lat, c.lng], {
            radius: 8,
            fillColor: getRiskColor(c.level),
            color: '#fff',
            weight: 1.5,
            opacity: 1,
            fillOpacity: 0.8
        }).addTo(map);

        marker.bindPopup('<div style="text-align:center;"><b>' + c.name + '</b><br>Risk Level: <b style="color:' + getRiskColor(c.level) + ';">' + c.level + '</b><br>Score: ' + c.score + '</div>');
    });
</script>

@endsection
