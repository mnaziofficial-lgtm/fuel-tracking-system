<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PumpShift extends Model
{
    protected $fillable = [
        'user_id',
        'pump_id',
        'shift_period',
        'opening_meter',
        'closing_meter',
        'meter_litres',
        'system_litres',
        'total_amount',
        'status',
        'opened_at',
        'closed_at',
    ];

    protected $casts = [
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
        'opening_meter' => 'float',
        'closing_meter' => 'float',
        'meter_litres' => 'float',
        'system_litres' => 'float',
        'total_amount' => 'float',
    ];

    public function pump(){
        return $this->belongsTo(Pump::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Computed property for difference
    public function getDifferenceLitresAttribute()
    {
        return ($this->meter_litres ?? 0) - ($this->system_litres ?? 0);
    }
}
