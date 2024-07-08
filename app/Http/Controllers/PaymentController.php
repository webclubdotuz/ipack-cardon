<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function index(Request $request)
    {

        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d');
        $type = $request->type ?? '';
        $method = $request->method ?? '';

        $payments = Payment::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->when($type, function ($query, $type) {
                return $query->whereHas('transaction', function ($query) use ($type) {
                    $query->where('type', $type);
                });
            })
            ->when($method, function ($query, $method) {
                return $query->where('method', $method);
            })->orderBy('created_at', 'desc')
            ->get();



        return view('pages.payments.index', compact('payments', 'start_date', 'end_date', 'type', 'method'));
    }

    public function edit(Payment $payment)
    {
        return view('pages.payments.edit', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'method' => 'required',
            'created_at' => 'required|date',
        ]);

        DB::beginTransaction();

        try {

            $payment->update([
                'amount' => $request->amount,
                'method' => $request->method,
                'created_at' => $request->created_at,
            ]);


            $transaction = $payment->transaction;

            if ($transaction->paid > $transaction->total)
            {
                flash('Оплаченная сумма не может быть больше общей суммы', 'danger');
                throw new \Exception('Оплаченная сумма не может быть больше общей суммы');
            }

            if ($transaction->paid == $transaction->total)
            {
                $transaction->update([
                    'payment_status' => 'paid',
                ]);
            }

            if ($transaction->paid < $transaction->total)
            {
                $transaction->update([
                    'payment_status' => 'debt',
                ]);
            }

            flash('Оплата успешно обновлена');

            return redirect()->route('payments.index');

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return back();
        }

    }
}
