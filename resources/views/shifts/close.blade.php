@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Close Shift</h2>

    <p><strong>Pump:</strong> {{ $shift->pump->name }}</p>
    <p><strong>Opening Meter:</strong> {{ $shift->opening_meter }}</p>

    <form method="POST" action="{{ route('shifts.close', $shift) }}">
        @csrf

        <label>Closing Meter</label>
        <input type="number" step="0.01" name="closing_meter" value="{{ old('closing_meter') }}" required class="border rounded px-2 py-1">

        @error('closing_meter')
            <p class="text-red-600">{{ $message }}</p>
        @enderror

        @if($errors->any())
            <div class="mb-2 text-red-600">
                @foreach($errors->all() as $e)
                    <div>{{ $e }}</div>
                @endforeach
            </div>
        @endif

        @if(auth()->user() && auth()->user()->isAdmin())
            <div class="mt-2">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="force" value="1" class="mr-2"> Force close (admin override)
                </label>
            </div>
        @endif

        <button type="submit" class="btn btn-danger mt-3">
            Close Shift
        </button>
    </form>
</div>
@endsection
