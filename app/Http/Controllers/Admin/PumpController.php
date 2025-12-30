<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pump;
use App\Models\Fuel;
use Illuminate\Http\Request;

class PumpController extends Controller
{
    public function index()
    {
        // ❌ removed with('fuel')
        $pumps = Pump::orderBy('name')->paginate(20);
        return view('admin.pumps.index', compact('pumps'));
    }

    public function create()
    {
        return view('admin.pumps.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'region'          => 'required|string|max:255',
            'code'            => 'nullable|string|max:50|unique:pumps,code',
            'fuel_type'       => 'required|string|max:255',
            'price_per_litre' => 'required|numeric|min:0',
            'stock'           => 'required|numeric|min:0',
            'low_stock_threshold' => 'nullable|numeric|min:0',
        ]);

        Pump::create([
            'name'            => $data['name'],
            'region'          => $data['region'],
            'code'            => $data['code'] ?? null,
            'fuel_type'       => $data['fuel_type'],
            'price_per_litre' => $data['price_per_litre'],
            'stock'           => $data['stock'],
            'low_stock_threshold' => $data['low_stock_threshold'] ?? null,
        ]);

        return redirect()
            ->route('admin.pumps.index')
            ->with('status', 'Pump created successfully.');
    }

    public function edit(Pump $pump)
    {
        return view('admin.pumps.edit', compact('pump'));
    }

    public function update(Request $request, Pump $pump)
    {
        $data = $request->validate([
            'name'            => 'required|string|max:255',
            'region'          => 'required|string|max:255',
            'code'            => 'nullable|string|max:50|unique:pumps,code,' . $pump->id,
            'fuel_type'       => 'required|string|max:255',
            'price_per_litre' => 'required|numeric|min:0',
            'stock'           => 'required|numeric|min:0',
            'low_stock_threshold' => 'nullable|numeric|min:0',
        ]);

        $pump->update([
            'name'            => $data['name'],
            'region'          => $data['region'],
            'code'            => $data['code'] ?? null,
            'fuel_type'       => $data['fuel_type'],
            'price_per_litre' => $data['price_per_litre'],
            'stock'           => $data['stock'],
            'low_stock_threshold' => $data['low_stock_threshold'] ?? null,
        ]);

        return redirect()
            ->route('admin.pumps.index')
            ->with('status', 'Pump updated successfully.');
    }

    public function destroy(Pump $pump)
    {
        $pump->delete();

        return redirect()
            ->route('admin.pumps.index')
            ->with('status', 'Pump deleted successfully.');
    }
}
