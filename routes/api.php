<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Product show
Route::get('/cardon/{id}', 'App\Http\Controllers\Api\CardonController@show')->name('api.products.show');
Route::get('/products/{id}', 'App\Http\Controllers\Api\ProductController@show')->name('api.products.show');
Route::get('/request/{contact_id}', [App\Http\Controllers\Api\RequestController::class, 'contact'])->name('api.request.contact');
