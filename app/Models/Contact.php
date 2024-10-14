<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'fullname',
        'org_name',
        'phone',
        'type',
        'address',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'contact_id');
    }

    public function getCustomerBalanceAttribute()
    {
        $total = 0;

        $transactions = Transaction::where('contact_id', $this->id)->where('type', 'sale')->sum('total');
        $payments = Payment::where('contact_id', $this->id)->whereHas('transaction', function ($query) {
            $query->where('type', 'sale')->where('status', 'completed')->where('contact_id', $this->id);
        })->sum('amount');

        $total = $payments - $transactions;

        return $total;
    }

    public function getSupplierBalanceAttribute()
    {
        $total = 0;

        $transactions = Transaction::where('contact_id', $this->id)->where('type', 'purchase')->sum('total');
        $payments = Payment::where('contact_id', $this->id)->whereHas('transaction', function ($query) {
            $query->where('type', 'purchase')->where('status', 'completed')->where('contact_id', $this->id);
        })->sum('amount');

        $total = $transactions - $payments;

        return $total;
    }


}
