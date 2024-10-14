<?php

namespace App\Livewire\Transaction;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Payment extends Component
{

    use LivewireAlert;
    public $transaction;
    public $amount, $method, $description;

    protected $listeners = [
        'openModal' => 'openModal'
    ];

    public function openModal($transaction_id)
    {
        $this->transaction = Transaction::find($transaction_id);
        $this->dispatch('openModalPayment');
    }

    public function save()
    {
        $this->validate([
            'amount' => 'required|numeric|min:1|max:' . $this->transaction->debt
        ]);

        DB::beginTransaction();

        try {
            if ($this->transaction->debt < $this->amount) {
                $this->alert('error', 'The amount is greater than the debt', [
                    'position' =>  'center',
                    'timer' =>  3000,
                    'toast' =>  false,
                    'text' =>  '',
                    'confirmButtonText' =>  'Ok',
                    'cancelButtonText' =>  'Cancel',
                    'showCancelButton' =>  false,
                    'showConfirmButton' =>  true,
                ]);
                return;
            }



            $this->transaction->payments()->create([
                'contact_id' => $this->transaction->contact_id,
                'amount' => $this->amount,
                'method' => $this->method ?? 'cash',
                'user_id' => auth()->user()->id,
                'description' => $this->description,
            ]);

            DB::commit();
            $this->js('location.reload();');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            $this->alert('error', 'Something went wrong', [
                'position' =>  'center',
                'timer' =>  3000,
                'toast' =>  false,
                'text' =>  '',
                'confirmButtonText' =>  'Ok',
                'cancelButtonText' =>  'Cancel',
                'showCancelButton' =>  false,
                'showConfirmButton' =>  true,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.transaction.payment');
    }
}
