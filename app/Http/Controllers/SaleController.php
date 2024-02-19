<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Cardon;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Support\Facades\DB;
use App\Models\Request as ModelsRequest;

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

            return redirect()->route('sales.index')->with('success', 'Покупка успешно добавлена');

        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
        }
    }

}
