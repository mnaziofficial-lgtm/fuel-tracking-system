<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function pumps()
    {
        return $this->hasMany(Pump::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
