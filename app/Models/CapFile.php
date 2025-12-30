<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CapFile extends Model
{
    protected $table = 'cap_files';
    
    protected $fillable = ['file_path', 'user_id', 'original_name'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
