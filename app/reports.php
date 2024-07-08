<?php

function getTransactionsTotal($year, $month, $type)
{
    return \App\Models\Transaction::whereYear('created_at', $year)
    ->whereMonth('created_at', $month)
    ->whereIn('type', $type)
    ->whereIn('status', ['transport', 'completed'])
    ->sum('total');
}

function getTransactionsDebt($year, $month, $type)
{
    $transactions = \App\Models\Transaction::whereYear('created_at', $year)
    ->whereMonth('created_at', $month)
    ->whereIn('type', $type)
    ->where('payment_status', 'debt')
    ->whereIn('status', ['transport', 'completed'])
    ->get();

    $debt = 0;
    foreach ($transactions as $transaction) {
        $debt += $transaction->debt;
    }

    return $debt;
}

function getBalansYM($year, $month, $method=null)
{
    return \App\Models\Balans::whereYear('created_at', $year)
    ->whereMonth('created_at', $month)
    ->when($method, function ($query, $method) {
        return $query->where('method', $method);
    })
    ->sum('amount');

}

function getExpensesYM($year, $month, $expense_category_id, $method=null)
{

    if (is_null($expense_category_id)) {
        return \App\Models\Expense::whereYear('created_at', $year)
        ->whereMonth('created_at', $month)
        ->when($method, function ($query, $method) {
            return $query->where('method', $method);
        })
        ->sum('amount');
    }

    return \App\Models\Expense::whereYear('created_at', $year)
    ->whereMonth('created_at', $month)
    ->when($method, function ($query, $method) {
        return $query->where('method', $method);
    })
    ->where('expense_category_id', $expense_category_id)
    ->sum('amount');

}


function getPaymentSumma($year, $month, $method, $type)
{
    $paymentSumma = \App\Models\Payment::whereYear('created_at', $year)
    ->whereMonth('created_at', $month)
    ->when($method, function ($query, $method) {
        return $query->where('method', $method);
    })
    ->when($type, function ($query, $type) {
        return $query->whereHas('transaction', function ($query) use ($type) {
            $query->where('type', $type);
        });
    })
    ->sum('amount');

    return $paymentSumma;
}


function getUserRolls($year, $month)
{
    return \App\Models\Roll::whereYear('used_date', $year)
    ->whereMonth('used_date', $month)
    ->sum('total');
}

function getUsedProducts($year, $month)
{
    return \App\Models\ProductUsed::whereYear('created_at', $year)
    ->whereMonth('created_at', $month)
    ->sum('total');
}


function getPaymentDateSumma($start_date, $end_date, $method, $type)
{
    $paymentSumma = \App\Models\Payment::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
    ->when($method, function ($query, $method) {
        return $query->where('method', $method);
    })
    ->when($type, function ($query, $type) {
        return $query->whereHas('transaction', function ($query) use ($type) {
            $query->where('type', $type);
        });
    })
    ->sum('amount');

    return $paymentSumma;
}

// expense
function getExpensesDateSumma($start_date, $end_date, $expense_category_id=null, $method=null)
{

    if (is_null($expense_category_id)) {
        return \App\Models\Expense::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
        ->when($method, function ($query, $method) {
            return $query->where('method', $method);
        })
        ->sum('amount');
    }

    return \App\Models\Expense::whereBetween('created_at', [$start_date . ' 00:00:00', $end_date . ' 23:59:59'])
    ->when($method, function ($query, $method) {
        return $query->where('method', $method);
    })
    ->where('expense_category_id', $expense_category_id)
    ->sum('amount');

}

