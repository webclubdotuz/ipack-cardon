<?php

namespace App\Livewire\User;

use App\Models\Transaction;
use Livewire\Component;

class Purchase extends Component
{
    public $user, $transactions;

    public $start_date;
    public $end_date;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    public function render()
    {
        $this->transactions = Transaction::where('user_id', $this->user->id)
        ->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
        ->where('type', 'purchase')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('livewire.user.purchase');
    }
}
