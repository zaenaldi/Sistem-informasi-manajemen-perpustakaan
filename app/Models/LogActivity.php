<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogActivity extends Model
{
    protected $fillable = ['description', 'user_id'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
