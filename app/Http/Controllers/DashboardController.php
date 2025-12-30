<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Pump;
use App\Models\Fuel;
use App\Models\PumpShift;
use App\Models\GovernmentCap;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $totalSales = 0;
        $totalLitres = 0;

        /* ================= ADMIN ================= */
        if ($user && $user->isAdmin()) {

            $from = $request->query('from');
            $to   = $request->query('to');

            $startDate = $from
                ? Carbon::parse($from)->startOfDay()
                : $user->created_at->startOfDay();

            $endDate = $to
                ? Carbon::parse($to)->endOfDay()
                : Carbon::today()->endOfDay();

            /* ---- Prepare chart arrays ---- */
            $dates = [];
            $amounts = [];
            $litres = [];

            $d = $startDate->copy();
            while ($d->lte($endDate)) {
                $key = $d->format('Y-m-d');
                $dates[] = $key;
                $amounts[$key] = 0;
                $litres[$key] = 0;
                $d->addDay();
            }

            /* ---- Fetch sales ---- */
            $rows = Sale::whereBetween('created_at', [$startDate, $endDate])->get();

            foreach ($rows as $r) {
                $key = $r->created_at->format('Y-m-d');
                $amounts[$key] += $r->amount;
                $litres[$key] += $r->litres_sold;
            }

            $chartAmounts = array_values($amounts);
            $chartLitres  = array_values($litres);

            $totalSales  = array_sum($chartAmounts);
            $totalLitres = array_sum($chartLitres);

            /* ---- Tables ---- */
            $sales = Sale::with(['pump','user'])
                ->orderByDesc('created_at')
                ->paginate(10);

            $pumps = Pump::orderBy('name')
                ->with([
                    'governmentCap' => function ($query) {
                        $query->latest('effective_date')->limit(1);
                    }
                ])
                ->get()
                ->map(function ($pump) {
                    $pump->cap_price = $pump->governmentCap?->cap_price;
                    return $pump;
                });

            /* ---- Low Stock Pumps ---- */
            $lowStockPumps = $pumps->filter(function ($p) {
                return !is_null($p->low_stock_threshold) && $p->stock <= $p->low_stock_threshold;
            })->values();

            return view('admin.dashboard', compact(
                'pumps',
                'lowStockPumps',
                'sales',
                'totalSales',
                'totalLitres',
                'dates',
                'chartAmounts',
                'chartLitres'
            ));
        }

        /* ================= ATTENDANT ================= */
        $totalSales = Sale::where('user_id', $user->id)->sum('amount');
        $totalLitres = Sale::where('user_id', $user->id)->sum('litres_sold');

        $mySales = Sale::with('pump')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        $currentShifts = PumpShift::with('pump')
            ->where('user_id', $user->id)
            ->where('status', 'open')
            ->get();

        $fuels = Fuel::all();

        return view(
            'attendant.dashboard',
            compact(
                'totalSales',
                'totalLitres',
                'mySales',
                'currentShifts',
                'fuels'
            )
        );
    }
}
