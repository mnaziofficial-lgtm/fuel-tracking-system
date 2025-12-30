# Government Cap Price Display Feature

## Overview
Enhanced the system to display government cap prices on the sales form. Now when attendants record a sale, they can see:
- ✅ The pump's region
- ✅ The pump's current price per litre
- ✅ The government cap price for that region/fuel type (if set)

## What Was Changed

### 1. SalesController.php
**File:** `app/Http/Controllers/SalesController.php`

**Changes:**
- Added `use App\Models\GovernmentCap;` import
- Enhanced `create()` method to load cap prices for each pump:
  ```php
  foreach ($pumps as $pump) {
      $pump->cap_price = $pump->getCapPriceAttribute();
  }
  ```

**How it Works:**
- Uses the `getCapPriceAttribute()` method from Pump model
- Fetches government cap price based on:
  - Pump's region (must match GovernmentCap.region)
  - Pump's fuel type (must match GovernmentCap.fuel_type)
  - Latest effective_date (most recent price wins)

### 2. sales/create.blade.php View
**File:** `resources/views/sales/create.blade.php`

**Changes:**
1. **Enhanced Pump Selection:**
   - Added data attributes to options:
     - `data-price`: Pump's current price per litre
     - `data-region`: Pump's region
     - `data-fuel`: Pump's fuel type
     - `data-cap`: Government cap price (if available)
   - Better option labels showing fuel type and stock

2. **Added Pump Info Display Box:**
   - Shows when a pump is selected
   - Displays:
     - Region name
     - Current pump price (₦X.XX/L)
     - Government cap price (if set, highlighted in green)
     - "Not set" in red if no cap price available

3. **JavaScript Function:**
   - `updatePumpInfo()` - Reads selected pump's data attributes
   - Updates display dynamically without page reload
   - Shows/hides info box based on selection

## How to Use

### As an Attendant (Recording a Sale)

1. **Open Sales Form** → Click "Record Sale"
2. **Select a Pump** → Choose from dropdown (all pumps listed with fuel type)
3. **See Cap Price** → Info box appears showing:
   - Region where pump is located
   - What you're charging per litre
   - What government allows per litre
4. **Record Sale** → Enter litres and submit

**Example Display:**
```
Region: Lagos
Pump Price: ₦250.50/L
Gov Cap Price: ₦248.00/L  ← Green if set, Red if not
```

### As an Admin

1. **Upload Government Caps** → Go to Admin > Government Cap Prices
2. **Upload Excel** with Region + Price columns
3. **System Automatically Matches** cap prices to pumps by region/fuel type
4. **Attendants See Updated Prices** on the sales form

## Data Flow

```
Admin uploads Government Caps
        ↓
GovernmentCap table updated with:
  - region (Lagos, Abuja, etc)
  - fuel_type (Petrol, Diesel, Kerosene)
  - cap_price (250.50, etc)
  - effective_date (today)
        ↓
Attendant records sale
        ↓
SalesController.create() fetches prices:
  - Gets all pumps
  - For each pump: fetch cap price where
    region matches pump region AND
    fuel_type matches pump fuel_type
        ↓
View displays cap price in form
        ↓
Attendant sees gov cap price before recording sale
```

## Example Scenarios

### Scenario 1: Cap Price Exists
```
Pump: Lekki Shell (Lagos, Petrol)
Database has: GovernmentCap(region=Lagos, fuel_type=Petrol, cap_price=248.00)

Result:
  Region: Lagos
  Pump Price: ₦250.50/L
  Gov Cap Price: ₦248.00/L  ✅ GREEN
```

### Scenario 2: No Cap Price Set
```
Pump: Ibadan Total (Ibadan, Diesel)
Database has no matching GovernmentCap entry

Result:
  Region: Ibadan
  Pump Price: ₦245.00/L
  Gov Cap Price: Not set  ❌ RED
```

### Scenario 3: Multiple Fuel Types in Same Region
```
Region: Lagos
GovernmentCap entries:
  - Lagos, Petrol, 248.00
  - Lagos, Diesel, 240.00

Pump 1 (Lagos Petrol) → Shows 248.00
Pump 2 (Lagos Diesel) → Shows 240.00
```

## Key Features

✅ **Real-time Display** - No page refresh needed
✅ **Region-Based Matching** - Automatically finds correct cap price
✅ **Fuel Type Specific** - Each fuel type can have different cap
✅ **Latest Price** - Always uses most recent effective_date
✅ **Clear Status** - Green if set, Red if missing
✅ **User-Friendly** - Simple, obvious display
✅ **No Manual Config** - Automatic after government cap upload

## Technical Details

### Method Used: Pump Model Accessor
```php
// In Pump.php model
public function getCapPriceAttribute()
{
    return GovernmentCap::where('region', $this->region)
                       ->where('fuel_type', $this->fuel_type)
                       ->latest('effective_date')
                       ->value('cap_price');
}
```

### Query Behavior
- Queries `government_caps` table
- Filters by region and fuel_type
- Orders by effective_date DESC (latest first)
- Returns cap_price value or null

### Performance
- Single query per pump
- Uses index on (region, fuel_type, effective_date)
- Minimal database overhead
- Fast response time

## Troubleshooting

### Cap Price Shows "Not set"
**Cause:** No GovernmentCap record matches pump's region/fuel_type

**Solution:**
1. Go to Admin > Government Cap Prices
2. Upload Excel with matching region and fuel type
3. Example: If pump is "Lagos Petrol", upload with:
   - Region: Lagos
   - Petrol Price: 248.00

### Price Doesn't Update After Upload
**Cause:** Page is cached in browser

**Solution:**
1. Clear browser cache (Ctrl+F5 on most browsers)
2. Or try in a new incognito window
3. Or wait a few seconds and refresh

### Display Shows Wrong Price
**Cause:** 
- Region name doesn't match exactly (case-sensitive)
- Fuel type doesn't match exactly

**Solution:**
1. Check Pump details - what's the exact region?
2. Check Government Cap upload - is region spelled same way?
3. Example: "Lagos" ≠ "LAGOS" ≠ "lagos"

## Future Enhancements

1. **Compare Prices** - Show indicator if pump price > cap price
2. **Warnings** - Alert if pump price exceeds cap
3. **History** - Show previous cap prices
4. **Bulk Update** - Auto-update pump prices from cap
5. **Notifications** - Alert admin if cap changes
6. **Reports** - Show compliance with caps

## Files Modified

| File | Type | Purpose |
|------|------|---------|
| `app/Http/Controllers/SalesController.php` | Modified | Load cap prices |
| `resources/views/sales/create.blade.php` | Modified | Display cap prices |

## Testing

To test this feature:

1. **Upload Government Caps:**
   - Go to Admin > Government Cap Prices
   - Upload Excel with regions and prices

2. **Create Sales:**
   - Open Sales > Record Sale
   - Select different pumps
   - Verify cap price displays for each

3. **Verify Matching:**
   - Pump region should match cap region
   - Pump fuel type should match cap fuel type
   - Display should show matching price

## Summary

The system now provides attendants with instant visibility of government cap prices when recording sales. This helps with:
- ✅ Compliance checking
- ✅ Price awareness
- ✅ Margin management
- ✅ Better decision making

The feature is fully automatic - no manual configuration needed. Just upload government caps and they're automatically matched to pumps.
