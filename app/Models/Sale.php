<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'pump_id',
        'user_id',
        'litres_sold',
        'amount',
        'price_per_litre',
        'pump_shift_id',
    ];

    public function pump()
    {
        return $this->belongsTo(Pump::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
