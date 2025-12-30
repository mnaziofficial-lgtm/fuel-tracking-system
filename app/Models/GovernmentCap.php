<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GovernmentCap extends Model
{
    use HasFactory;

    protected $fillable = [
        'region', 'fuel_type', 'cap_price', 'effective_date'
    ];

    public function scopeByRegion($query, $region)
    {
        if ($region && $region !== 'all') {
            return $query->where('region', $region);
        }
        return $query;
    }
}

