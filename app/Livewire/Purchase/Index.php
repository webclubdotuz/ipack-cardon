<?php

namespace App\Livewire\Purchase;

use App\Models\Transaction;
use Livewire\Component;
use App\Models\Purchase;
use App\Models\Roll;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class Index extends Component
{

    use WithPagination;

    public $start_date, $end_date, $type;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    protected $listeners = ['refreshPurchases' => '$refresh'];

    public function delete($id)
    {

        DB::beginTransaction();
        try {

            $purchases = Purchase::where('transaction_id', $id)->get();
            foreach ($purchases as $purchase) {
                $product = $purchase->product;
                $product->quantity += $purchase->quantity;
                $product->save();
                $purchase->delete();
            }

            $rolls = Roll::where('transaction_id', $id)->get();

            foreach ($rolls as $roll) {

                if ($roll->used) {
                    throw new \Exception('Roll is used');
                }

                $roll->delete();
            }

            Transaction::find($id)->delete();

            DB::commit();

            flash('Успешно удалено')->success();

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            flash('Ошибка', 'error');
            dd($th);
        }
    }

    public function render()
    {

        $transactions = Transaction::where('type', '!=', 'sale')
        ->when($this->type, function ($query) {
            return $query->where('type', $this->type);
        })
        ->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
        ->orderBy('created_at', 'desc')
        ->get();

        return view('livewire.purchase.index', compact('transactions'));
    }
}
