<?php

namespace App\Livewire\Contact;

use App\Models\Contact;
use App\Models\Transaction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Purchase extends Component
{

    use LivewireAlert;
    public $contact, $transactions;
    public $start_date;
    public $end_date;




    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    public function delete($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        $this->alert('success', 'Успешно удалено');
        $this->js('location.reload();');
    }

    public function render()
    {

        $this->transactions = Transaction::where('contact_id', $this->contact->id)
            ->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
            ->whereIn('type', ['purchase', 'roll'])
            ->get();

        return view('livewire.contact.purchase');
    }
}
