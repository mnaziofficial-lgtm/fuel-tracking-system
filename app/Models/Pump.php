<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pump extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'region',
        'code',
        'fuel_type',
        'price_per_litre',
        'stock',
        'low_stock_threshold',
    ];

    public function fuel()
    {
        return $this->belongsTo(Fuel::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function shifts()
    {
        return $this->hasMany(PumpShift::class);
    }

    public function governmentCap()
    {
        return $this->belongsTo(GovernmentCap::class, 'region', 'region')
                    ->where('fuel_type', $this->fuel_type)
                    ->latest('effective_date');
    }

    public function getCapPriceAttribute()
    {
        if (!$this->region || !$this->fuel_type) {
            return null;
        }
        
        return GovernmentCap::where('region', $this->region)
                           ->where('fuel_type', $this->fuel_type)
                           ->latest('effective_date')
                           ->value('cap_price');
    }
}
