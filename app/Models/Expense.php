<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'expense_category_id',
        'user_id',
        'to_user_id',
        'transaction_id',
        'amount',
        'method', // 'method',
        'description',
        'created_at',
    ];

    public function expense_category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function to_user()
    {
        return $this->belongsTo(User::class, 'to_user_id');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
