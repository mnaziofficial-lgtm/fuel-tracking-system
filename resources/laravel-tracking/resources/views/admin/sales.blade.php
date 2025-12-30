@extends('layouts.app')

@section('content')
<style>
    .sales-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .sales-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .sales-header h2 {
        font-size: 24px;
        color: #2c3e50;
    }

    .sales-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .sales-table thead {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    }

    .sales-table th, .sales-table td {
        padding: 12px;
        text-align: left;
        border-bottom: 1px solid #ecf0f1;
    }

    .sales-table tbody tr:hover {
        background: #f8f9ff;
    }

    .pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #ecf0f1;
    }

    .pagination-info {
        font-size: 13px;
        color: #7f8c8d;
    }

    .pagination-buttons {
        display: flex;
        gap: 8px;
    }

    .pagination-buttons button {
        padding: 8px 14px;
        border: 2px solid #ecf0f1;
        background: white;
        color: #2c3e50;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        font-size: 12px;
    }

    .pagination-buttons button:hover:not(:disabled) {
        border-color: #667eea;
        color: #667eea;
        transform: translateY(-2px);
    }

    .pagination-buttons button:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
</style>

<div class="sales-container">
    <div class="sales-header">
        <h2>Sales Records</h2>
        <a href="{{ route('admin.sales.create') }}" class="btn btn-primary">Add New Sale</a>
    </div>

    <table class="sales-table">
        <thead>
            <tr>
                <th>Date</th>
                <th>Pump</th>
                <th>Fuel</th>
                <th>Price/L (TSH)</th>
                <th>Litres</th>
                <th>Amount (TSH)</th>
                <th>Attendant</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $sale)
            <tr>
                <td>{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                <td>{{ optional($sale->pump)->name }} {{ optional($sale->pump)->code ? '('.optional($sale->pump)->code.')' : '' }}</td>
                <td>{{ optional($sale->fuel)->name }}</td>
                <td>{{ number_format(optional($sale->pump)->price_per_litre ?? 0, 2) }}</td>
                <td>{{ $sale->litres_sold }}</td>
                <td>{{ number_format($sale->amount, 2) }}</td>
                <td>
                    <a href="{{ route('admin.sales.edit', $sale) }}" class="text-indigo-600 hover:underline">Edit</a>
                    <form action="{{ route('admin.sales.destroy', $sale) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="no-data">No sales records found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="pagination">
        <div class="pagination-info">{{ $sales->links() }}</div>
        <div class="pagination-buttons">
            <button id="prevPage" {{ $sales->onFirstPage() ? 'disabled' : '' }}>← Previous</button>
            <button id="nextPage" {{ $sales->hasMorePages() ? '' : 'disabled' }}>Next →</button>
        </div>
    </div>
</div>
@endsection