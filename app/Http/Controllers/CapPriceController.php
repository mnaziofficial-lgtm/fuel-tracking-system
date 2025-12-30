<?php

namespace App\Http\Controllers;

use App\Models\CapPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel; // if using Excel import

class CapPriceController extends Controller
{
    public function create()
    {
        return view('admin.cap_upload');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cap_file' => 'required|file|mimes:xlsx,csv',
        ]);

        $file = $request->file('cap_file');
        $path = $file->store('cap_prices');

        // Example: read CSV / Excel and save to CapPrice table
        $rows = array_map('str_getcsv', file(storage_path('app/' . $path)));
        foreach ($rows as $row) {
            CapPrice::updateOrCreate(
                ['town' => $row[0], 'fuel_type' => $row[1]],
                ['cap_price' => $row[2]]
            );
        }

        return redirect()->route('admin.dashboard')->with('success', 'Cap prices updated!');
    }
}
