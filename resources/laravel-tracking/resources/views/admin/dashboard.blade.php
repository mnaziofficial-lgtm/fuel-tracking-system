@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

<div class="dashboard-container">
    <div class="header-section">
        <div class="header-content">
            <h1>Welcome</h1>
            <p>Overview of sales, fuel stock and recent activity</p>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card sales">
            <div class="stat-label">Total Sales</div>
            <div class="stat-value">{{ number_format($totalSales,2) }}</div>
        </div>

        <div class="stat-card litres">
            <div class="stat-label">Total Litres</div>
            <div class="stat-value">{{ $totalLitres }} L</div>
        </div>

        <div class="stat-card fuels">
            <div class="stat-label">Fuel Types</div>
            <div class="stat-value">{{ $fuels->count() }}</div>
        </div>
    </div>

    <div class="main-content">
        <div class="card">
            <h3 class="card-title">Sales </h3>
            <div class="chart-controls">
                <span class="chart-label">Date Range:</span>
                <div class="form-group">
                    <input type="date" id="fromDate" value="{{ $dates[0] ?? \Carbon\Carbon::today()->format('Y-m-d') }}">
                    <input type="date" id="toDate" value="{{ $dates[count($dates)-1] ?? \Carbon\Carbon::today()->format('Y-m-d') }}">
                    <button id="applyRange" class="btn-small apply">Apply</button>
                    <button id="exportExcel" class="btn-small">Export Excel</button>
                    <button id="exportPdf" class="btn-small">Export PDF</button>
                </div>
            </div>
            <div style="position: relative; height: 350px; width: 100%;">
                <canvas id="adminSalesChart"></canvas>
            </div>
        </div>

        <div class="card">
            <h3 class="card-title">Fuel Stock</h3>
            <div class="fuel-list">
                @forelse($fuels as $fuel)
                    <div class="fuel-item">
                        <div class="fuel-info">
                            <div class="fuel-name">{{ $fuel->name }}</div>
                            <div class="fuel-price">{{ $fuel->price_per_litre }} / L</div>
                        </div>
                        <div class="fuel-stock">{{ $fuel->total_stock }} L</div>
                    </div>
                @empty
                    <p>No fuel in stock</p>
                @endforelse
            </div>
        </div>
    </div>

    <div class="card">
        @if(!empty($lowStockPumps) && $lowStockPumps->count())
        <div class="card mb-4">
            <h3 class="card-title">Low Stock Alerts</h3>
            <div class="fuel-list">
                @foreach($lowStockPumps as $lp)
                    <div class="fuel-item">
                        <div class="fuel-info">
                            <div class="fuel-name">{{ $lp->name }} {{ $lp->code ? '('.$lp->code.')' : '' }}</div>
                            <div class="fuel-price">{{ number_format($lp->price_per_litre,2) }} / L</div>
                        </div>
                        <div class="fuel-stock">{{ $lp->stock }} L</div>
                        <div class="ml-3"><a href="{{ route('admin.pumps.edit', $lp) }}" class="text-indigo-600 hover:underline">Manage</a></div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <h3 class="card-title">Recent Sales</h3>
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Pump</th>
                        <th>Fuel</th>
                        <th>Price/L(TSH)</th>
                        <th>Litres</th>
                        <th>Amount(TSH)</th>
                        <th>Attendant</th>
                    </tr>
                </thead>
                <tbody id="recentSalesBody">
                    @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ optional($sale->pump)->name }} {{ optional($sale->pump)->code ? '('.optional($sale->pump)->code.')' : '' }}</td>
                        <td>{{ optional($sale->fuel)->name }}</td>
                        <td>{{number_format(optional($sale->pump)->price_per_litre ?? 0, 2) }}</td>
                        <td>{{ $sale->litres_sold }}</td>
                        <td>{{ number_format($sale->amount,2) }}</td>
                        <td>{{ optional($sale->user)->name }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="7" class="no-data">No recent sales</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination">
            <div class="pagination-info" id="recentSalesInfo">&nbsp;</div>
            <div class="pagination-buttons">
                <button id="recentPrev">← Previous</button>
                <button id="recentNext">Next →</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
const ctx = document.getElementById('adminSalesChart').getContext('2d');
const adminSalesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($dates) !!},
        datasets: [
            { label: 'Sales Amount (TSH)', data: {!! json_encode($chartAmounts) !!}, yAxisID: 'y-amount', borderColor: '#3b82f6', backgroundColor: '#3b82f6', fill: false, tension: 0.15, pointRadius: 2 },
            { label: 'Litres Sold (L)', data: {!! json_encode($chartLitres) !!}, yAxisID: 'y-litres', borderColor: '#10b981', backgroundColor: '#10b981', fill: false, tension: 0.15, pointRadius: 2 }
        ]
    },
    options: { responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false }, scales: { 'y-amount': { type: 'linear', position: 'left', min: 0, title: { display: true, text: 'TSH' } }, 'y-litres': { type: 'linear', position: 'right', grid: { drawOnChartArea: false }, title: { display: true, text: 'Litres' } } }, plugins: { legend: { position: 'top' } } }
});
</script>
@endsection