<?php

namespace App\Livewire\User;

use Livewire\Component;

class Sale extends Component
{

    public $transactions, $user;
    public $start_date, $end_date;
    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    public function render()
    {
        $this->transactions = \App\Models\Transaction::where('type', 'sale')
            ->where('user_id', auth()->user()->id)
            ->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
            ->where('status', '!=', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('livewire.user.sale');
    }
}
