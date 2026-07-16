@extends('layouts.app')

@section('content')

{{-- Top Bar --}}
<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

    <h2 class="page-title mb-0">Global Risk Dashboard</h2>

    {{-- Currency Converter Widget --}}
    <div id="currency-converter-widget" style="
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 10px 14px;
        display: flex;
        flex-direction: column;
        gap: 0;
        box-shadow: 0 4px 18px rgba(0,0,0,0.09);
        min-width: 360px;
        max-width: 440px;
        position: relative;
    ">
        {{-- Row 1: Result (From currency) --}}
        <div style="display:flex;align-items:center;gap:0;border:1px solid #e2e8f0;border-radius:10px;overflow:hidden;background:#fff;">
            <div id="cc-result" title="" style="
                flex: 1;
                padding: 10px 14px;
                font-size: 1rem;
                font-weight: 600;
                color: #1e293b;
                background: #fff;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                min-width: 0;
            ">—</div>
            <div style="width:1px;background:#e2e8f0;align-self:stretch;flex-shrink:0;"></div>
            <select id="cc-from" style="
                border: none;
                outline: none;
                background: #fff;
                color: #334155;
                padding: 10px 12px;
                font-size: 0.88rem;
                font-weight: 500;
                cursor: pointer;
                min-width: 170px;
                max-width: 200px;
            "></select>
        </div>

        {{-- Swap button (centre) --}}
        <div style="display:flex;justify-content:center;margin:4px 0;z-index:1;">
            <button id="cc-swap" title="Swap" style="
                background: #f1f5f9;
                border: 1px solid #cbd5e1;
                border-radius: 50%;
                width: 28px; height: 28px;
                cursor: pointer;
                color: #475569;
                font-size: 0.85rem;
                display:flex;align-items:center;justify-content:center;
                transition: background 0.18s;
                flex-shrink:0;
            " onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">⇄</button>
        </div>

        {{-- Row 2: Input (To currency) — blue border active --}}
        <div style="display:flex;align-items:center;gap:0;border:2px solid #3b82f6;border-radius:10px;overflow:hidden;background:#fff;">
            <input type="number" id="cc-amount" value="1" min="0" step="any" style="
                flex: 1;
                border: none;
                outline: none;
                padding: 10px 14px;
                font-size: 1rem;
                font-weight: 600;
                color: #1e293b;
                background: #fff;
                min-width: 0;
            ">
            <div style="width:1px;background:#bfdbfe;align-self:stretch;flex-shrink:0;"></div>
            <select id="cc-to" style="
                border: none;
                outline: none;
                background: #fff;
                color: #334155;
                padding: 10px 12px;
                font-size: 0.88rem;
                font-weight: 500;
                cursor: pointer;
                min-width: 170px;
                max-width: 200px;
            "></select>
        </div>
    </div>


    {{-- Search --}}
    <div style="width:280px; position:relative;">
        <input
            type="text"
            class="form-control"
            id="countrySearch"
            placeholder="Search any country..."
        >
        <div
            id="searchResults"
            class="list-group"
            style="position:absolute; width:100%; z-index:999;"
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
    <h4 class="mb-4">Best Countries For Import</h4>

<table class="table table-hover">
<thead>
<tr>
    <th>#</th>
    <th>Country</th>
    <th>Recommendation Score</th>
    <th>Status</th>
</tr>
</thead>
<tbody>

@foreach($recommendedCountries as $index => $country)

<tr>
<td>{{ $index + 1 }}</td>
<td>{{ $country->country->country_name }}</td>
<td>{{ number_format($country->recommendation_score,2) }}</td>
<td>

@if($country->recommendation_score >= 70)

<span class="badge bg-success">
Highly Recommended
</span>

@elseif($country->recommendation_score >= 50)

<span class="badge bg-warning text-dark">
Recommended
</span>

@else

<span class="badge bg-danger">
Not Recommended
</span>

@endif

</td>
</tr>

@endforeach

</tbody>
</table>
</div>
</div>

<div class="row g-3 mt-4">
<div class="col-md-6">
        <div class="card card-custom p-4">
            <h5 class="mb-3">Top Risk Countries</h5>
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
                        <a href="/ui/countries/{{ $risk->country_id }}">
                            {{ $risk->country->country_name }}
                        </a>
                    </td>
                    <td>{{ $risk->total_score }}</td>
                    <td>{{ $risk->risk_level }}</td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <div class="col-md-6">
        <div class="card card-custom p-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Recent Alerts</h5>
                <div class="d-flex align-items-center gap-2">
                    <span id="alerts-page-info" style="font-size:0.8rem;color:#94a3b8;"></span>
                    <button id="alerts-prev" onclick="changeAlertsPage(-1)" style="
                        background: rgba(99,102,241,0.15);
                        border: 1px solid rgba(99,102,241,0.4);
                        border-radius: 8px;
                        color: #a5b4fc;
                        padding: 4px 10px;
                        cursor: pointer;
                        font-size: 0.85rem;
                        transition: background 0.2s;
                    ">&lt;</button>
                    <button id="alerts-next" onclick="changeAlertsPage(1)" style="
                        background: rgba(99,102,241,0.15);
                        border: 1px solid rgba(99,102,241,0.4);
                        border-radius: 8px;
                        color: #a5b4fc;
                        padding: 4px 10px;
                        cursor: pointer;
                        font-size: 0.85rem;
                        transition: background 0.2s;
                    ">&gt;</button>
                </div>
            </div>

            <div id="alerts-list">
                @foreach($alerts as $alert)
                <div class="alert-item border-bottom pb-2 mb-2" data-index="{{ $loop->index }}" style="display:none;">
                    <div class="d-flex align-items-start gap-2">
                        <span style="
                            width:8px;height:8px;
                            border-radius:50%;
                            background:#f87171;
                            flex-shrink:0;
                            margin-top:5px;
                        "></span>
                        <div>
                            <strong style="font-size:0.9rem;">{{ $alert->country->country_name ?? 'Global' }}</strong>
                            <br>
                            <small style="color:#94a3b8;">{{ $alert->message }}</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </div>

</div>

@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

fetch('/dashboard/distribution')
.then(r => r.json())
.then(data => {
    const ctx = document.getElementById('riskChart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Low','Medium','High'],
            datasets: [{
                label: 'Risk Distribution',
                data: [data.low, data.medium, data.high],
                backgroundColor: ['#198754','#d4a017','#6d071a'],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });
});

document.getElementById('countrySearch').addEventListener('keyup', function(){
    let keyword = this.value;
    if(keyword.length < 2){ return; }
    fetch('/countries/search?q=' + keyword)
    .then(r => r.json())
    .then(data => {
        let html = '';
        data.forEach(country => {
            html += `<a href="/ui/countries/${country.id}" class="list-group-item list-group-item-action">${country.country_name}</a>`;
        });
        document.getElementById('searchResults').innerHTML = html;
    });
});

const ALERTS_PER_PAGE = 7;
let alertsPage = 0;

function renderAlerts() {
    const items = document.querySelectorAll('#alerts-list .alert-item');
    const total = items.length;
    const totalPages = Math.ceil(total / ALERTS_PER_PAGE);
    const start = alertsPage * ALERTS_PER_PAGE;
    const end   = start + ALERTS_PER_PAGE;

    items.forEach((el, i) => {
        el.style.display = (i >= start && i < end) ? 'block' : 'none';
    });

    document.getElementById('alerts-page-info').textContent =
        total > 0 ? `${alertsPage + 1} / ${totalPages}` : '';

    const prevBtn = document.getElementById('alerts-prev');
    const nextBtn = document.getElementById('alerts-next');
    prevBtn.disabled = alertsPage === 0;
    nextBtn.disabled = alertsPage >= totalPages - 1;
    prevBtn.style.opacity = prevBtn.disabled ? '0.35' : '1';
    nextBtn.style.opacity = nextBtn.disabled ? '0.35' : '1';
    prevBtn.style.cursor  = prevBtn.disabled ? 'not-allowed' : 'pointer';
    nextBtn.style.cursor  = nextBtn.disabled ? 'not-allowed' : 'pointer';
}

function changeAlertsPage(dir) {
    const total = document.querySelectorAll('#alerts-list .alert-item').length;
    const totalPages = Math.ceil(total / ALERTS_PER_PAGE);
    alertsPage = Math.max(0, Math.min(totalPages - 1, alertsPage + dir));
    renderAlerts();
}

document.addEventListener('DOMContentLoaded', renderAlerts);

const CC_API = 'https://open.er-api.com/v6/latest/USD';
let ccRates  = {};

const popularCurrencies = [
    ['USD','US Dollar'],['EUR','Euro'],['GBP','British Pound'],
    ['JPY','Japanese Yen'],['IDR','Indonesian Rupiah'],['CNY','Chinese Yuan'],
    ['AUD','Australian Dollar'],['CAD','Canadian Dollar'],['CHF','Swiss Franc'],
    ['SGD','Singapore Dollar'],['MYR','Malaysian Ringgit'],['KRW','South Korean Won'],
    ['INR','Indian Rupee'],['HKD','Hong Kong Dollar'],['SAR','Saudi Riyal'],
    ['AED','UAE Dirham'],['THB','Thai Baht'],['PHP','Philippine Peso'],
    ['VND','Vietnamese Dong'],['BRL','Brazilian Real'],['MXN','Mexican Peso'],
    ['ZAR','South African Rand'],['TRY','Turkish Lira'],['NOK','Norwegian Krone'],
    ['SEK','Swedish Krona'],['DKK','Danish Krone'],['NZD','New Zealand Dollar'],
];

function populateCurrencySelects(fromVal='IDR', toVal='USD') {
    const from = document.getElementById('cc-from');
    const to   = document.getElementById('cc-to');
    from.innerHTML = '';
    to.innerHTML   = '';
    popularCurrencies.forEach(([code, name]) => {
        const optF = new Option(`${code} – ${name}`, code);
        const optT = new Option(`${code} – ${name}`, code);
        if(code === fromVal) optF.selected = true;
        if(code === toVal)   optT.selected = true;
        from.add(optF);
        to.add(optT);
    });
}

function formatCCResult(num) {
    if (num === 0) return '0';
    const abs = Math.abs(num);
    if (abs < 0.0001)      return num.toLocaleString('en-US', { maximumSignificantDigits: 6 });
    if (abs < 1)           return num.toLocaleString('en-US', { maximumFractionDigits: 6 });
    if (abs < 1_000)       return num.toLocaleString('en-US', { maximumFractionDigits: 4 });
    if (abs < 1_000_000)   return num.toLocaleString('en-US', { maximumFractionDigits: 2 });
    if (abs < 1_000_000_000) {
        return (num / 1_000_000).toLocaleString('en-US', { maximumFractionDigits: 3 }) + ' M';
    }
    return (num / 1_000_000_000).toLocaleString('en-US', { maximumFractionDigits: 3 }) + ' B';
}

function convertCurrency() {
    const amount       = parseFloat(document.getElementById('cc-amount').value) || 0;
    const inputCurr    = document.getElementById('cc-to').value;   // bottom row = user types THIS currency
    const resultCurr   = document.getElementById('cc-from').value; // top row    = shows result IN this currency
    const el           = document.getElementById('cc-result');

    if(!ccRates[inputCurr] || !ccRates[resultCurr]) { el.textContent = '—'; el.title = ''; return; }

    const inUSD  = amount / ccRates[inputCurr];
    const result = inUSD * ccRates[resultCurr];

    el.textContent = formatCCResult(result);
    el.title = result.toLocaleString('en-US', { maximumFractionDigits: 8 });
}

fetch(CC_API)
.then(r => r.json())
.then(data => {
    if(data.result === 'success') {
        ccRates = data.rates;  
        populateCurrencySelects('IDR', 'USD');
        convertCurrency();

        document.getElementById('cc-amount').addEventListener('input', convertCurrency);
        document.getElementById('cc-from').addEventListener('change', convertCurrency);
        document.getElementById('cc-to').addEventListener('change', convertCurrency);
        document.getElementById('cc-swap').addEventListener('click', () => {
            const fromSel = document.getElementById('cc-from');
            const toSel   = document.getElementById('cc-to');
            const tmp     = fromSel.value;
            fromSel.value = toSel.value;
            toSel.value   = tmp;
            convertCurrency();
        });
    }
})
.catch(() => {
    document.getElementById('cc-result').textContent = 'N/A';
});

</script>
@endsection

