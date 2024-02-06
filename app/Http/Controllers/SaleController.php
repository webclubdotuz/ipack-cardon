<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Request as ModelsRequest;
use App\Models\Transaction;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('type', 'sale')->get();
        return view('pages.sales.index', compact('transactions'));
    }

    public function create()
    {
        return view('pages.sales.create');
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
                'type' => 'sale',
                'status' => 'completed',
                'payment_status' => 'debt',
                'total' => 0,
                'description' => $request->description,
            ]);

            foreach ($request->products as $product) {
                Sale::create([
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

            return redirect()->route('sales.index')->with('success', 'Покупка успешно добавлена');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

}
