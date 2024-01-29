<?php

namespace App\Livewire\Purchase;

use App\Models\Transaction;
use Livewire\Component;
use App\Models\Purchase;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public $start_date, $end_date;

    public function mount()
    {
        $this->start_date = date('Y-m-d');
        $this->end_date = date('Y-m-d');
    }

    protected $listeners = ['refreshPurchases' => '$refresh'];

    public function delete($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        $this->emit('refreshPurchases');
    }

    public function render()
    {

        $transactions = Transaction::whereIn('type', ['purchase', 'roll'])
        ->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
        ->orderBy('created_at', 'desc')
        ->paginate(100);

        return view('livewire.purchase.index', compact('transactions'));
    }
}
