<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Pump;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSales = Sale::sum('amount');
        $totalLitres = Sale::sum('litres_sold');
        $fuels = Pump::all();

        $dates = Sale::selectRaw('DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('date');

        $chartAmounts = Sale::selectRaw('SUM(amount) as total, DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total');

        $chartLitres = Sale::selectRaw('SUM(litres_sold) as total, DATE(created_at) as date')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('total');

        return view('admin.dashboard', compact('totalSales', 'totalLitres', 'fuels', 'dates', 'chartAmounts', 'chartLitres'));
    }

    public function pumps()
    {
        $pumps = Pump::all();
        return view('admin.pumps', compact('pumps'));
    }

    public function sales()
    {
        $sales = Sale::with(['pump', 'fuel', 'user'])->latest()->paginate(10);
        return view('admin.sales', compact('sales'));
    }
}