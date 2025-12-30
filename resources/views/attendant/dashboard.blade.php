@extends('layouts.app')

@section('content')
<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 20px;
    }

    .dashboard-container {
        max-width: 1400px;
        margin: 0 auto;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 35px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .header-content h1 {
        font-size: 32px;
        color: #2c3e50;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .header-content p {
        font-size: 14px;
        color: #7f8c8d;
    }

    .header-actions {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 20px;
        font-size: 13px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
    }

    .btn-primary {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.6);
    }

    .btn-secondary {
        background: white;
        color: #10b981;
        border: 2px solid #10b981;
    }

    .btn-secondary:hover {
        background: #f0fdf4;
        transform: translateY(-2px);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        border-left: 4px solid;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(16, 185, 129, 0.05) 0%, transparent 70%);
        border-radius: 50%;
    }

    .stat-card.sales {
        border-left-color: #10b981;
    }

    .stat-card.litres {
        border-left-color: #059669;
    }

    .stat-card.entries {
        border-left-color: #34d399;
    }

    .stat-label {
        font-size: 13px;
        color: #95a5a6;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 12px;
    }

    .stat-value {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        position: relative;
        z-index: 1;
        margin-bottom: 10px;
    }

    .stat-spark {
        position: relative;
        z-index: 1;
    }

    .stat-spark canvas {
        max-width: 120px;
        max-height: 35px;
    }

    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        padding: 25px;
        transition: all 0.3s ease;
        margin-bottom: 30px;
    }

    .card:hover {
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
    }

    .card-title {
        font-size: 18px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-title::before {
        content: '';
        width: 4px;
        height: 20px;
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        border-radius: 2px;
    }

    .table-container {
        overflow-x: auto;
        margin-bottom: 20px;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .table thead th {
        padding: 14px;
        text-align: left;
        font-weight: 600;
        letter-spacing: 0.3px;
    }

    .table tbody tr {
        border-bottom: 1px solid #ecf0f1;
        transition: all 0.2s ease;
    }

    .table tbody tr:hover {
        background: #f0fdf4;
    }

    .table tbody td {
        padding: 12px 14px;
        color: #2c3e50;
    }

    .no-data {
        text-align: center;
        color: #bdc3c7;
        padding: 30px 20px;
    }

    @media (max-width: 768px) {
        .header-section {
            flex-direction: column;
            align-items: flex-start;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
    

    .modal-backdrop {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
        z-index: 999;
        animation: fadeIn 0.3s ease;
    }

    .modal-backdrop.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .modal {
        background: white;
        border-radius: 12px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        padding: 0;
        max-width: 900px;
        width: 90%;
        max-height: 90vh;
        display: flex;
        flex-direction: column;
        animation: slideUp 0.3s ease;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid #ecf0f1;
    }

    .modal-header h2 {
        font-size: 20px;
        color: #2c3e50;
        font-weight: 700;
        margin: 0;
    }

    .modal-close {
        background: none;
        border: none;
        font-size: 28px;
        color: #7f8c8d;
        cursor: pointer;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
    }

    .modal-close:hover {
        color: #667eea;
        transform: rotate(90deg);
    }

    .modal-content {
        flex: 1;
        overflow-y: auto;
        padding: 25px;
    }

    .modal-footer {
        padding: 15px 25px;
        border-top: 1px solid #ecf0f1;
        display: flex;
        gap: 10px;
        justify-content: flex-end;
    }

    .modal-footer .btn {
        padding: 8px 16px;
        font-size: 12px;
    }

    .btn-cancel {
        background: rgb(63, 3, 3);
        color: #2c3e50;
        border: 2px solid #ecf0f1;
    }

    .btn-cancel:hover {
        border-color: #10b981;
        color: #667eea;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
    }

    .modal-content iframe {
        width: 100%;
        border: none;
        height: 500px;
    }

    .dashboard-container.blur {
        filter: blur(3px);
        pointer-events: none;
    }
</style>

<div class="dashboard-container">
    <div class="header-section">
        <div class="header-content">
            <h1>Welcome</h1>
            <p>Quick access to record sales and view your recent activity</p>
        </div>
        
    </div>
@foreach($currentShifts as $shift)

    <p>
        <strong>Attendant:</strong> {{ $shift->user->name }} |
        <strong>Pump:</strong> {{ $shift->pump->name }} |
        <strong>Period:</strong> {{ ucfirst($shift->shift_period) }}
    </p>

    @if($shift->status === 'closed')
        <p><strong>Meter Litres:</strong> {{ number_format($shift->meter_litres ?? 0, 2) }}</p>
<p><strong>System Litres:</strong> {{ number_format($shift->system_litres ?? 0, 2) }}</p>
<p><strong>Difference:</strong> {{ number_format($shift->difference ?? 0, 2) }}</p>
<p><strong>Total Amount:</strong> {{ number_format($shift->total_amount ?? 0, 2) }}</p>

    @endif
@endforeach
    <div class="stats-grid">
        <div class="stat-card sales">
            <div class="stat-label">Your Total Sales</div>
            <div class="stat-value">{{ number_format($totalSales,2) }}</div>
            <div class="stat-spark">
                <canvas id="attendantSpark" style="width: 100%; max-width: 150px; height: 40px;"></canvas>
            </div>
        </div>



        <div class="stat-card litres">
            <div class="stat-label">Your Litres Sold</div>
            <div class="stat-value">{{ $totalLitres }} L</div>
        </div>

        <div class="stat-card entries">
            <div class="stat-label">Recent Entries</div>
            <div class="stat-value">{{ $mySales->count() }}</div>
        </div>
    </div>

    <div class="card">
        <h3 class="card-title">Your Recent Sales</h3>
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
                    </tr>
                </thead>
                <tbody>
                    @forelse($mySales as $sale)
                    <tr>
                        <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                        <td>{{ optional($sale->pump)->name }} {{ optional($sale->pump)->code ? '('.optional($sale->pump)->code.')' : '' }}</td>
                        <td>{{ optional($sale->fuel)->name }}</td>
                        <td>{{number_format(optional($sale->pump)->price_per_litre ?? 0, 2) }}</td>
                        <td>{{ $sale->litres_sold }}</td>
                        <td>{{ number_format($sale->amount,2) }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="no-data">No recent sales</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const sparkDates = @json($sparkDates ?? []);
    const sparkValues = @json($sparkValues ?? []);
    if (document.getElementById('attendantSpark')) {
        const sctx = document.getElementById('attendantSpark').getContext('2d');
        new Chart(sctx, {
            type: 'line',
            data: { labels: sparkDates, datasets: [{ data: sparkValues, borderColor: '#6366f1', backgroundColor: 'rgba(99,102,241,0.08)', fill: true, tension: 0.3, pointRadius: 0 }] },
            options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { display: false }, y: { display: false } } }
        });
    }
</script>
@endsection
