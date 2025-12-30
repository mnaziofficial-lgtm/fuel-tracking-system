<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Pump;
use App\Models\PumpShift;
use App\Models\User;
use App\Models\GovernmentCap;
use App\Notifications\LowStockNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SalesController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->isAdmin()) {
            $sales = Sale::with(['pump','user'])->orderByDesc('created_at')->paginate(50);

            $start = Carbon::today()->subDays(29);
            $dates = [];
            $amounts = [];

            for ($i = 0; $i < 30; $i++) {
                $d = $start->copy()->addDays($i);
                $dates[] = $d->format('Y-m-d');
                $amounts[$d->format('Y-m-d')] = 0;
            }

            $rows = Sale::where('created_at', '>=', $start->startOfDay())->get();
            foreach ($rows as $r) {
                $key = $r->created_at->format('Y-m-d');
                if (isset($amounts[$key])) {
                    $amounts[$key] += $r->amount;
                }
            }

            $chartAmounts = array_values($amounts);

            return view('sales.index', compact('sales','dates','chartAmounts'));
        }

        $sales = Sale::with(['pump'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->paginate(50);

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $hasOpenShift = PumpShift::where('user_id', Auth::id())
            ->where('status', 'open')
            ->exists();

        if (!$hasOpenShift) {
            return redirect()
                ->route('shifts.index')
                ->with('error', '⚠️ Please open a shift before recording any sale.');
        }

        // Use JOIN to fetch pumps with their government cap prices
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
        
        return view('sales.create', compact('pumps'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $openShift = PumpShift::where('user_id', $user->id)
            ->where('status', 'open')
            ->first();

        if (!$openShift) {
            return back()->withErrors('You must open a shift before recording sales.');
        }

        $request->validate([
            'pump_id'     => 'required|exists:pumps,id',
            'litres_sold' => 'required|numeric|min:0.01',
        ]);

        $litres = (float) $request->litres_sold;
        $pump   = Pump::findOrFail($request->pump_id);

        if ($pump->price_per_litre <= 0) {
            return back()->withErrors('Pump price per litre is not set.');
        }

        /**
         * ❌ OUT OF STOCK — BLOCK SALE + NOTIFY
         */
        if (!is_null($pump->stock) && $pump->stock < $litres) {

            $admins = User::where('role', 'admin')->get();

            foreach ($admins as $admin) {
                $notification = new LowStockNotification(
                    $pump,
                    $litres,
                    $pump->stock
                );

                // EMAIL
                $admin->notify($notification);

                // REAL SMS
                if ($admin->phone) {
                    $notification->sendSms($admin->phone);
                }
            }

            return back()
                ->with('error', '❌ Sale blocked. Not enough stock on pump ' . $pump->name);
        }

        DB::beginTransaction();
        try {
            $price  = (float) $pump->price_per_litre;
            $amount = round($litres * $price, 2);

            Sale::create([
                'user_id'         => $user->id,
                'pump_id'         => $pump->id,
                'litres_sold'     => $litres,
                'amount'          => $amount,
                'price_per_litre' => $price,
                'pump_shift_id'   => $openShift->id,
            ]);

            $pump->decrement('stock', $litres);
            $pump->refresh();

            /**
             * ⚠️ LOW STOCK — NOTIFY
             */
            if (!is_null($pump->low_stock_threshold)
                && $pump->stock <= $pump->low_stock_threshold) {

                $admins = User::where('role', 'admin')->get();

                foreach ($admins as $admin) {
                    $notification = new LowStockNotification(
                        $pump,
                        $litres,
                        $pump->stock
                    );

                    $admin->notify($notification);

                    if ($admin->phone) {
                        $notification->sendSms($admin->phone);
                    }
                }
            }

            DB::commit();

            return redirect()
                ->route('sales.index')
                ->with('success', '✅ Sale recorded successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->withErrors('Failed to record sale. ' . $e->getMessage());
        }
    }

    public function download(Request $request)
    {
        $user = Auth::user();

        // Check if showing download page or processing download
        if (!$request->has('timeframe')) {
            return view('sales.download');
        }

        // Only admins can download all sales
        if (!$user || !$user->isAdmin()) {
            return back()->with('error', 'Unauthorized access.');
        }

        $timeframe = $request->query('timeframe', 'all');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = Sale::with(['pump', 'user']);

        // Apply timeframe filter
        if ($timeframe === 'today') {
            $query->whereDate('created_at', today());
        } elseif ($timeframe === 'week') {
            $query->where('created_at', '>=', now()->subDays(7));
        } elseif ($timeframe === 'month') {
            $query->whereYear('created_at', now()->year)
                  ->whereMonth('created_at', now()->month);
        } elseif ($timeframe === 'custom' && $startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        }

        $sales = $query->orderByDesc('created_at')->get();

        if ($sales->isEmpty()) {
            return back()->with('error', 'No sales records found for the selected period.');
        }

        // Create CSV
        $fileName = 'sales-report-' . now()->format('Y-m-d-His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($sales) {
            $file = fopen('php://output', 'w');
            
            // Write CSV header
            fputcsv($file, ['Date', 'Pump', 'Region', 'Fuel Type', 'Price/L (TSH)', 'Litres Sold', 'Amount (TSH)', 'Attendant']);
            
            // Write data rows
            foreach ($sales as $sale) {
                fputcsv($file, [
                    $sale->created_at->format('Y-m-d H:i'),
                    optional($sale->pump)->name,
                    optional($sale->pump)->region ?? 'N/A',
                    optional($sale->pump)->fuel_type ?? 'N/A',
                    number_format(optional($sale->pump)->price_per_litre ?? 0, 2),
                    $sale->litres_sold,
                    number_format($sale->amount, 2),
                    optional($sale->user)->name,
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

