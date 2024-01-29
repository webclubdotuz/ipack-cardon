<?php

namespace App\Livewire\Sale;

use App\Models\Press;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class Create extends Component
{

    use LivewireAlert;

    public $product_id, $contact_id, $saleItem_ids = [];
    public $quantity, $price, $amount, $status;

    public $transaction;

    public $saleShow;

    protected $listeners = ['refreshSaleCreate' => '$refresh'];

    public function mount()
    {
        $this->transaction = Transaction::where('type', 'sale')->where('status', 'pending')->first();
    }

    protected function transaction_total()
    {
        $this->transaction->update([
            'total' => $this->transaction->sales->sum('total'),
        ]);
    }

    public function addCardPressAll($product_id)
    {
        $product = Product::find($product_id);

        $presses = Press::where('product_id', $product_id)->where('quantity', '>', 0)->doesntHave('saleItems')->get();

        if ($presses->count() == 0) {
            $this->alert('error', 'Нет товара на складе');
            return;
        }

        if ($this->transaction == null) {
            $this->transaction = Transaction::create([
                'type' => 'sale',
                'status' => 'pending',
                'user_id' => auth()->user()->id,
                'contact_id' => 1,
            ]);
        }

        $sale = Sale::where('transaction_id', $this->transaction->id)->where('product_id', $product_id)->first();

        if (!$sale) {
            $sale = Sale::create([
                'transaction_id' => $this->transaction->id,
                'product_id' => $product_id,
                'user_id' => auth()->user()->id,
                'count' => 0,
                'quantity' => 0,
                'price' => $product->price,
                'total' => $product->price,
                'user_salary' => 0,
            ]);
        }

        foreach ($presses as $press) {
            SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product_id,
                'press_id' => $press->id,
                'user_id' => auth()->user()->id,
                'quantity' => $press->quantity,
            ]);
        }

        $this->transaction_total();

        $this->alert('success', 'Товар добавлен в корзину');
    }

    public function addCardPress($product_id, $press_id)
    {
        $press = Press::find($press_id);
        $product = Product::find($product_id);

        if ($this->transaction == null) {
            $this->transaction = Transaction::create([
                'type' => 'sale',
                'status' => 'pending',
                'user_id' => auth()->user()->id,
                'contact_id' => 1,
            ]);
        }

        $sale = Sale::where('transaction_id', $this->transaction->id)->where('product_id', $product_id)->first();

        if (!$sale) {
            $sale = Sale::create([
                'transaction_id' => $this->transaction->id,
                'product_id' => $product_id,
                'user_id' => auth()->user()->id,
                'count' => 0,
                'quantity' => 0,
                'price' => $product->price,
                'total' => $product->price,
                'user_salary' => '0',
            ]);
        }

        $sale_item = SaleItem::create([
            'sale_id' => $sale->id,
            'product_id' => $product_id,
            'press_id' => $press_id,
            'user_id' => auth()->user()->id,
            'quantity' => $press->quantity,
        ]);

        $this->transaction_total();

        $this->alert('success', 'Товар добавлен в корзину');

    }

    public function addCardQuantity($product_id)
    {
        $this->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        $product = Product::find($product_id);

        $press = Press::where('product_id', $product_id)->where('quantity', $this->quantity)->doesntHave('saleItems')->first();

        if ($press == null) {
            $this->alert('error', 'Нет товара с таким количеством');
            return;
        }

        try {
            //code...
            if ($this->transaction == null) {
                $this->transaction = Transaction::create([
                    'type' => 'sale',
                    'status' => 'pending',
                    'user_id' => auth()->user()->id,
                    'contact_id' => 1,
                ]);
            }

            $sale = Sale::where('transaction_id', $this->transaction->id)->where('product_id', $product_id)->first();

            if (!$sale) {
                $sale = Sale::create([
                    'transaction_id' => $this->transaction->id,
                    'product_id' => $product_id,
                    'user_id' => auth()->user()->id,
                    'count' => 0,
                    'quantity' => 0,
                    'price' => $product->price,
                    'total' => $product->price,
                    'user_salary' => '0',
                ]);
            }

            $sale_item = SaleItem::create([
                'sale_id' => $sale->id,
                'product_id' => $product_id,
                'press_id' => $press->id,
                'user_id' => auth()->user()->id,
                'quantity' => $press->quantity,
            ]);

            $this->transaction_total();

            $this->alert('success', 'Товар добавлен в корзину');
            $this->reset('quantity');
        } catch (\Throwable $th) {
            //throw $th;
            $this->alert('error', 'Ошибка добавления товара в корзину');
        }

    }

    public function showModal($sale_id)
    {
        $this->saleShow = Sale::find($sale_id);
        $this->dispatch('showModal');
        $this->dispatch('initSelect2');
    }

    public function editSalePrice($sale_id)
    {
        $this->validate([
            'price' => 'required|numeric|min:0',
        ]);

        $sale = Sale::find($sale_id);
        $sale->price = $this->price;
        $sale->save();

        foreach ($this->transaction->sales as $sale) {
            $sale->total = $sale->price * $sale?->saleItems->sum('quantity');
            $sale->save();
        }

        $this->transaction->total = $this->transaction->sales->sum('total');
        $this->transaction->save();

        $this->alert('success', 'Цена успешно изменена');
    }

    public function deleteSaleItem($sale_item_id)
    {
        $sale_item = SaleItem::find($sale_item_id);
        $sale_item->delete();

        $this->alert('success', 'Товар удален из корзины');

        if ($this->transaction->sales->count() == 0) {
            $this->transaction->delete();
            $this->reset();
        } else {
            $this->reset();
            $this->transaction = Transaction::where('type', 'sale')->where('status', 'pending')->first();
            $this->transaction->save();
        }

        $this->dispatch('dismissModal');
    }

    public function deleteSaleItems()
    {
        // saleItem_ids
        $sale_items = SaleItem::whereIn('id', $this->saleItem_ids)->get();
        foreach ($sale_items as $sale_item) {
            $sale_item->delete();
        }

        if ($this->transaction->sales->count() == 0) {
            $this->transaction->delete();
            $this->reset();
        } else {
            $this->reset();
            $this->transaction = Transaction::where('type', 'sale')->where('status', 'pending')->first();
            $this->transaction->save();
        }

        $this->alert('success', 'Товары удалены из корзины');
        $this->dispatch('dismissModal');

    }

    public function save()
    {

        $this->validate([
            'contact_id' => 'required',
            'status' => 'required',
            'amount' => 'nullable|numeric|min:0',
        ]);

        if ($this->transaction?->sales->count() == 0) {
            $this->alert('error', 'Добавьте товары');
            return;
        }

        if ($this->amount > $this->transaction->debt) {
            $this->alert('error', 'Сумма оплаты не может быть больше суммы долга');
            return;
        }

        DB::beginTransaction();

        try {
            //code...
            $this->transaction->total = $this->transaction->sales->sum('total');
            $this->transaction->status = $this->status;
            $this->transaction->payment_status = 'debt';
            $this->transaction->contact_id = $this->contact_id;

            $this->transaction->save();

            if ($this->amount > 0 && $this->amount <= $this->transaction->debt) {
                $this->transaction->payments()->create([
                    'contact_id' => $this->contact_id,
                    'amount' => $this->amount,
                    'method' => 'cash',
                    'user_id' => auth()->user()->id,
                ]);
            }

            foreach ($this->transaction->sales as $sale) {
                $sale->user_salary = $sale->quantity * getSalary(auth()->user()->id, $sale->product->id);
                $sale->save();
            }

            DB::commit();
            $this->reset();
            $this->alert('success', 'Продажа успешно завершена');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            $this->alert('error', 'Ошибка завершения продажи' . $th->getMessage());
        }
    }

    public function cardClear()
    {
        if ($this->transaction) {
            $this->transaction->delete();
            $this->reset();
        }

        $this->alert('success', 'Корзина очищена');
    }


    public function render()
    {
        $transaction = Transaction::where('type', 'sale')->where('status', 'pending')->get();
        $this->dispatch('refreshSaleIndex');
        $this->dispatch('initSelect2');
        return view('livewire.sale.create');
    }

    public function dehydrate()
    {
        $this->dispatch('initSelect2');
    }
}
