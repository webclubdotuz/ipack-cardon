<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Press extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'quantity',
        'description',
        'image',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function sale()
    {
        return $this->hasOne(Sale::class);
    }

    public function users()
    {
        return $this->hasMany(PressUser::class, 'press_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
