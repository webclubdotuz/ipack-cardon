<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    use HasFactory;

    protected $fillable = [
        'cardon_id',
        'user_id',
        'quantity',
        'description',
        'created_at',
    ];

    public function cardon()
    {
        return $this->belongsTo(Cardon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest Author',
        ]);
    }
}
