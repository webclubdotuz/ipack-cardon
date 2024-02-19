<?php
use App\Models\User;

function hasRoles($roles = ['admin'], $id = null)
{
    $id = $id ?? auth()->user()->id;
    return User::where('id', $id)->whereHas('roles', function ($query) use ($roles) {
        $query->whereIn('name', $roles);
    })->exists();
}

function getBalance($user_id = null)
{
    if (is_null($user_id)) {
        $user_id = auth()->user()->balance;
    }

    return User::find($user_id)->balance;
}

function getUsers($roles = ['admin'])
{
    return User::whereHas('roles', function ($query) use ($roles) {
        $query->whereIn('slug', $roles);
    })->get();
}
function getAllUsers()
{
    return User::orderBy('fullname')->get();
}

function df($date, $format = 'd.m.Y')
{
    return \Carbon\Carbon::parse($date)->format($format);
}

// number format
function nf($number, $decimals = 0, $dec_point = '.', $thousands_sep = ',')
{

    if (is_null($number)) {
        return 0;
    }

    return number_format($number, $decimals, $dec_point, $thousands_sep);
}

function purchaseQuantityDate($product_id, $date)
{
    return \App\Models\Purchase::where('product_id', $product_id)->whereDate('created_at', $date)->sum('quantity');
}

function pressQuantityDate($product_id, $date)
{
    return \App\Models\Press::where('product_id', $product_id)->whereDate('created_at', $date)->count();
}
function pressQuantityKgDate($product_id, $date)
{
    return \App\Models\Press::where('product_id', $product_id)->whereDate('created_at', $date)->sum('quantity');
}


// getSuppliers
function getContacts($types = ['customer', 'both'], $id = null)
{
    return \App\Models\Contact::whereIn('type', $types)
        ->when($id, function ($query, $id) {
            return $query->where('id', '!=', $id);
        })
    ->orderBy('fullname')->get();
}

function getProducts()
{
    return \App\Models\Product::orderBy('name')->get();
}

function getMyProducts()
{

    // if (hasRoles(['admin'])) {
    //     return \App\Models\Product::orderBy('name')->get();
    // }

    return \App\Models\Product::whereHas('users', function ($query) {
        $query->where('user_id', auth()->user()->id);
    })->orderBy('name')->get();
}

function transaction_products($transaction_id)
{
    $product_ids = \App\Models\Sale::where('transaction_id', $transaction_id)->groupBy('product_id')->pluck('product_id');

    return \App\Models\Product::whereIn('id', $product_ids)->get();
}

function sale_product_quntity($product_id, $transaction_id)
{

    return \App\Models\Sale::where('product_id', $product_id)->where('transaction_id', $transaction_id)->count();
}

function transaction_product_sale($product_id, $transaction_id)
{

    return \App\Models\Sale::where('product_id', $product_id)->where('transaction_id', $transaction_id)->get();
}

function sale_product_quntity_kg($product_id, $transaction_id)
{
    // dd($product_id, $transaction_id);
    return \App\Models\Sale::where('product_id', $product_id)->where('transaction_id', $transaction_id)->sum('quantity');
}

function getStatuses()
{
    return [
        'transport' => 'Транспорт',
        'completed' => 'Завершен',
    ];
}
function getSaleStatus()
{
    return [
        'transport' => 'Транспорт',
        'completed' => 'Завершен',
    ];
}

function getSalary($user_id, $product_id)
{
    $salary =  \App\Models\ProductUser::where('user_id', $user_id)->where('product_id', $product_id)->first();

    return $salary ? $salary->salary : 0;
}

function getSalarySumma($user_id)
{
    $salary_summa =  0;

    return $salary_summa;
}

function getSalaryModelSumma($user_id)
{
    $salary_summa =  \App\Models\Salary::where('user_id', $user_id)->sum('amount');

    return $salary_summa;
}

function getPressSumma($user_id)
{
    $press_summa =  0;

    return $press_summa;
}

function getExpenseCategories()
{
    return \App\Models\ExpenseCategory::orderBy('name')->get();
}

function contactCount()
{
    return \App\Models\Contact::count();
}

function methods()
{
    return [
        'cash' => 'Наличные',
        'card' => 'Карта',
        'Click' => 'Click',
        'transfer' => 'Перевод',
    ];
}

function monthName($month)
{
    $mm = [
        '1' => 'январь',
        '2' => 'февраль',
        '3' => 'март',
        '4' => 'апрель',
        '5' => 'май',
        '6' => 'июнь',
        '7' => 'июль',
        '8' => 'август',
        '9' => 'сентябрь',
        '10' => 'октябрь',
        '11' => 'ноябрь',
        '12' => 'декабрь',
    ];

    // 03 == 3
    $month = (int) $month;

    return $mm[$month];
}

function getCardons()
{
    return \App\Models\Cardon::orderBy('name')->get();
}


?>
