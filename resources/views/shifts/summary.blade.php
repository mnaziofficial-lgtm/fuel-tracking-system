<div class="container mx-auto p-6">
    <div class="bg-white border border-gray-300 rounded p-6 shadow">
        <h2 class="text-2xl font-bold mb-6">Shift Summary</h2>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-gray-600 text-sm"><strong>Pump:</strong></p>
                <p class="text-lg font-bold">{{ $shift->pump->name }}</p>
            </div>
            <div class="bg-gray-50 p-4 rounded">
                <p class="text-gray-600 text-sm"><strong>Attendant:</strong></p>
                <p class="text-lg font-bold">{{ $shift->user->name }}</p>
            </div>
        </div>

        <div class="border-t pt-6 mb-6">
            <h3 class="font-bold mb-4">Meter Reading</h3>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <p class="text-gray-600">Opening Meter</p>
                    <p class="text-xl font-bold">{{ $shift->opening_meter }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Closing Meter</p>
                    <p class="text-xl font-bold">{{ $shift->closing_meter }}</p>
                </div>
                <div>
                    <p class="text-gray-600">Meter Litres</p>
                    <p class="text-xl font-bold text-blue-600">{{ $shift->meter_litres ?? 0 }} L</p>
                </div>
            </div>
        </div>

        <div class="border-t pt-6 mb-6">
            <h3 class="font-bold mb-4">Sales & Amounts</h3>
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-green-50 p-4 rounded">
                    <p class="text-gray-600">System Litres Sold</p>
                    <p class="text-2xl font-bold text-green-600">{{ $shift->system_litres ?? 0 }} L</p>
                </div>
                <div class="bg-orange-50 p-4 rounded">
                    <p class="text-gray-600">Difference</p>
                    <p class="text-2xl font-bold {{ $shift->difference_litres < 0 ? 'text-red-600' : 'text-orange-600' }}">{{ $shift->difference_litres }} L</p>
                </div>
                <div class="bg-blue-50 p-4 rounded">
                    <p class="text-gray-600">Total Amount</p>
                    <p class="text-2xl font-bold text-blue-600">₦{{ number_format($shift->total_amount ?? 0, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="border-t pt-6 text-center">
            <a href="{{ route('shifts.index') }}" class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Back to Shifts
            </a>
        </div>
    </div>
</div>
