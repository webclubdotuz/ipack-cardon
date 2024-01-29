<?php

namespace App\Livewire\Transaction;

use App\Models\Sale;
use App\Models\Transaction;
use Livewire\Component;

class ChangeStatus extends Component
{

    public $transaction;
    public $status;
    public $losses = [];

    protected $listeners = [
        'openModalChangeStatus' => 'openModalChangeStatus'
    ];

    public function mount()
    {
        // losses.sale.{{ $sale->id }}
        // losses.sale_comment.{{ $sale->id }}

    }

    public function openModalChangeStatus($transaction_id)
    {
        $this->transaction = Transaction::find($transaction_id);
        foreach ($this->transaction->sales as $sale) {
            $this->losses['sale'][$sale->id] = $sale->quantity;
            $this->losses['sale_comment'][$sale->id] = $sale->loss_comment;
        }
        $this->dispatch('openModalTransaction');
    }

    public function save()
    {
        $this->validate([
            'status' => 'required',
            'losses' => 'required|array',
            'losses.sale' => 'required|array',
            'losses.sale_comment' => 'required|array',
        ]);

        // dd($this->losses);
        $this->transaction->status = $this->status;

        // dd($this->losses);
        if(array_key_exists('sale', $this->losses))
        {
            foreach ($this->losses['sale'] as $key => $value) {
                $sale = Sale::find($key);
                $sale->loss = $sale->saleItems->sum('quantity') - $value;
                $sale->quantity = $value;
                $sale->total = $value * $sale->price;
                $sale->save();
            }
        }

        if(array_key_exists('sale_comment', $this->losses))
        {
            foreach ($this->losses['sale_comment'] as $key => $value) {
                $sale = Sale::find($key);
                $sale->loss_comment = $value;
                $sale->save();
            }
        }

        $this->transaction->total = Sale::where('transaction_id', $this->transaction->id)->sum('total');
        $this->transaction->save();

        return redirect(url()->previous())->with('success', 'Статус успешно изменен');
    }
    public function render()
    {
        return view('livewire.transaction.change-status');
    }
}
