<?php

namespace App\Livewire\Transaction;

use App\Models\Transaction;
use Livewire\Component;

class Show extends Component
{

    public $transaction;


    protected $listeners = [
        'openModalTransactionShow' => 'openModalTransactionShow'
    ];

    public function openModalTransactionShow($transaction_id)
    {
        $this->transaction = Transaction::find($transaction_id);
        $this->dispatch('openModalTransactionShowDis');
    }


    public function render()
    {
        return view('livewire.transaction.show');
    }
}
