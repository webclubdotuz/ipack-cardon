<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RollUsed extends Model
{
    use HasFactory;

    protected $fillable = [
        'roll_id',
        'user_id',
        'weight',
        'description',
        'date',
    ];

    public function roll()
    {
        return $this->belongsTo(Roll::class);
    }
}
