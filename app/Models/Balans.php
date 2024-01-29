<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balans extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'amount',
        'method',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class);
    }
}
