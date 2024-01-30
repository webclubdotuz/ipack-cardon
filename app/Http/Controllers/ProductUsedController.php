<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductUsed;

class ProductUsedController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $product = Product::find($request->product_id);

        if ($product->quantity < $request->quantity) {
            return back()->with('error', 'Ошибка! Недостаточно товара на складе');
        }

        if ($product->shop)
        {
            return back()->with('error', 'Ошибка! Товар находится в продаже');
        }

        $product->quantity -= $request->quantity;
        $product->save();

        ProductUsed::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->user()->id,
            'quantity' => $request->quantity,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Товар списан со склада');
    }
}
