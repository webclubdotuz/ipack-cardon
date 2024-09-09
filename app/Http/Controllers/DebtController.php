<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function customer()
    {

        $customers = \App\Models\Contact::whereIn('type', ['customer', 'both'])
        ->whereHas('transactions', function ($query) {
            $query->where('type', 'sale')->where('payment_status', 'debt');
        })
        ->get();

        return view('pages.debts.customers', compact('customers'));
    }

    public function supplier()
    {
        return view('pages.debts.suppliers');
    }
}
