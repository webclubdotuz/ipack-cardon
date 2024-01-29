<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PressUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'press_id',
        'user_id',
        'admin_id',
        'amount',
    ];

    public function press()
    {
        return $this->belongsTo(Press::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function admin()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
