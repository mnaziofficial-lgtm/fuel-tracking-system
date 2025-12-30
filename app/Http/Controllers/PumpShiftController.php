<?php

namespace App\Http\Controllers;

use App\Models\PumpShift;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PumpShiftController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $shifts = PumpShift::with('pump')
            ->when(!$user->isAdmin(), function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->orderByDesc('created_at')
            ->get();

        return view('shifts.index', compact('shifts'));
    }

    public function closeForm(PumpShift $shift)
    {
        if ($shift->status !== 'open') {
            return redirect()->route('shifts.index')
                ->withErrors('Shift already closed.');
        }

        return view('shifts.close', compact('shift'));
    }

   public function close(Request $request, $id)
{
    $request->validate([
        'closing_meter' => 'required|numeric|min:0'
    ]);

    $shift = PumpShift::where('id', $id)
        ->where('status', 'open')
        ->firstOrFail();

    // 1️⃣ Meter litres - ensure numeric values
    $closingMeter = (float) $request->closing_meter;
    $openingMeter = (float) $shift->opening_meter;
    $meterLitres = $closingMeter - $openingMeter;

    // Prevent accidental negative meter litres unless admin forces it
    if ($closingMeter < $openingMeter) {
        $canForce = Auth::user() && Auth::user()->isAdmin() && $request->boolean('force', false);
        if (! $canForce) {
            return back()
                ->withErrors('Closing meter must be greater than or equal to opening meter. If this is a meter rollover, ask an admin to force close.')
                ->withInput();
        }
    }

    // 2️⃣ System litres & amount from sales
    $systemLitres = (float) Sale::where('pump_shift_id', $shift->id)->sum('litres_sold');
    $totalAmount  = (float) Sale::where('pump_shift_id', $shift->id)->sum('amount');

    // 3️⃣ Difference (for reference)
    $difference = $systemLitres - $meterLitres;

    // 4️⃣ Save everything with explicit casting
    $shift->update([
        'closing_meter' => $closingMeter,
        'meter_litres' => $meterLitres,
        'system_litres' => $systemLitres,
        'total_amount'  => $totalAmount,
        'status'        => 'closed',
        'closed_at'     => now(),
    ]);

    return redirect()
        ->route('shifts.index')
        ->with('success', 'Shift closed successfully! Summary: ' . $meterLitres . 'L (Meter) vs ' . $systemLitres . 'L (System)');
}

    public function create()
    {
        // Only attendants can open shifts
        if (Auth::user()->isAdmin()) {
            return redirect()->route('shifts.index')
                ->withErrors('Admins cannot open shifts.');
        }

        $pumps = \App\Models\Pump::all();
        return view('shifts.create', compact('pumps'));
    }

public function store(Request $request)
{
    // Only attendants can open shifts
    if (Auth::user()->isAdmin()) {
        return redirect()->route('shifts.index')
            ->withErrors('Admins cannot open shifts.');
    }

    $request->validate([
        'pump_id'        => 'required|exists:pumps,id',
        'shift_period'   => 'required|in:morning,evening,night',
        'opening_meter' => 'required|numeric|min:0',
    ]);

    // ❌ Check if pump already has an open shift
    $pumpBusy = PumpShift::where('pump_id', $request->pump_id)
        ->where('status', 'open')
        ->exists();

    if ($pumpBusy) {
        return back()->withErrors(
            'This pump already has an open shift. Choose another pump.'
        );
    }

    // ✅ Allow attendant to open multiple pumps
    PumpShift::create([
        'user_id'        => auth()->id(),
        'pump_id'        => $request->pump_id,
        'shift_period'   => $request->shift_period,
        'opening_meter' => $request->opening_meter,
        'status'         => 'open',
        'opened_at'      => now(),
    ]);

    return redirect()
        ->route('sales.create')
        ->with('success', 'Shift opened successfully. You can now record sales.');
}


}
