<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CapPrice extends Model
{
    use HasFactory;
    
    protected $table = 'cap_prices';
    
    protected $fillable = ['file_path', 'uploaded_by', 'town', 'petrol', 'diesel', 'kerosene'];
    
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}