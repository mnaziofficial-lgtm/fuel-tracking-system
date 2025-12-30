<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GovernmentCap;
use App\Models\Pump;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class GovernmentCapController extends Controller
{
    public function index(Request $request)
    {
        // Get unique regions from pumps to filter by pump regions only
        $pumpRegions = Pump::distinct()->pluck('region')->sort()->values();
        
        // Get selected region from request, default to first pump region if available
        $selectedRegion = $request->query('region') ?? ($pumpRegions->first() ?? 'all');
        
        // Get latest government cap prices, filtered by region
        $query = GovernmentCap::byRegion($selectedRegion)->latest('effective_date');
        
        $latestPrices = $query
            ->distinct()
            ->get()
            ->groupBy('region')
            ->map(function ($group) {
                return $group->groupBy('fuel_type');
            });

        return view('admin.govcap.upload', compact('latestPrices', 'pumpRegions', 'selectedRegion'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'gov_cap_file' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        try {
            $file = $request->file('gov_cap_file');
            $path = $file->getRealPath();
            
            $allData = Excel::toArray([], $path);
            $rows = $allData[0] ?? [];
            
            if (empty($rows)) {
                return back()->with('error', 'File is empty or invalid format');
            }

            $savedCount = 0;
            $effectiveDate = now()->toDateString();
            $errors = [];

            // Auto-detect header row
            $startRow = 0;
            for ($i = 0; $i < min(3, count($rows)); $i++) {
                $headerRow = $rows[$i] ?? [];
                $headerText = strtolower(implode(' ', array_map('strval', $headerRow)));
                if (strpos($headerText, 'region') !== false || strpos($headerText, 'town') !== false || 
                    strpos($headerText, 'petrol') !== false || strpos($headerText, 'diesel') !== false || 
                    strpos($headerText, 's/no') !== false || strpos($headerText, 'sno') !== false) {
                    $startRow = $i + 1;
                    break;
                }
            }

            // Process data rows
            foreach ($rows as $index => $row) {
                if ($index < $startRow) {
                    continue;
                }
                
                if (empty(array_filter($row))) {
                    continue;
                }

                // Parse based on standard format: S/NO, TOWN/REGION, PETROL, DIESEL, KEROSENE
                $region = null;
                $priceColumns = [];

                // Skip first column if it's S/NO (numeric serial), extract region from 2nd column
                $startCol = 0;
                for ($col = 0; $col < count($row); $col++) {
                    $val = trim((string)($row[$col] ?? ''));
                    if (!empty($val)) {
                        // If first column is numeric (S/NO), skip it
                        if ($col === 0 && is_numeric($val)) {
                            $startCol = 1;
                            continue;
                        }
                        
                        // Region is the first non-numeric value after S/NO
                        if ($region === null && !is_numeric($val) && strlen($val) >= 2) {
                            $region = $val;
                        } 
                        // Collect prices after region is found
                        elseif ($region !== null) {
                            $price = floatval(str_replace([',', '₦', '₵', 'TZS', ' ', '$', '€'], '', $val));
                            if ($price > 0 && count($priceColumns) < 3) {
                                $priceColumns[] = $price;
                            }
                        }
                    }
                }

                if (empty($region)) {
                    $errors[] = "Row " . ($index + 1) . ": No region name found";
                    continue;
                }

                if (count($priceColumns) < 3) {
                    $errors[] = "Row " . ($index + 1) . " ($region): Expected 3 prices (Petrol, Diesel, Kerosene), got " . count($priceColumns);
                    continue;
                }

                // Save Petrol
                try {
                    GovernmentCap::create([
                        'region' => $region,
                        'fuel_type' => 'Petrol',
                        'cap_price' => $priceColumns[0],
                        'effective_date' => $effectiveDate
                    ]);
                    $savedCount++;
                } catch (\Exception $e) {
                    $errors[] = "Row " . ($index + 1) . ": " . $e->getMessage();
                }

                // Save Diesel if exists
                if (isset($priceColumns[1])) {
                    try {
                        GovernmentCap::create([
                            'region' => $region,
                            'fuel_type' => 'Diesel',
                            'cap_price' => $priceColumns[1],
                            'effective_date' => $effectiveDate
                        ]);
                        $savedCount++;
                    } catch (\Exception $e) {
                        // Skip
                    }
                }

                // Save Kerosene if exists
                if (isset($priceColumns[2])) {
                    try {
                        GovernmentCap::create([
                            'region' => $region,
                            'fuel_type' => 'Kerosene',
                            'cap_price' => $priceColumns[2],
                            'effective_date' => $effectiveDate
                        ]);
                        $savedCount++;
                    } catch (\Exception $e) {
                        // Skip
                    }
                }
            }

            if ($savedCount == 0) {
                $errorMsg = "❌ No data saved. Check file format.";
                if (!empty($errors)) {
                    $errorMsg .= "\n" . implode("\n", array_slice($errors, 0, 5));
                }
                return back()->with('error', $errorMsg);
            }

            $message = "✓ Successfully saved $savedCount records!";
            if (!empty($errors)) {
                $errorCount = count($errors);
                $message .= " (⚠️ $errorCount rows had errors)";
            }
            return back()->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('GovernmentCap Upload: ' . $e->getMessage());
            return back()->with('error', 'Upload failed: ' . $e->getMessage());
        }
    }

    public function download(Request $request)
    {
        $timeframe = $request->query('timeframe', 'all');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = GovernmentCap::query();

        // Apply timeframe filter
        if ($timeframe === 'today') {
            $query->whereDate('effective_date', today());
        } elseif ($timeframe === 'month') {
            $query->whereYear('effective_date', now()->year)
                  ->whereMonth('effective_date', now()->month);
        } elseif ($timeframe === 'custom' && $startDate && $endDate) {
            $query->whereBetween('effective_date', [$startDate, $endDate]);
        }

        $records = $query->orderBy('effective_date', 'desc')
                         ->orderBy('region', 'asc')
                         ->get();

        if ($records->isEmpty()) {
            return back()->with('error', 'No records found for the selected period.');
        }

        // Create CSV
        $fileName = 'government-cap-prices-' . now()->format('Y-m-d-His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($records) {
            $file = fopen('php://output', 'w');
            
            // Write CSV header
            fputcsv($file, ['Region', 'Fuel Type', 'Cap Price (TSH)', 'Effective Date']);
            
            // Write data rows
            foreach ($records as $record) {
                fputcsv($file, [
                    $record->region,
                    $record->fuel_type,
                    number_format($record->cap_price, 2),
                    \Carbon\Carbon::parse($record->effective_date)->format('Y-m-d'),
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
