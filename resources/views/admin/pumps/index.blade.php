@extends('layouts.app')

@section('content')
<style>
.page-wrapper {
    padding: 30px;
    background: #f1f5f9;
    min-height: 100vh;
}

.list-card {
    background: #fff;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 15px 40px rgba(0,0,0,.08);
}

.list-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.list-header h2 {
    font-size: 22px;
    font-weight: 700;
}

.btn-create {
    background: #16a34a;
    color: #fff;
    padding: 8px 14px;
    border-radius: 8px;
    font-weight: 600;
    text-decoration: none;
}

.table {
    width: 100%;
    border-collapse: collapse;
}

.table th {
    background: #0f172a;
    color: #fff;
    padding: 12px;
    text-align: left;
}

.table td {
    padding: 12px;
    border-bottom: 1px solid #e5e7eb;
}

.action-edit {
    color: #2563eb;
    font-weight: 600;
    margin-right: 10px;
}

.action-delete {
    color: #dc2626;
    font-weight: 600;
    background: none;
    border: none;
    cursor: pointer;
}
</style>

<div class="page-wrapper">
    <div class="list-card">
        <div class="list-header">
            <h2>Pumps</h2>
            <a href="{{ route('admin.pumps.create') }}" class="btn-create">+ Create Pump</a>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Region</th>
                    <th>Fuel Type</th>
                    <th>Price/L</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pumps as $pump)
                <tr>
                    <td>{{ $pump->name }} <span style="color:#64748b">({{ $pump->code }})</span></td>
                    <td>{{ $pump->region ?? 'N/A' }}</td>
                    <td>{{ $pump->fuel_type }}</td>
                    <td>TSH {{ number_format($pump->price_per_litre, 2) }}</td>
                    <td>{{ number_format($pump->stock, 0) }}L</td>
                    <td>
                        <a href="{{ route('admin.pumps.edit', $pump) }}" class="action-edit">Edit</a>
                        <form method="POST" action="{{ route('admin.pumps.destroy', $pump) }}" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Delete this pump?')" class="action-delete">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-top:15px">
            {{ $pumps->links() }}
        </div>
    </div>
</div>
@endsection
