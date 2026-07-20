@extends('layouts.app')
@section('content')
<h2 class="page-title mb-4">
    Global Analytics Center
</h2>
<div class="row g-4">
    <div class="col-md-6">
        <div class="card card-custom p-4">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
    <h4 class="mb-0">
        Currency Information
    </h4>

    <select
        id="currencyCountrySelect"
        class="form-select form-select-sm"
        style="width:220px;"
    >
        <option value="">
            Select Country
        </option>

        @foreach($countries as $country)
            <option value="{{ $country->id }}">
                {{ $country->country_name }}
            </option>
        @endforeach
    </select>
</div>
            <div class="d-flex gap-3 flex-wrap mb-4" id="currencyInfoBoxes" style="display: none !important;">

                <div class="p-3 rounded-3 text-center flex-fill" style="background:var(--bg-secondary,#f8f9fa);">
                    <div class="text-muted small mb-1">Currency</div>
                    <div class="fw-bold fs-5" id="cBoxCode">-</div>
                </div>

                <div class="p-3 rounded-3 text-center flex-fill" style="background:var(--bg-secondary,#f8f9fa);">
                    <div class="text-muted small mb-1">1 USD =</div>
                    <div class="fw-bold fs-5" id="cBoxRate">-</div>
                    <div class="text-muted small" id="cBoxCodeSub">-</div>
                </div>

                <div class="p-3 rounded-3 text-center flex-fill" style="background:var(--bg-secondary,#f8f9fa);">
                    <div class="text-muted small mb-1">Currency Risk</div>
                    <span class="badge fs-6" id="cBoxRisk">-</span>
                </div>

            </div>

            <div class="text-muted small mb-2" id="currencyChartLabel" style="display: none;">Exchange Rate History (USD)</div>
            <canvas id="currencyHistoryChart" height="130"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-custom p-4">
            <h5>
                GDP Ranking
            </h5>
            <canvas id="gdpChart"></canvas>
        </div>
    </div>
</div>

<div class="row g-4 mt-2">
    <div class="col-md-6">
        <div class="card card-custom p-4">
            <h5>
                Inflation Ranking
            </h5>
            <canvas id="inflationChart"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card card-custom p-4">
            <h5>
                Export vs Import
            </h5>
            <canvas id="tradeChart"></canvas>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-12">
        <div class="card card-custom p-4">
            <h5 class="mb-4">
                Country Comparison Engine
            </h5>
            <div class="row">
                <div class="col-md-5">
                    <label class="mb-2">Country A</label>
                    <select
                        id="countryA"
                        class="form-select"
                    >

                        <option value="">
                            Select Country
                        </option>

                        @foreach($countries as $country)

                            <option
                                value="{{ $country->id }}"
                            >
                                {{ $country->country_name }}
                            </option>

                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <label class="mb-2">Country B</label>
                    <select
                        id="countryB"
                        class="form-select"
                    >

                        <option value="">
                            Select Country
                        </option>

                        @foreach($countries as $country)

                            <option
                                value="{{ $country->id }}"
                            >
                                {{ $country->country_name }}
                            </option>

                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button
                        id="compareBtn"
                        class="btn btn-danger w-100"
                    >
                        Compare
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div
    id="comparisonResult"
    class="mt-4"
></div>
<div class="row mt-4">
    <div class="col-md-12">
        <div class="card card-custom p-4">
            {{-- Header --}}
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
                <div>
                    <h5 class="mb-1">Global Real-time Weather Map</h5>
                </div>
                <div class="d-flex align-items-center gap-3 flex-wrap">

                    {{-- Legend --}}
                    <div class="d-flex align-items-center gap-2" style="font-size:13px;font-weight:600;">
                        <span style="display:inline-block;width:14px;height:14px;border-radius:50%;background:#dc3545;"></span> Panas ≥ 30°C
                        <span style="display:inline-block;width:14px;height:14px;border-radius:50%;background:#ffc107;margin-left:8px;"></span> Sedang 15–29°C
                        <span style="display:inline-block;width:14px;height:14px;border-radius:50%;background:#0d6efd;margin-left:8px;"></span> Dingin ≤ 14°C
                    </div>
                    {{-- Progress indicator --}}
                    <div id="weatherMapStatus" class="text-muted" style="font-size:13px;">
                        <span class="spinner-border spinner-border-sm text-danger me-1" role="status"></span>
                        Memuat data cuaca...
                    </div>
                </div>
            </div>

            {{-- Map container --}}
            <div id="weatherMap" style="height:600px;border-radius:12px;overflow:hidden;border:2px solid #e5e5e5;"></div>

            {{-- Stats bar --}}
            <div class="row mt-3 g-2 text-center" id="weatherStats" style="display:none!important;">
                <div class="col-4">
                    <div style="background:#fff5f5;border:1px solid #f5c6c6;border-radius:10px;padding:10px 6px;">
                        <div style="font-size:22px;font-weight:700;color:#dc3545;" id="statHot">0</div>
                        <div style="font-size:12px;color:#666;">🔴 Negara Panas</div>
                    </div>
                </div>
                <div class="col-4">
                    <div style="background:#fffbf0;border:1px solid #ffe58f;border-radius:10px;padding:10px 6px;">
                        <div style="font-size:22px;font-weight:700;color:#c9a000;" id="statWarm">0</div>
                        <div style="font-size:12px;color:#666;">🟡 Negara Sedang</div>
                    </div>
                </div>
                <div class="col-4">
                    <div style="background:#f0f6ff;border:1px solid #b3d0ff;border-radius:10px;padding:10px 6px;">
                        <div style="font-size:22px;font-weight:700;color:#0d6efd;" id="statCold">0</div>
                        <div style="font-size:12px;color:#666;">🔵 Negara Dingin</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

let currencyChartInstance = null;

document.getElementById('currencyCountrySelect').addEventListener('change', function() {
    let countryId = this.value;
    if (!countryId) {
        if (currencyChartInstance) {
            currencyChartInstance.destroy();
            currencyChartInstance = null;
        }
        return;
    }

    fetch('/ui/analytics/currency-history-data?country_id=' + countryId)
        .then(res => res.json())
        .then(data => {
            let labels = data.history.map(d => d.date);
            let rates = data.history.map(d => d.rate);

            let current = data.current;
            if (current) {
                document.getElementById('currencyInfoBoxes').style.setProperty('display', 'flex', 'important');
                document.getElementById('currencyChartLabel').style.display = 'block';
                document.getElementById('cBoxCode').innerText = current.code || '-';
                document.getElementById('cBoxCodeSub').innerText = current.code || '-';
                document.getElementById('cBoxRate').innerText = current.rate || '-';
                
                let riskBadge = document.getElementById('cBoxRisk');
                let riskVal = current.risk || 0;
                riskBadge.innerText = riskVal.toFixed(2);
                riskBadge.className = 'badge fs-6 ' + (riskVal >= 70 ? 'bg-danger' : (riskVal >= 40 ? 'bg-warning text-dark' : 'bg-success'));
            } else {
                document.getElementById('currencyInfoBoxes').style.setProperty('display', 'none', 'important');
                document.getElementById('currencyChartLabel').style.display = 'none';
            }

            if (currencyChartInstance) {
                currencyChartInstance.destroy();
            }

            currencyChartInstance = new Chart(document.getElementById('currencyHistoryChart'), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Exchange Rate',
                        data: rates,
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99,102,241,0.10)',
                        borderWidth: 2,
                        pointRadius: labels.length > 60 ? 0 : 3,
                        pointHoverRadius: 5,
                        fill: true,
                        tension: 0.35,
                    }]
                },
                options: {
                    responsive: true,
                    animation: false,
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
        });
});

new Chart(document.getElementById('gdpChart'), {
    type: 'bar',
    data: {
        labels: [@foreach($gdpRanking as $g)'{{ $g->country->country_name }}',@endforeach],
        datasets: [{ label: 'GDP', data: [@foreach($gdpRanking as $g){{ $g->gdp }},@endforeach], backgroundColor: '#0d6efd' }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});

new Chart(document.getElementById('inflationChart'), {
    type: 'bar',
    data: {
        labels: [@foreach($inflationRanking as $i)'{{ $i->country->country_name }}',@endforeach],
        datasets: [{ label: 'Inflation', data: [@foreach($inflationRanking as $i){{ $i->inflation_rate }},@endforeach], backgroundColor: '#ffc107' }]
    },
    options: { responsive: true, plugins: { legend: { display: false } } }
});

new Chart(document.getElementById('tradeChart'), {
    type: 'bar',
    data: {
        labels: [@foreach($tradeRanking as $t)'{{ $t->country->country_name }}',@endforeach],
        datasets: [
            { label: 'Export', data: [@foreach($tradeRanking as $t){{ $t->export_value }},@endforeach], backgroundColor: '#198754' },
            { label: 'Import', data: [@foreach($tradeRanking as $t){{ $t->import_value }},@endforeach], backgroundColor: '#dc3545' }
        ]
    },
    options: { responsive: true }
});
</script>

<script>

(function () {

    const map = L.map('weatherMap', {
        center: [20, 10],
        zoom: 2,
        zoomControl: true,
        attributionControl: true,
    });
    L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; OpenStreetMap &amp; CARTO',
        subdomains: 'abcd',
        maxZoom: 19
    }).addTo(map);

    function getColor(temp) {
        if (temp === null || temp === undefined) return '#6c757d';
        if (temp >= 30)  return '#dc3545';
        if (temp >= 15)  return '#ffc107';
        return '#0d6efd';
    }

    function getTempLabel(temp) {
        if (temp === null || temp === undefined) return 'N/A';
        if (temp >= 30)  return '🔴 Panas';
        if (temp >= 15)  return '🟡 Sedang';
        return '🔵 Dingin';
    }

    function getRadius(riskScore) {
        if (!riskScore) return 8;
        return Math.max(6, Math.min(18, riskScore / 6));
    }

    async function fetchWeatherBatch(countries, batchSize = 10) {
        const statusEl = document.getElementById('weatherMapStatus');
        const statsEl  = document.getElementById('weatherStats');
        let loaded = 0;
        let hot = 0, warm = 0, cold = 0;
        const total = countries.length;
        const markers = {};
        countries.forEach(c => {
            const marker = L.circleMarker([c.lat, c.lng], {
                radius: getRadius(c.risk_score),
                fillColor: getColor(c.temperature),
                color: '#fff',
                weight: 1.2,
                opacity: 0.9,
                fillOpacity: 0.82,
            }).addTo(map);
            marker.bindPopup(buildPopup(c, c.temperature, null, null));
            markers[c.id] = { marker, data: c };
            if (c.temperature !== null && c.temperature !== undefined) {
                if (c.temperature >= 30) hot++;
                else if (c.temperature >= 15) warm++;
                else cold++;
            }
        });

        updateStats(hot, warm, cold);
        for (let i = 0; i < countries.length; i += batchSize) {
            const batch = countries.slice(i, i + batchSize);

            await Promise.all(batch.map(async (c) => {
                try {
                    const url = `https://api.open-meteo.com/v1/forecast`
                        + `?latitude=${c.lat}&longitude=${c.lng}`
                        + `&current=temperature_2m,rain,wind_speed_10m`
                        + `&timezone=auto`;

                    const res  = await fetch(url);
                    const json = await res.json();

                    const temp  = json?.current?.temperature_2m ?? null;
                    const rain  = json?.current?.rain ?? null;
                    const wind  = json?.current?.wind_speed_10m ?? null;
                    const oldTemp = markers[c.id].data.temperature;
                    if (oldTemp !== null && oldTemp !== undefined) {
                        if (oldTemp >= 30) hot--;
                        else if (oldTemp >= 15) warm--;
                        else cold--;
                    }
                    if (temp !== null) {
                        if (temp >= 30) hot++;
                        else if (temp >= 15) warm++;
                        else cold++;
                    }
                    markers[c.id].marker
                        .setStyle({
                            fillColor: getColor(temp),
                            color: '#fff',
                        })
                        .setPopupContent(buildPopup(c, temp, rain, wind));

                    markers[c.id].data.temperature = temp;

                    updateStats(hot, warm, cold);
                } catch (e) {
                }

                loaded++;
                const pct = Math.round((loaded / total) * 100);
                statusEl.innerHTML = `<span class="text-muted" style="font-size:13px;">Memuat cuaca… ${loaded}/${total} (${pct}%)</span>`;
            }));
            if (i + batchSize < countries.length) {
                await new Promise(r => setTimeout(r, 120));
            }
        }

        statusEl.innerHTML = `<span class="text-success" style="font-size:13px;">✅ ${total} negara dimuat · diperbarui baru saja</span>`;
        statsEl.style.setProperty('display', 'flex', 'important');
        statsEl.classList.remove('d-none');
        statsEl.style.display = '';
    }

    function buildPopup(c, temp, rain, wind)
{
    temp =
        temp !== null &&
        temp !== undefined
            ? parseFloat(temp)
            : null;

    rain =
        rain !== null &&
        rain !== undefined
            ? parseFloat(rain)
            : null;

    wind =
        wind !== null &&
        wind !== undefined
            ? parseFloat(wind)
            : null;

    const tempStr =
        temp !== null &&
        !isNaN(temp)
            ? `${temp.toFixed(1)} °C`
            : (
                c.temperature !== null &&
                c.temperature !== undefined
            )
                ? `${parseFloat(c.temperature).toFixed(1)} °C`
                : 'N/A';

    const rainStr =
        rain !== null &&
        !isNaN(rain)
            ? `${rain.toFixed(1)} mm`
            : (
                c.rainfall !== null &&
                c.rainfall !== undefined
            )
                ? `${parseFloat(c.rainfall).toFixed(1)} mm`
                : 'N/A';

    const windStr =
        wind !== null &&
        !isNaN(wind)
            ? `${wind.toFixed(1)} km/h`
            : (
                c.wind_speed !== null &&
                c.wind_speed !== undefined
            )
                ? `${parseFloat(c.wind_speed).toFixed(1)} km/h`
                : 'N/A';

    const riskStr =
        c.risk_score ?? 'N/A';

    const label =
        getTempLabel(
            temp !== null
                ? temp
                : parseFloat(c.temperature)
        );

    return `
        <div style="min-width:220px;">
            <h6 style="display:flex;align-items:center;gap:6px;">
                ${c.iso2 ? `<img src="https://flagcdn.com/20x15/${c.iso2.toLowerCase()}.png" style="border-radius:2px;vertical-align:middle;" onerror="this.style.display='none'">` : ''}
                ${c.name}
            </h6>

            <p style="margin-bottom:6px;">
                ${label}
            </p>

            <table style="width:100%;font-size:13px;">
                <tr>
                    <td>Temp</td>
                    <td>${tempStr}</td>
                </tr>

                <tr>
                    <td>Rain</td>
                    <td>${rainStr}</td>
                </tr>

                <tr>
                    <td>Wind</td>
                    <td>${windStr}</td>
                </tr>

                <tr>
                    <td>Risk</td>
                    <td>${riskStr}</td>
                </tr>
            </table>
        </div>
    `;
}
    function updateStats(hot, warm, cold) {
        document.getElementById('statHot').textContent  = hot;
        document.getElementById('statWarm').textContent = warm;
        document.getElementById('statCold').textContent = cold;
        const statsEl = document.getElementById('weatherStats');
        statsEl.style.cssText = 'display:flex!important;';
    }

    fetch('/ui/analytics/weather-map-data')
        .then(r => r.json())
        .then(countries => {
            if (!countries.length) {
                document.getElementById('weatherMapStatus').innerHTML =
                    '<span class="text-danger">Tidak ada data negara dengan koordinat.</span>';
                return;
            }
            fetchWeatherBatch(countries, 10);
        })
        .catch(err => {
            document.getElementById('weatherMapStatus').innerHTML =
                '<span class="text-danger">Gagal memuat data negara.</span>';
            console.error(err);
        });

})();
</script>

<script>

document
.getElementById(
'compareBtn'
)
.addEventListener(
'click',
function(){

let countryA =
document
.getElementById(
'countryA'
)
.value;

let countryB =
document
.getElementById(
'countryB'
)
.value;

if(
!countryA ||
!countryB
){
alert(
'Please select both countries'
);
return;
}

fetch(
`/comparison/data?country_a=${countryA}&country_b=${countryB}`
)

.then(
response =>
response.json()
)

.then(data => {

let a = data.a;
let b = data.b;

const formatUsd = (val) => {
    if (val === null || val === undefined) return '$0.00';
    return new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(val);
};

document
.getElementById(
'comparisonResult'
)
.innerHTML = `

<div class="card card-custom p-4">

<h5 class="mb-4">
Comparison Result
</h5>

<div class="table-responsive">

<table class="table table-bordered">

<tr>
<th>Metric</th>
<th>
    ${a.iso2 ? `<img src="https://flagcdn.com/20x15/${a.iso2.toLowerCase()}.png" style="border-radius:2px;vertical-align:middle;margin-right:5px;" onerror="this.style.display='none'">` : ''}
    ${a.country_name}
</th>
<th>
    ${b.iso2 ? `<img src="https://flagcdn.com/20x15/${b.iso2.toLowerCase()}.png" style="border-radius:2px;vertical-align:middle;margin-right:5px;" onerror="this.style.display='none'">` : ''}
    ${b.country_name}
</th>
</tr>

<tr>
<td>GDP</td>
<td>${formatUsd(a.economic_indicator?.gdp)}</td>
<td>${formatUsd(b.economic_indicator?.gdp)}</td>
</tr>

<tr>
<td>Inflation</td>
<td>${a.economic_indicator?.inflation_rate ?? 0}%</td>
<td>${b.economic_indicator?.inflation_rate ?? 0}%</td>
</tr>

<tr>
<td>Export Value</td>
<td>${formatUsd(a.economic_indicator?.export_value)}</td>
<td>${formatUsd(b.economic_indicator?.export_value)}</td>
</tr>

<tr>
<td>Import Value</td>
<td>${formatUsd(a.economic_indicator?.import_value)}</td>
<td>${formatUsd(b.economic_indicator?.import_value)}</td>
</tr>

<tr>
<td>Total Risk</td>
<td>${a.risk_score?.total_score ?? 0}</td>
<td>${b.risk_score?.total_score ?? 0}</td>
</tr>

<tr>
<td>Weather Risk</td>
<td>${a.risk_score?.weather_score ?? 0}</td>
<td>${b.risk_score?.weather_score ?? 0}</td>
</tr>

<tr>
<td>Currency Risk</td>
<td>${a.risk_score?.currency_score ?? 0}</td>
<td>${b.risk_score?.currency_score ?? 0}</td>
</tr>

<tr>
<td>Inflation Risk</td>
<td>${a.risk_score?.inflation_score ?? 0}</td>
<td>${b.risk_score?.inflation_score ?? 0}</td>
</tr>

<tr>
<td>News Risk</td>
<td>${a.risk_score?.news_score ?? 0}</td>
<td>${b.risk_score?.news_score ?? 0}</td>
</tr>

<tr>
<td>Port Risk</td>
<td>${a.risk_score?.port_score ?? 0}</td>
<td>${b.risk_score?.port_score ?? 0}</td>
</tr>

<tr>
<td>Risk Level</td>
<td>${a.risk_score?.risk_level ?? '-'}</td>
<td>${b.risk_score?.risk_level ?? '-'}</td>
</tr>

</table>
</div>
</div>
`;
});
}
);
</script>
@endsection