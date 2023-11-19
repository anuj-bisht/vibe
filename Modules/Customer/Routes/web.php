<?php
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

Route::middleware(['auth'])->prefix('customer')->group(function() {

    Route::get('/index', [Modules\Customer\Http\Controllers\Customer\CustomerController::class, 'index'])->name('customer.index');
    Route::get('/retail/dcustomer', [Modules\Customer\Http\Controllers\Customer\CustomerController::class, 'customerListing'])->name('customer.listing');
    Route::get('/create', [Modules\Customer\Http\Controllers\Customer\CustomerController::class, 'create'])->name('customer.create')->middleware('permission:customer.add');
    Route::get('/edit/{id}', [Modules\Customer\Http\Controllers\Customer\CustomerController::class, 'edit'])->name('customer.edit')->middleware('permission:customer.edit');
    Route::get('/retail/create', [Modules\Customer\Http\Controllers\Customer\CustomerController::class, 'retailCreate'])->name('retailcustomer.create');
    Route::post('/store', [Modules\Customer\Http\Controllers\Customer\CustomerController::class, 'store'])->name('customer.store');
    Route::post('update/{id}', [Modules\Customer\Http\Controllers\Customer\CustomerController::class, 'update'])->name('customer.update');


   




});


