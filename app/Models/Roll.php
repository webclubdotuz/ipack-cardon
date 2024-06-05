<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roll extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'user_id',
        'size',
        'weight',
        'paper_weight',
        'glue',
        'price',
        'total',
        'used',
        'used_date',
        'used_description',
        'used_user_id',
        'created_at',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function used_user()
    {
        return $this->belongsTo(User::class, 'used_user_id');
    }
}
