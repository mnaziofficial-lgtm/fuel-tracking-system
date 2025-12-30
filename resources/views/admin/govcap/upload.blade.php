@extends('layouts.app')

@section('content')
<div style="max-width: 900px; margin: 0 auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1 style="margin: 0; font-size: 28px; color: #1e293b; font-weight: 700;">Government Cap Prices</h1>
    </div>

    @if($pumpRegions->count() > 0)
    <div style="background: #f0f9ff; padding: 15px; border-radius: 8px; border: 1px solid #bfdbfe; margin-bottom: 20px;">
        <label for="region-filter" style="display: block; font-weight: 600; color: #1e40af; margin-bottom: 10px;">🔍 Filter by Region (Pump Regions Only)</label>
        <form method="GET" action="{{ route('admin.govcap.upload') }}" style="display: flex; gap: 10px;">
            <select name="region" id="region-filter" style="padding: 10px 15px; border: 1px solid #bfdbfe; border-radius: 4px; font-size: 14px; background: white; cursor: pointer;">
                <option value="all">All Pump Regions</option>
                @foreach($pumpRegions as $region)
                    <option value="{{ $region }}" @if($selectedRegion === $region) selected @endif>{{ $region }}</option>
                @endforeach
            </select>
            <button type="submit" style="background-color: #3b82f6; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 600;">Filter</button>
        </form>
    </div>
    @endif

    @if(session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #28a745;">
            ✓ {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
            ✗ {!! nl2br(e(session('error'))) !!}
        </div>
    @endif

    @if($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background-color: #f8f9fa; padding: 25px; border-radius: 8px; border: 1px solid #dee2e6; margin-bottom: 30px;">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #333; font-size: 18px; font-weight: 600;">📥 Download Cap Prices Report</h3>
        
        <form method="GET" action="{{ route('admin.govcap.download') }}" style="display: grid; gap: 15px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; align-items: flex-end;">
                <div>
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">Download Period</label>
                    <select name="timeframe" id="timeframe" style="width: 100%; padding: 10px; border: 2px solid #dee2e6; border-radius: 4px; font-size: 14px;">
                        <option value="all">All Records</option>
                        <option value="today">Today Only</option>
                        <option value="month">This Month</option>
                        <option value="custom">Custom Date Range</option>
                    </select>
                </div>

                <div id="start-date-group" style="display: none;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">Start Date</label>
                    <input type="date" name="start_date" id="start_date" style="width: 100%; padding: 10px; border: 2px solid #dee2e6; border-radius: 4px; font-size: 14px;">
                </div>

                <div id="end-date-group" style="display: none;">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">End Date</label>
                    <input type="date" name="end_date" id="end_date" style="width: 100%; padding: 10px; border: 2px solid #dee2e6; border-radius: 4px; font-size: 14px;">
                </div>
            </div>

            <button type="submit" style="background-color: #2563eb; color: white; padding: 12px 25px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 600; width: fit-content;">
                📊 Download CSV
            </button>
        </form>

        <script>
            document.getElementById('timeframe').addEventListener('change', function() {
                const startDateGroup = document.getElementById('start-date-group');
                const endDateGroup = document.getElementById('end-date-group');
                
                if (this.value === 'custom') {
                    startDateGroup.style.display = 'block';
                    endDateGroup.style.display = 'block';
                } else {
                    startDateGroup.style.display = 'none';
                    endDateGroup.style.display = 'none';
                }
            });
        </script>
    </div>

    <div style="background-color: #f8f9fa; padding: 25px; border-radius: 8px; border: 1px solid #dee2e6; margin-bottom: 30px;">
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #333; font-size: 18px; font-weight: 600;">Upload Government Cap Prices</h3>

        <div style="background: #e7f3ff; padding: 15px; border-radius: 4px; margin-bottom: 20px; border-left: 4px solid #2563eb;">
            <p style="margin: 0; font-size: 13px; color: #0c4a6e;">
                <strong>📋 Required File Format:</strong><br>
                Your Excel/CSV must have columns in this order:
                <br><br>
                <strong style="color: #1e40af;">Column A: S/NO</strong> (Serial numbers 1, 2, 3...)<br>
                <strong style="color: #1e40af;">Column B: TOWN</strong> (Region name: e.g., Mwanza, Lagos, Abuja)<br>
                <strong style="color: #1e40af;">Column C: PETROL</strong> (Petrol cap price)<br>
                <strong style="color: #1e40af;">Column D: DIESEL</strong> (Diesel cap price)<br>
                <strong style="color: #1e40af;">Column E: KEROSENE</strong> (Kerosene cap price)<br>
                <br>
                <strong>Example:</strong><br>
                S/NO | TOWN | PETROL | DIESEL | KEROSENE<br>
                1 | Mwanza | 750 | 680 | 620<br>
                2 | Lagos | 780 | 700 | 640<br>
                <br>
                ✓ Prices can have commas: 1,500.50<br>
                ✓ Prices can have currency symbols: ₦750, ₵680<br>
                ✓ Headers auto-detected (row 1 or 2)<br>
                ✓ Excel (.xlsx, .xls) or CSV files supported
            </p>
        </div>

        <form method="POST" action="{{ route('admin.govcap.upload.submit') }}" enctype="multipart/form-data" style="max-width: 500px;">
            @csrf
            <div style="margin-bottom: 15px;">
                <label for="gov_cap_file" style="display: block; margin-bottom: 8px; font-weight: 500; color: #333;">
                    Select File (Excel or CSV) <span style="color: #dc3545;">*</span>
                </label>
                <input type="file" id="gov_cap_file" name="gov_cap_file" accept=".xlsx,.xls,.csv" 
                       style="display: block; padding: 10px; border: 2px solid #dee2e6; border-radius: 4px; width: 100%; box-sizing: border-box; font-size: 14px;" 
                       required>
                <small style="color: #6c757d; display: block; margin-top: 5px;">Supported formats: .xlsx (Excel), .csv (Comma-separated values)</small>
            </div>
            <button type="submit" style="background-color: #10b981; color: white; padding: 12px 25px; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; font-weight: 600;">
                📤 Upload Prices
            </button>
        </form>
    </div>

    @if(!empty($latestPrices))
    <div>
        <h3 style="margin-top: 0; margin-bottom: 20px; color: #333; font-size: 18px; font-weight: 600;">Current Cap Prices by Region</h3>
        <div style="display: grid; gap: 15px;">
            @foreach($latestPrices as $region => $fuelTypes)
                <div style="background: white; padding: 15px; border-radius: 8px; border: 1px solid #dee2e6;">
                    <h4 style="margin: 0 0 15px 0; color: #1e293b; font-size: 16px; font-weight: 600;">{{ $region }}</h4>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 10px;">
                        @foreach($fuelTypes as $fuelType => $prices)
                            @php
                                $latestPrice = $prices->sortByDesc('effective_date')->first();
                            @endphp
                            <div style="background: #f8fafc; padding: 12px; border-radius: 4px; border-left: 4px solid #2563eb;">
                                <div style="font-size: 12px; color: #64748b; margin-bottom: 5px;">{{ $fuelType }}</div>
                                <div style="font-size: 18px; font-weight: 700; color: #1e293b;">TSH{{ number_format($latestPrice->cap_price, 2) }}</div>
                                <div style="font-size: 11px; color: #9ca3af; margin-top: 5px;">
                                    Updated: {{ \Carbon\Carbon::parse($latestPrice->effective_date)->format('M d, Y') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
