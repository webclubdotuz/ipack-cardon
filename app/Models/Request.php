<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'user_id',
        'deadline',
        'description',
        'status',
        'transaction_id',
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function getStatusHtmlAttribute()
    {
        $status = $this->status;
        $html = '';
        if ($status === 'pending') {
            $html = '<span class="badge bg-warning">В ожидании</span>';
        } elseif ($status === 'approved') {
            $html = '<span class="badge bg-success">Одобрено</span>';
        } elseif ($status === 'rejected') {
            $html = '<span class="badge bg-danger">Отклонено</span>';
        }
        return $html;
    }
}
