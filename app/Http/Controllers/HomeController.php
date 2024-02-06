<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $start_date = now()->startOfMonth();
        $end_date = now();

        $contact_count = \App\Models\Contact::count();

        $sale_debt_sum = 0;
        $sale_debt = \App\Models\Transaction::where('type', 'sale')
            ->where('payment_status', 'debt')
            ->get();
        foreach ($sale_debt as $sale) {
            $sale_debt_sum += $sale->debt;
        }

        $purchase_debt_sum = 0;
        $purchase_debt = \App\Models\Transaction::whereIn('type', ['purchase', 'roll'])
            ->where('payment_status', 'debt')
            ->get();
        foreach ($purchase_debt as $purchase) {
            $purchase_debt_sum += $purchase->debt;
        }

        $purchase_sum = \App\Models\Transaction::whereIn('type', ['purchase', 'roll'])
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->where('status', 'completed')
            ->sum('total');

        $sale_sum = \App\Models\Transaction::where('type', 'sale')
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->where('status', 'completed')
            ->sum('total');

            $dateRange = [];
            for ($date = $start_date; $date->lte($end_date); $date->addDay()) {
                $dateRange[] = $date->format('Y-m-d');
            }

            $payments = \App\Models\Payment::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->whereHas('transaction', function ($query) {
                    $query->where('type', 'sale');
                })
                ->groupBy('date')
                ->selectRaw('date(created_at) as date, sum(amount) as sum')
                ->get();

            // dd($payments);

            $paymentLabels = [];
            $paymentData = [];
            foreach ($dateRange as $date) {
                foreach ($payments as $payment) {
                    if ($date == $payment->date) {
                        $paymentLabels[] = $date;
                        $paymentData[] = $payment->sum;
                    }
                    else {
                        $paymentLabels[] = $date;
                        $paymentData[] = 0;
                    }
                }
            }

            // dd($paymentLabels, $paymentData);

            $payment_methods = \App\Models\Payment::whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
                ->whereHas('transaction', function ($query) {
                    $query->where('type', 'sale');
                })
                ->groupBy('method')
                ->selectRaw('method, sum(amount) as sum')
                ->get();


        return view('home', compact(
            'contact_count',
            'sale_debt_sum',
            'purchase_debt_sum',
            'purchase_sum',
            'sale_sum',
            'paymentLabels',
            'paymentData',
            'payment_methods'
        ));
    }
}
