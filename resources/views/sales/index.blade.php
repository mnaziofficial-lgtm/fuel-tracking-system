@extends('layouts.app')

@section('content')

<style>
    /* Table hover effect */
    table tbody tr:hover {
        background-color: #f3f4f6; /* light gray */
    }

    /* Table header style */
    table thead th {
        background-color: #3b82f6; /* Tailwind blue-500 */
        color: white;
        text-align: left;
    }

    /* Pagination links */
    .pagination li a,
    .pagination li span {
        padding: 0.5rem 0.75rem;
        margin: 0 0.125rem;
        border: 1px solid #d1d5db; /* Tailwind gray-300 */
        border-radius: 0.375rem;
        color: #3b82f6;
    }

    .pagination li.active span {
        background-color: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }

    /* Responsive chart container */
    #salesChart {
        width: 100%;
        height: 400px;
        margin-top: 2rem;
    }
</style>

<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Sales</h2>

    @if(session('success'))
        <div class="mb-4 text-green-600">{{ session('success') }}</div>
    @endif

    <table class="table-auto border-collapse border border-gray-300 w-full">
        <thead>
            <tr>
                <th class="border px-4 py-2">Date</th>
                <th class="border px-4 py-2">Pump</th>
                <th class="border px-4 py-2">Fuel</th>
                <th class="border px-4 py-2">Litres</th>
                <th class="border px-4 py-2">Amount</th>
                <th class="border px-4 py-2">Attendant</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td class="border px-4 py-2">{{ $sale->created_at->format('Y-m-d H:i') }}</td>
                <td class="border px-4 py-2">{{ optional($sale->pump)->name }}</td>
                <td class="border px-4 py-2">{{ optional($sale->pump)->fuel_type ?? 'N/A' }}</td>
                <td class="border px-4 py-2">{{ $sale->litres_sold }}</td>
                <td class="border px-4 py-2">{{ number_format($sale->amount,2) }}</td>
                <td class="border px-4 py-2">{{ optional($sale->user)->name }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

   
@endsection
