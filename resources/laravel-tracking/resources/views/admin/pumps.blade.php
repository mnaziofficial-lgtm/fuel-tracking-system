@extends('layouts.app')

@section('content')
<style>
    .pumps-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .header-title {
        font-size: 28px;
        color: #2c3e50;
        font-weight: 700;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .btn {
        padding: 10px 15px;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
        font-weight: 600;
    }

    .btn-add {
        background: linear-gradient(135deg, #28a745 0%, #218838 100%);
        color: white;
    }

    .btn-add:hover {
        background: linear-gradient(135deg, #218838 0%, #28a745 100%);
    }

    .table-container {
        margin-top: 20px;
        overflow-x: auto;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .table thead {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
    }

    .table thead th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
    }

    .table tbody tr {
        border-bottom: 1px solid #ecf0f1;
    }

    .table tbody tr:hover {
        background: #f1f1f1;
    }

    .table tbody td {
        padding: 10px;
        color: #2c3e50;
    }

    .no-data {
        text-align: center;
        color: #bdc3c7;
        padding: 20px;
    }
</style>

<div class="pumps-container">
    <div class="header-section">
        <h1 class="header-title">Manage Fuel Pumps</h1>
        <div class="header-actions">
            <a href="{{ route('admin.pumps.create') }}" class="btn btn-add">Add New Pump</a>
        </div>
    </div>

    <div class="table-container">
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Price per Litre (TSH)</th>
                    <th>Total Stock (L)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pumps as $pump)
                <tr>
                    <td>{{ $pump->name }}</td>
                    <td>{{ $pump->code }}</td>
                    <td>{{ number_format($pump->price_per_litre, 2) }}</td>
                    <td>{{ $pump->total_stock }} L</td>
                    <td>
                        <a href="{{ route('admin.pumps.edit', $pump) }}" class="btn btn-edit">Edit</a>
                        <form action="{{ route('admin.pumps.destroy', $pump) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="no-data">No fuel pumps available</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection