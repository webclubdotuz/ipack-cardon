<?php

namespace App\Livewire\Product;

use App\Models\ProductUsed;
use Livewire\Component;

class Used extends Component
{
    public $product;

    public $start_date, $end_date;

    public function mount()
    {
        $this->start_date = date('Y-m-01');
        $this->end_date = date('Y-m-d');
    }

    public function delete($id)
    {
        $product_used = ProductUsed::find($id);
        $product = $product_used->product;
        $product->quantity += $product_used->quantity;
        $product->save();
        $product_used->delete();

        session()->flash('success', 'Успешно удалено');

    }

    public function render()
    {

        $product_useds = ProductUsed::where('product_id', $this->product->id)
        ->whereBetween('created_at', [$this->start_date . ' 00:00:00', $this->end_date . ' 23:59:59'])
        ->orderBy('created_at', 'desc')->get();




        return view('livewire.product.used', compact('product_useds'));
    }
}
