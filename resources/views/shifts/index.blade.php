@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Shifts Management</h2>
        @if(Auth::user()->isAttendant())
            <a href="{{ route('shifts.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Open New Shift
            </a>
        @endif
    </div>

    @if(Auth::user()->isAdmin())
        <div class="mb-4 p-4 bg-blue-100 text-blue-800 rounded">
            <p>You are viewing all shifts. Only attendants can open and close shifts.</p>
        </div>
    @endif

    @forelse($shifts as $shift)
        <div class="shift-card mb-4 border border-gray-300 rounded bg-white shadow hover:shadow-lg transition-shadow">
            <!-- Card Header (Click to expand) -->
            <div class="shift-header cursor-pointer p-4 flex items-center justify-between" onclick="toggleShiftDetails(this)">
                <div class="flex-1">
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm">Pump</p>
                            <p class="text-lg font-bold">{{ $shift->pump->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Attendant</p>
                            <p class="text-lg font-bold">{{ $shift->user->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Status</p>
                            @if($shift->status === 'open')
                                <span class="px-3 py-1 rounded bg-green-200 text-green-800 font-semibold text-sm">OPEN</span>
                            @else
                                <span class="px-3 py-1 rounded bg-gray-200 text-gray-800 font-semibold text-sm">CLOSED</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="ml-4 flex items-center">
                    <svg class="w-6 h-6 text-gray-400 transition-transform expand-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
            </div>

            <!-- Card Details (Collapsible) -->
            <div class="shift-details hidden border-t border-gray-200">
                <div class="p-6">
                    <!-- Basic Info -->
                    <div class="mb-6">
                        <h4 class="font-bold text-lg mb-3 text-gray-800">Shift Information</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-3 rounded">
                                <p class="text-gray-600 text-sm">Shift Period</p>
                                <p class="text-base font-semibold">{{ ucfirst($shift->shift_period) }}</p>
                            </div>
                            <div class="bg-gray-50 p-3 rounded">
                                <p class="text-gray-600 text-sm">Opened At</p>
                                <p class="text-base font-semibold">{{ optional($shift->opened_at)?->format('d M Y H:i') ?? 'N/A' }}</p>
                            </div>
                            @if($shift->status === 'closed')
                                <div class="bg-gray-50 p-3 rounded">
                                    <p class="text-gray-600 text-sm">Closed At</p>
                                    <p class="text-base font-semibold">{{ optional($shift->closed_at)?->format('d M Y H:i') ?? 'N/A' }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($shift->status === 'closed')
                        <!-- Meter Reading Section -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <h4 class="font-bold text-lg mb-3 text-gray-800">Meter Reading</h4>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="bg-blue-50 p-4 rounded border-l-4 border-blue-500">
                                    <p class="text-gray-600 text-sm">Opening Meter</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ number_format($shift->opening_meter ?? 0, 2) }} L</p>
                                </div>
                                <div class="bg-blue-50 p-4 rounded border-l-4 border-blue-500">
                                    <p class="text-gray-600 text-sm">Closing Meter</p>
                                    <p class="text-2xl font-bold text-blue-600">{{ number_format($shift->closing_meter ?? 0, 2) }} L</p>
                                </div>
                                <div class="bg-blue-100 p-4 rounded border-l-4 border-blue-700">
                                    <p class="text-gray-600 text-sm">Meter Litres</p>
                                    <p class="text-2xl font-bold text-blue-800">{{ number_format($shift->meter_litres ?? 0, 2) }} L</p>
                                </div>
                            </div>
                        </div>

                        <!-- Sales Summary Section -->
                        <div class="mb-6 pb-6 border-b border-gray-200">
                            <h4 class="font-bold text-lg mb-3 text-gray-800">Sales Summary</h4>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="bg-green-50 p-4 rounded border-l-4 border-green-500">
                                    <p class="text-gray-600 text-sm">System Litres Sold</p>
                                    <p class="text-2xl font-bold text-green-600">{{ number_format($shift->system_litres ?? 0, 2) }} L</p>
                                </div>
                                
                                <div class="bg-green-50 p-4 rounded border-l-4 border-green-500">
                                    <p class="text-gray-600 text-sm">Total Amount</p>
                                    <p class="text-2xl font-bold text-green-600">TSH{{ number_format($shift->total_amount ?? 0, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Open Shift Actions -->
                        @if(Auth::user()->isAttendant() && Auth::user()->id === $shift->user_id)
                            <div class="pt-4">
                                <a href="{{ route('shifts.close.form', $shift) }}" class="inline-block px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition-colors">
                                    Close Shift
                                </a>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
            <p class="text-gray-500 text-lg mt-2">No shifts found.</p>
        </div>
    @endforelse
</div>

<script>
function toggleShiftDetails(element) {
    const detailsDiv = element.nextElementSibling;
    const icon = element.querySelector('.expand-icon');
    
    detailsDiv.classList.toggle('hidden');
    icon.classList.toggle('rotate-180');
}
</script>

<style>
.expand-icon {
    transition: transform 0.3s ease;
}
.expand-icon.rotate-180 {
    transform: rotate(180deg);
}
</style>
@endsection