<?php

namespace App\Livewire\Contact;

use App\Models\Transaction;
use Livewire\Component;
use Livewire\WithPagination;

class Sale extends Component
{
    public $contact, $transactions;
    public $start_date;
    public $end_date;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    public function render()
    {

        // dd($this->contact);
        $this->transactions = Transaction::where('contact_id', $this->contact->id)
            ->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
            ->where('type', 'sale')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('livewire.contact.sale');
    }
}
