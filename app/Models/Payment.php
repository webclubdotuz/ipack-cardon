<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'transaction_id',
        'user_id',
        'method',
        'amount',
        'description',
        'created_at',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
