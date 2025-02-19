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

    public function roll_useds()
    {
        return $this->hasMany(RollUsed::class);
    }

    public function getBalanceAttribute()
    {
        return $this->weight - $this->roll_useds()->sum('weight');
    }

    // glue name
    public function getGlueNameAttribute()
    {
        // белы, крашный,
        // 0-нет, 1-есть, 2-белы, 3-крашный
        $glue = [
            0 => 'нет',
            1 => 'есть',
            2 => 'белы',
            3 => 'крашный',
        ];

        if (isset($glue[$this->glue])) {
            return $glue[$this->glue];
        }else {
            return '...';
        }
    }
}
