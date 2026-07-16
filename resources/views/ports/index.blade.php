@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h2 class="page-title mb-0">World Port Map</h2>
        <p class="text-muted small mb-0">Interactive map of global port infrastructure</p>
    </div>

    <div class="d-flex gap-2 align-items-center flex-wrap">

        <input
            id="searchPort"
            type="text"
            class="form-control form-control-sm"
            placeholder="Search port name..."
            style="width:200px;"
        >

        <select id="filterCountry" class="form-select form-select-sm" style="width:200px;">
            <option value="">All Countries</option>
            @foreach($countries as $c)
            <option value="{{ $c->country_name }}">{{ $c->country_name }}</option>
            @endforeach
        </select>

        <select id="filterRisk" class="form-select form-select-sm" style="width:150px;">
            <option value="">All Risk Levels</option>
            <option value="HIGH">High Risk</option>
            <option value="MEDIUM">Medium Risk</option>
            <option value="LOW">Low Risk</option>
        </select>

        <button id="btnReset" class="btn btn-sm btn-outline-secondary">Reset</button>

    </div>

</div>

<div class="row g-3 mb-3" id="statBar">

    <div class="col-6 col-md-3">
        <div class="card card-custom p-3 text-center">
            <div class="text-muted small">Total Ports</div>
            <div class="fw-bold fs-4" id="statTotal">—</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card card-custom p-3 text-center">
            <div class="text-muted small" style="color:#ffc107;">Medium Risk</div>
            <div class="fw-bold fs-4" id="statMedium" style="color:#ffc107;">—</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card card-custom p-3 text-center">
            <div class="text-muted small" style="color:#dc3545;">High Risk</div>
            <div class="fw-bold fs-4" id="statHigh" style="color:#dc3545;">—</div>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="card card-custom p-3 text-center">
            <div class="text-muted small" style="color:#198754;">Low Risk</div>
            <div class="fw-bold fs-4" id="statLow" style="color:#198754;">—</div>
        </div>
    </div>

</div>

<div class="card card-custom p-0 overflow-hidden" style="position:relative;">

    <div id="portMap" style="height:600px; width:100%; z-index:1;"></div>

    <div
        id="mapLoader"
        style="
            position:absolute; inset:0;
            background:rgba(255,255,255,0.85);
            display:flex; align-items:center; justify-content:center;
            z-index:10; font-size:1rem; color:#555;
        "
    >
        Loading ports...
    </div>

</div>

<div class="row mt-3">
    <div class="col-auto">
        <span class="badge me-1" style="background:#dc3545;">HIGH</span> High Risk
        <span class="badge ms-3 me-1" style="background:#ffc107; color:#000;">MED</span> Medium Risk
        <span class="badge ms-3 me-1" style="background:#198754;">LOW</span> Low Risk
    </div>
</div>

@endsection

@section('scripts')

<script>

(function () {

    var map = L.map('portMap').setView([20, 0], 2);

    L.tileLayer(
        'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        { attribution: '© OpenStreetMap' }
    ).addTo(map);

    var allPorts = [];
    var markerLayer = L.layerGroup().addTo(map);

    function riskColor(level) {
        if (level === 'HIGH')   return '#dc3545';
        if (level === 'MEDIUM') return '#ffc107';
        return '#198754';
    }

    function makeMarker(port) {
        var color = riskColor(port.risk_level);

        var icon = L.divIcon({
            className: '',
            html: '<div style="'
                + 'width:12px; height:12px; border-radius:50%;'
                + 'background:' + color + ';'
                + 'border:2px solid #fff;'
                + 'box-shadow:0 1px 4px rgba(0,0,0,0.4);'
                + '"></div>',
            iconSize: [12, 12],
            iconAnchor: [6, 6],
        });

        var popup = '<div style="min-width:200px;">'
            + '<strong style="font-size:1rem;">' + port.port_name + '</strong><br>'
            + '<span class="text-muted">' + port.country + '</span>'
            + '<hr style="margin:6px 0;">'
            + '<table style="width:100%;font-size:0.82rem;">'
            + '<tr><td>Type</td><td><b>' + (port.harbor_type || '-') + '</b></td></tr>'
            + '<tr><td>Size</td><td><b>' + (port.harbor_size || '-') + '</b></td></tr>'
            + '<tr><td>Risk</td><td><b style="color:' + color + ';">' + port.risk_level + '</b></td></tr>'
            + '<tr><td>Delay</td><td><b>' + port.delay_hours + ' hrs</b></td></tr>'
            + '<tr><td>Utilization</td><td><b>' + port.utilization + '%</b></td></tr>'
            + '<tr><td>Waiting Vessels</td><td><b>' + port.waiting + '</b></td></tr>'
            + '</table>'
            + '<a href="/ui/countries/' + port.country_id + '" class="btn btn-sm btn-outline-dark mt-2" style="font-size:0.78rem;">View Country</a>'
            + '</div>';

        return L.marker([port.latitude, port.longitude], { icon: icon })
            .bindPopup(popup, { maxWidth: 260 });
    }

    function updateStats(ports) {
        document.getElementById('statTotal').textContent   = allPorts.length;
        document.getElementById('statMedium').textContent  = ports.filter(p => p.risk_level === 'MEDIUM').length;
        document.getElementById('statHigh').textContent    = ports.filter(p => p.risk_level === 'HIGH').length;
        document.getElementById('statLow').textContent     = ports.filter(p => p.risk_level === 'LOW').length;
    }

    function renderMarkers(ports) {
        markerLayer.clearLayers();
        ports.forEach(function (port) {
            markerLayer.addLayer(makeMarker(port));
        });
        updateStats(ports);
    }

    function applyFilters() {
        var portQ    = document.getElementById('searchPort').value.trim().toLowerCase();
        var countryQ = document.getElementById('filterCountry').value.trim().toLowerCase();
        var riskQ    = document.getElementById('filterRisk').value;

        var filtered = allPorts.filter(function (p) {
            var matchPort    = !portQ    || p.port_name.toLowerCase().includes(portQ);
            var matchCountry = !countryQ || p.country.toLowerCase().includes(countryQ);
            var matchRisk    = !riskQ    || p.risk_level === riskQ;
            return matchPort && matchCountry && matchRisk;
        });

        renderMarkers(filtered);
    }

    document.getElementById('searchPort').addEventListener('input', applyFilters);
    document.getElementById('filterCountry').addEventListener('change', applyFilters);
    document.getElementById('filterRisk').addEventListener('change', applyFilters);

    document.getElementById('btnReset').addEventListener('click', function () {
        document.getElementById('searchPort').value    = '';
        document.getElementById('filterCountry').value = '';
        document.getElementById('filterRisk').value    = '';
        renderMarkers(allPorts);
    });

    fetch('/ui/ports/map-data')
        .then(function (r) { return r.json(); })
        .then(function (data) {
            allPorts = data;
            renderMarkers(allPorts);
            document.getElementById('mapLoader').style.display = 'none';
        })
        .catch(function () {
            document.getElementById('mapLoader').textContent = 'Failed to load port data.';
        });

})();

</script>

@endsection
