<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductUsed;
use App\Services\TelegramService;

class ProductUsedController extends Controller
{

    public function index()
    {
        $productUseds = ProductUsed::latest()->get();

        foreach ($productUseds as $productUsed) {

            $product = Product::find($productUsed->product_id);
            $last_purchase_price = $product?->purchases->last()->price ?? 0;

            $productUsed->price = $last_purchase_price;
            $productUsed->total = $last_purchase_price * $productUsed->quantity;
            $productUsed->save();
        }

        return 'success';
    }

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

        $last_purchase_price = $product?->purchases->last()->price ?? 0;

        ProductUsed::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->user()->id,
            'quantity' => $request->quantity,
            'price' => $last_purchase_price,
            'total' => $last_purchase_price * $request->quantity,
            'description' => $request->description,
        ]);

        // 🛠Производственный расход
        // 📦Продукт: Крахмал клей (Россия)
        // 🖇Количество: 28 кг
        // 📅 Дата: 16 Mar 2024 08:04
        // 👨‍💻 Сотрудник: Иброхим Абдуллаев

        $text = "🛠Производственный расход\n";
        $text .= "📦Продукт: {$product->name}\n";
        $text .= "🖇Количество: {$request->quantity} {$product->unit}\n";
        $text .= "💰Цена: {$last_purchase_price} сум\n";
        $text .= "💵Сумма: " . $last_purchase_price * $request->quantity . " сум\n";
        $text .= "📅 Дата: " . now()->format('d M Y H:i') . "\n";
        $text .= "👨‍💻 Сотрудник: " . auth()->user()->fullname;

        TelegramService::sendChannel($text);

        return back()->with('success', 'Товар списан со склада');
    }
}
