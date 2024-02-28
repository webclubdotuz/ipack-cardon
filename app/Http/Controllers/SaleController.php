<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Cardon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use App\Models\Request as ModelsRequest;
use App\Services\TelegramService;

class SaleController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('type', 'sale')->get();
        return view('pages.sales.index', compact('transactions'));
    }

    public function create()
    {
        $cardons = Cardon::orderBy('name')->get();
        return view('pages.sales.create', compact('cardons'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'cardons' => 'required|array',
            'cardons.*.cardon_id' => 'required|exists:cardons,id',
            'cardons.*.price' => 'required|numeric',
            'contact_id' => 'required|exists:contacts,id',
            'amount' => 'required|numeric',
            'method' => 'required',
        ]);

        try {
            $transaction = Transaction::create([
                'contact_id' => $request->contact_id,
                'user_id' => auth()->user()->id,
                'type' => 'sale',
                'status' => 'completed',
                'payment_status' => 'debt',
                'total' => 0,
                'description' => $request->description,
            ]);

            foreach ($request->cardons as $cardon) {
                Sale::create([
                    'transaction_id' => $transaction->id,
                    'user_id' => auth()->user()->id,
                    'cardon_id' => $cardon['cardon_id'],
                    'quantity' => $cardon['quantity'],
                    'price' => $cardon['price'],
                    'total' => $cardon['quantity'] * $cardon['price'],
                    'description' => $cardon['description'] ?? null,
                ]);
            }

            $transaction->update([
                'total' => $transaction->sales->sum('total'),
            ]);

            $payment = new PaymentService();
            $payment->create($transaction->id, $request->amount, $request->method, $request->description);

            if ($request->request_id)
            {
                $request = ModelsRequest::findOrFail($request->request_id);
                $request->update([
                    'status' => 'approved',
                    'transaction_id' => $transaction->id,
                ]);
            }



            DB::commit();

            // 🔔🔔🔔🔔🔔🔔
            // 📤Продажа
            // 🙎🏻‍♂️ Заказчик: Казбек
            // 📱 Телефон: 910977788
            // 📦Товары: Коныс (Нукус Мед Тех)
            // 💲Цена: 4700 Сум
            // 🖇Количество: 238 шт
            // 💰 Сумма: 3 456 000
            // ✅ Оплачено: 0
            // ❗️ Остаток: 3 456 000
            // 📅 Дата: 9 фев 2024 15:07
            // 👨‍💻 Сотрудник: Марат

            $text = "🔔🔔🔔🔔🔔🔔\n";
            $text .= "📤Продажа\n";
            $text .= "🙎🏻‍♂️ Заказчик: {$transaction->contact->fullname}\n";
            $text .= "📱 Телефон: {$transaction->contact->phone}\n";
            foreach ($transaction->sales as $sale) {
                $text .= "📦Товары: {$sale->cardon->name}\n";
                $text .= "💲Цена: " . number_format($sale->price, 0, '', ' ') . " Сум\n";
                $text .= "🖇Количество: {$sale->quantity} шт\n";
                $text .= "💰 Сумма: " . number_format($sale->total, 0, '', ' ') . "\n";
                $text .= "________________\n";
            }

            $text .= "💰 Общий сумма: " . number_format($transaction->total, 0, '', ' ') . "\n";
            $text .= "✅ Оплачено: " . number_format($transaction->payments->sum('amount'), 0, '', ' ') . "\n";
            $text .= "❗️ Остаток: " . number_format($transaction->total - $transaction->payments->sum('amount'), 0, '', ' ') . "\n";
            $text .= "📅 Дата: {$transaction->created_at->format('j M Y H:i')}\n";
            $text .= "👨‍💻 Сотрудник: {$transaction->user->fullname}";

            TelegramService::sendChannel($text);

            return redirect()->route('sales.index')->with('success', 'Покупка успешно добавлена');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

}
