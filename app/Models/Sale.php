<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'cardon_id',
        'user_id',
        'quantity',
        'quantity',
        'price',
        'total',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function cardon()
    {
        return $this->belongsTo(Cardon::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
