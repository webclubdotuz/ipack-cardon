<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'user_id',
        'type',
        'status',
        'payment_status',
        'total',
        'description',
        'created_at',
        'tax',
    ];

    public function scopeSales($query)
    {
        return $query->where('type', 'sale');
    }

    public function rolls()
    {
        return $this->hasMany(Roll::class);
    }

    public function scopePurchases($query)
    {
        return $query->where('type', 'purchase');
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getPaidAttribute()
    {
        return $this->payments->sum('amount');
    }

    public function getDebtAttribute()
    {
        return $this->total - $this->paid;
    }

    public function getContactFullNameAttribute()
    {
        return $this->contact->full_name;
    }

    // payment status - pending, debt, paid
    public function getPaymentStatusHtmlAttribute()
    {
        if ($this->payment_status == 'pending')
        {
            return '<span class="badge bg-warning">Ожидается</span>';
        }
        elseif ($this->payment_status == 'debt')
        {
            return '<span class="badge bg-danger">Долг (' . nf($this->debt) . ')</span>';
        }
        elseif ($this->payment_status == 'paid')
        {
            return '<span class="badge bg-success">Оплачено</span>';
        }
    }

    public function getStatusHtmlAttribute()
    {
        if ($this->status == 'pending')
        {
            return '<span class="badge bg-danger">Ожидается</span>';
        }
        elseif ($this->status == 'transport')
        {
            return '<span class="badge bg-warning">Транспорт</span>';
        }
        elseif ($this->status == 'completed')
        {
            return '<span class="badge bg-success">Завершено</span>';
        }

        return '<span class="badge bg-secondary">Неизвестно</span>';
    }



}
