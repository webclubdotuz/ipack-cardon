<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cardon extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'width',
        'length',
        'height',
        'layer',
        'salary_percent',
        'price',
    ];

    public function manufactures()
    {
        return $this->hasMany(Manufacture::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function getQuantityAttribute()
    {
        return $this->manufactures->sum('quantity') - $this->sales->sum('quantity');
    }

}
