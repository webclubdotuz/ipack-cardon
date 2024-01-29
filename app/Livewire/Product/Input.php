<?php

namespace App\Livewire\Product;

use Livewire\Component;

class Input extends Component
{

    public $product_id;

    public function render()
    {
        return view('livewire.product.input');
    }
}
