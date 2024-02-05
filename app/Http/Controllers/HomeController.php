<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {

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


        return view('home', compact(
            'contact_count',
            'sale_debt_sum',
            'purchase_debt_sum',
            'purchase_sum',
            'sale_sum'
        ));
    }
}
