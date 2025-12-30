@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Dashboard</h2>
    <p>Total Sales: <strong>${{ $totalSales }}</strong></p>
    <p>Total Litres Sold: <strong>{{ $totalLitres }} L</strong></p>

    <h3 class="text-xl font-bold mt-6 mb-2">Fuel Stock</h3>
    <table class="table-auto border-collapse border border-gray-400 w-full">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">Fuel</th>
                <th class="border border-gray-300 px-4 py-2">Price per Litre</th>
                <th class="border border-gray-300 px-4 py-2">Current Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fuels as $fuel)
            <tr>
                <td class="border border-gray-300 px-4 py-2">{{ $fuel->name }}</td>
                <td class="border border-gray-300 px-4 py-2">${{ $fuel->price_per_litre }}</td>
                <td class="border border-gray-300 px-4 py-2">{{ $fuel->current_stock }} L</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('sales.create') }}" class="mt-6 inline-block px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Record Sale</a>
</div>
@endsection
