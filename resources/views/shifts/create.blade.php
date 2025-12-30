@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Open Shift</h2>

    <form method="POST" action="{{ route('shifts.store') }}">
        @csrf

        <label>Pump</label>
        <select name="pump_id" required>
            <option value="">-- Select Pump --</option>
            @foreach($pumps as $pump)
                <option value="{{ $pump->id }}">{{ $pump->name }}</option>
            @endforeach
        </select>

        <label>Shift Period</label>
        <select name="shift_period" required>
            <option value="morning">Morning</option>
            <option value="evening">Evening</option>
            <option value="night">Night</option>
        </select>

        <label>Opening Meter</label>
        <input type="number" step="0.01" name="opening_meter" required>

        <button type="submit" class="btn btn-primary mt-3">
            Open Shift
        </button>
    </form>
</div>
@endsection
