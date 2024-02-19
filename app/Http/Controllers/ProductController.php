<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductUser;
use App\Models\Roll;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('name')->get();
        $roll_count = Roll::orderBy('name')->where('used', 0)->count();

        return view('pages.products.index', compact('products', 'roll_count'));
    }

    public function create()
    {
        return view('pages.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
        ]);


        $product = Product::create([
            'name'=> $request->name,
            'price'=> $request->price,
            'quantity'=> 0,
            'description'=> $request->description,
        ]);

        return redirect()->route('products.index')->with('success','Продукт успешно добавлен');
    }

    public function show(Product $product)
    {
        return view('pages.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        return view('pages.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|min:3',
            'price' => 'required|numeric',
        ]);

        $product->update([
            'name'=> $request->name,
            'price'=> $request->price,
            'description'=> $request->description,
        ]);

        return redirect()->route('products.index')->with('success','Продукт успешно обновлен');
    }

    public function destroy(Product $product)
    {
//        $product->delete();
        return redirect()->route('products.index')->with('success','Продукт успешно удален');
    }
}
