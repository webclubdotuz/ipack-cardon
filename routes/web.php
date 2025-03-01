<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


// Login
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate')->middleware('guest');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // debts
    Route::group(['prefix' => 'debts', 'as' => 'debts.'], function () {
        Route::get('/customers', [\App\Http\Controllers\DebtController::class, 'customer'])->name('customers');
        Route::get('/suppliers', [\App\Http\Controllers\DebtController::class, 'supplier'])->name('suppliers');
    });

    // contacts
    Route::group(['prefix' => 'contacts', 'as' => 'contacts.'], function () {
        Route::get('/customers', [\App\Http\Controllers\ContactController::class, 'customers'])->name('customers');
        Route::get('/suppliers', [\App\Http\Controllers\ContactController::class, 'suppliers'])->name('suppliers');
        Route::get('/show/{contact}', [\App\Http\Controllers\ContactController::class, 'show'])->name('show');
        Route::post('/store', [\App\Http\Controllers\ContactController::class, 'store'])->name('store');
        Route::get('/edit/{contact}', [\App\Http\Controllers\ContactController::class, 'edit'])->name('edit');
        Route::put('/edit/{contact}', [\App\Http\Controllers\ContactController::class, 'update'])->name('update');
        Route::delete('/{contact}', [\App\Http\Controllers\ContactController::class, 'destroy'])->name('destroy');
    });

    // Rolls
    Route::group(['prefix' => 'rolls', 'as' => 'rolls.'], function () {
        Route::get('/', [\App\Http\Controllers\RollController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\RollController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\RollController::class, 'store'])->name('store');
        Route::delete('/{roll}', [\App\Http\Controllers\RollController::class, 'destroy'])->name('destroy');

        Route::get('/used', [\App\Http\Controllers\RollController::class, 'used'])->name('used');
        Route::post('/used', [\App\Http\Controllers\RollController::class, 'storeUsed'])->name('store-used');
        Route::delete('/used/{roll}', [\App\Http\Controllers\RollController::class, 'destroyUsed'])->name('destroy-used');
    });


    // Users
    Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
        Route::get('/', [\App\Http\Controllers\UserController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\UserController::class, 'create'])->name('create');
        Route::post('/', [\App\Http\Controllers\UserController::class, 'store'])->name('store');
        Route::get('/show/{user}', [\App\Http\Controllers\UserController::class, 'show'])->name('show');
        Route::get('my-profile', [\App\Http\Controllers\UserController::class, 'myProfile'])->name('my-profile');
        Route::get('/edit/{user}', [\App\Http\Controllers\UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [\App\Http\Controllers\UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [\App\Http\Controllers\UserController::class, 'destroy'])->name('destroy');
        Route::post('auth/{user}', [AuthController::class, 'adminAuth'])->name('auth.admin');
    });


    // Products
    Route::group(['prefix' => 'products', 'as' => 'products.'], function () {
        Route::get('/', [\App\Http\Controllers\ProductController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ProductController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\ProductController::class, 'store'])->name('store');
        Route::get('/show/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('show');
        Route::get('/edit/{product}', [\App\Http\Controllers\ProductController::class, 'edit'])->name('edit');
        Route::put('/edit/{product}', [\App\Http\Controllers\ProductController::class, 'update'])->name('update');
        Route::delete('/{product}', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('destroy');

        Route::get('/product/used', [\App\Http\Controllers\ProductController::class, 'used'])->name('used');
    });

    // Cardons
    Route::group(['prefix' => 'cardons', 'as' => 'cardons.'], function () {
        Route::get('/', [\App\Http\Controllers\CardonController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\CardonController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\CardonController::class, 'store'])->name('store');
        Route::get('/show/{cardon}', [\App\Http\Controllers\CardonController::class, 'show'])->name('show');
        Route::get('/edit/{cardon}', [\App\Http\Controllers\CardonController::class, 'edit'])->name('edit');
        Route::put('/edit/{cardon}', [\App\Http\Controllers\CardonController::class, 'update'])->name('update');
        Route::delete('/{cardon}', [\App\Http\Controllers\CardonController::class, 'destroy'])->name('destroy');
    });

    // ProductUsed
    Route::group(['prefix' => 'product-used', 'as' => 'product-used.'], function () {
        Route::get('/', [\App\Http\Controllers\ProductUsedController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ProductUsedController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\ProductUsedController::class, 'store'])->name('store');
        Route::delete('/{product_used}', [\App\Http\Controllers\ProductUsedController::class, 'destroy'])->name('destroy');
    });

    // Purchases
    Route::group(['prefix' => 'purchases', 'as' => 'purchases.'], function () {
        Route::get('/', [\App\Http\Controllers\PurchaseController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\PurchaseController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\PurchaseController::class, 'store'])->name('store');
        Route::get('/edit/{purchase}', [\App\Http\Controllers\PurchaseController::class, 'edit'])->name('edit');
        Route::put('/edit/{purchase}', [\App\Http\Controllers\PurchaseController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [\App\Http\Controllers\PurchaseController::class, 'destroy'])->name('destroy');

    });

    // Manufactures
    Route::group(['prefix' => 'manufactures', 'as' => 'manufactures.'], function () {
        Route::get('/', [\App\Http\Controllers\ManufactureController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ManufactureController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\ManufactureController::class, 'store'])->name('store');
        Route::get('/edit/{manufacture}', [\App\Http\Controllers\ManufactureController::class, 'edit'])->name('edit');
        Route::put('/edit/{manufacture}', [\App\Http\Controllers\ManufactureController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [\App\Http\Controllers\ManufactureController::class, 'destroy'])->name('destroy');
    });

    // Sales
    Route::group(['prefix' => 'sales', 'as' => 'sales.'], function () {
        Route::get('/', [\App\Http\Controllers\SaleController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\SaleController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\SaleController::class, 'store'])->name('store');
        Route::delete('/destroy/{id}', [\App\Http\Controllers\SaleController::class, 'destroy'])->name('destroy');

    });

    // ExpenseCategories
    Route::group(['prefix' => 'expense-categories', 'as' => 'expense-categories.'], function () {
        Route::get('/', [\App\Http\Controllers\ExpenseCategoryController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ExpenseCategoryController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\ExpenseCategoryController::class, 'store'])->name('store');
        Route::get('/edit/{expense_category}', [\App\Http\Controllers\ExpenseCategoryController::class, 'edit'])->name('edit');
        Route::put('/edit/{expense_category}', [\App\Http\Controllers\ExpenseCategoryController::class, 'update'])->name('update');
        Route::delete('/{expense_category}', [\App\Http\Controllers\ExpenseCategoryController::class, 'destroy'])->name('destroy');
    });

    // Expenses
    Route::group(['prefix' => 'expenses', 'as' => 'expenses.'], function () {
        Route::get('/', [\App\Http\Controllers\ExpenseController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\ExpenseController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\ExpenseController::class, 'store'])->name('store');
        Route::get('/edit/{expense}', [\App\Http\Controllers\ExpenseController::class, 'edit'])->name('edit');
        Route::put('/edit/{expense}', [\App\Http\Controllers\ExpenseController::class, 'update'])->name('update');
        Route::delete('/{expense}', [\App\Http\Controllers\ExpenseController::class, 'destroy'])->name('destroy');
    });

    // Payments
    Route::group(['prefix' => 'payments', 'as' => 'payments.'], function () {
        Route::get('/', [\App\Http\Controllers\PaymentController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\PaymentController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\PaymentController::class, 'store'])->name('store');
        Route::get('/edit/{payment}', [\App\Http\Controllers\PaymentController::class, 'edit'])->name('edit');
        Route::put('/edit/{payment}', [\App\Http\Controllers\PaymentController::class, 'update'])->name('update');
        Route::delete('/{payment}', [\App\Http\Controllers\PaymentController::class, 'destroy'])->name('destroy');
    });

    // invensts
    Route::resource('invensts', \App\Http\Controllers\InvenstController::class);

    // Reports
    Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
        Route::get('/kassa', [\App\Http\Controllers\ReportController::class, 'kassa'])->name('kassa');
        Route::get('/opiu', [\App\Http\Controllers\ReportController::class, 'opiu'])->name('opiu');
        Route::get('/odds', [\App\Http\Controllers\ReportController::class, 'odds'])->name('odds');
        Route::get('/daxod', [\App\Http\Controllers\ReportController::class, 'daxod'])->name('daxod');
        Route::get('/expense', [\App\Http\Controllers\ReportController::class, 'expense'])->name('expense');
        Route::get('/balans', [\App\Http\Controllers\ReportController::class, 'balans'])->name('balans');
    });

    // Requests
    Route::resource('requests', \App\Http\Controllers\RequestController::class);

});

