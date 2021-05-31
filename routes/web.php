<?php

use App\Http\Controllers\BankProductsController;
use App\Http\Controllers\ClientBankProductsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/produkty-bankowe/', [BankProductsController::class, 'index'])
        ->name('bank-products.index');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
