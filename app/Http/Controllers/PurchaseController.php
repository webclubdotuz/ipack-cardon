<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function  index()
    {

        $transactions = Transaction::whereIn('type', ['purchase', 'roll'])->orderBy('id', 'desc')->paginate(100);

        return view('pages.purchases.index', compact('transactions'));
    }

    public function create()
    {
        return view('pages.purchases.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.price' => 'required|numeric',
            'contact_id' => 'required|exists:contacts,id',
            'amount' => 'required|numeric',
            'method' => 'required',
        ]);

        try {
            $transaction = Transaction::create([
                'contact_id' => $request->contact_id,
                'user_id' => auth()->user()->id,
                'type' => 'purchase',
                'status' => 'completed',
                'payment_status' => 'debt',
                'total' => 0,
                'description' => $request->description,
            ]);

            foreach ($request->products as $product) {
                Purchase::create([
                    'transaction_id' => $transaction->id,
                    'user_id' => auth()->user()->id,
                    'product_id' => $product['product_id'],
                    'quantity' => $product['quantity'],
                    'price' => $product['price'],
                    'total' => $product['quantity'] * $product['price'],
                    'description' => $product['description'] ?? null,
                ]);
            }

            $transaction->update([
                'total' => $transaction->purchases->sum('total'),
            ]);

            $payment = new PaymentService();
            $payment->create($transaction->id, $request->amount, $request->method, $request->description);

            DB::commit();

            return redirect()->back()->with('success', 'Покупка успешно добавлена');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }

    }

}
