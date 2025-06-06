<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{

    // kassa
    public function kassa(Request $request)
    {
        $start_date = $request->start_date ?? date('Y-m-d');
        $end_date = $request->end_date ?? date('Y-m-d');


        return view('pages.reports.kassa', compact('start_date', 'end_date'));
    }


    public function opiu(Request $request)
    {

        $transactionYears = Transaction::selectRaw('year(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get();

        $selected_year = $request->selected_year ?? date('Y');

        $transactionMonths = Transaction::selectRaw('month(created_at) as month')
            ->whereRaw('year(created_at) = ?', [$selected_year])
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return view('pages.reports.opiu', compact('transactionYears', 'selected_year', 'transactionMonths'));
    }

    public function odds(Request $request)
    {
        $selected_year = $request->selected_year ?? date('Y');

        return view('pages.reports.odds', compact('selected_year'));
    }

    public function daxod(Request $request)
    {
        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');

        $payments = Payment::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->whereHas('transaction', function ($query) {
                $query->where('type', 'sale');
            })
            ->selectRaw('sum(amount) as amount, date(created_at) as date')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $data = [];
        $labels = [];

        foreach ($payments as $payment) {
            $data[] = $payment->amount;
            $labels[] = $payment->date;
        }

        $payments = Payment::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->whereHas('transaction', function ($query) {
                $query->where('type', 'sale');
            })
            ->selectRaw('sum(amount) as amount, method as method')
            ->groupBy('method')
            ->orderBy('amount', 'desc')
            ->get();

        $sales = Sale::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
        ->selectRaw('sum(total) as total, cardon_id')
        ->groupBy('cardon_id')
        ->orderBy('total', 'asc')
        ->get();

        $dataProducts = [];
        $labelsProducts = [];

        foreach ($sales as $sale) {
            $dataProducts[] = $sale->total;
            $labelsProducts[] = $sale->cardon->name;
        }



        return view('pages.reports.daxod', compact('start_date', 'end_date', 'data', 'labels', 'payments', 'dataProducts', 'labelsProducts', 'sales'));
    }


    public function expense(Request $request)
    {

        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');

        $expenses = \App\Models\Expense::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
            ->selectRaw('sum(amount) as amount, expense_category_id')
            ->groupBy('expense_category_id')
            ->orderBy('amount', 'desc')
            ->get();
        $data = [];
        $labels = [];

        foreach ($expenses as $expense) {
            $data[] = $expense->amount;
            $labels[] = $expense->expense_category->name;
        }

        return view('pages.reports.expense', compact('start_date', 'end_date', 'data', 'labels', 'expenses'));
    }

    public function balans(Request $request)
    {

        $start_date = $request->start_date ?? date('Y-m-01');
        $end_date = $request->end_date ?? date('Y-m-d');

        $products = \App\Models\Product::all();
        $product_summa = 0;
        foreach ($products as $product) {
            $product_summa += $product->price * $product->quantity;
        }

        $rolls = \App\Models\Roll::where('used', 0)->get();
        $roll_summa = $rolls->sum('total');

        $cardons = \App\Models\Cardon::all();
        $cardon_summa = 0;
        foreach ($cardons as $cardon) {
            $cardon_summa += $cardon->price * $cardon->quantity;
        }

        return view('pages.reports.balans', compact('start_date', 'end_date', 'product_summa', 'roll_summa', 'cardon_summa'));
    }
}
