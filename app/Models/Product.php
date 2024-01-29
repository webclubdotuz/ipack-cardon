<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'unit',
        'image',
        'shop',
    ];

    protected $casts = [
        'in_price_lists' => 'array',
    ];


    public function presses()
    {
        return $this->hasMany(Press::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'product_id');
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function manufactures()
    {
        return $this->hasMany(Manufacture::class);
    }

    public function users()
    {
        return $this->hasMany(ProductUser::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getQuantityAttribute()
    {
        return $this->purchases->sum('quantity') + $this->manufactures->sum('quantity') - $this->sales->sum('quantity');
    }


}
