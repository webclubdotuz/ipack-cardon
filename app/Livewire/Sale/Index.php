<?php

namespace App\Livewire\Sale;

use App\Models\Transaction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Index extends Component
{

    use LivewireAlert;

    public $start_date, $end_date;

    protected $listeners = ['refreshSaleIndex' => '$refresh'];

    public function mount()
    {
        $this->start_date = date('Y-m-d');
        $this->end_date = date('Y-m-d');
    }

    public function delete($id)
    {
        $transaction = Transaction::find($id);
        $transaction->delete();
        $this->alert('success', 'Продажа удалена');
        $this->dispatch('refreshSaleCreate');
    }
    public function render()
    {

        $transactions = Transaction::where('type', 'sale')
        ->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
        ->where('status', '!=', 'pending')
        ->orderBy('created_at', 'desc')
        ->get();

        return view('livewire.sale.index', compact('transactions'));
    }
}
