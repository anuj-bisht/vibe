<?php
use Illuminate\Support\Facades\Auth;
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

Route::middleware(['auth'])->prefix('corporate')->group(function() {
    Route::get('/index', [Modules\Corporate\Http\Controllers\Corporate\ProfileController::class, 'index'])->name('corporate.index');
    Route::get('/corpotate/listing', [Modules\Corporate\Http\Controllers\Corporate\ProfileController::class, 'clientListing'])->name('corporate.listing');

    // Route::get('/index', [Modules\Order\Http\Controllers\Order\OrderController::class, 'index'])->name('order.index');
    // Route::get('/order/listing', [Modules\Order\Http\Controllers\Order\OrderController::class, 'orderListing'])->name('order.listing');

    Route::get('/create', [Modules\Corporate\Http\Controllers\Corporate\ProfileController::class, 'create'])->name('corporate.create')->middleware('permission:customer.add');
    Route::post('/store', [Modules\Corporate\Http\Controllers\Corporate\ProfileController::class, 'store'])->name('corporate.store');
    Route::get('/edit/{id}', [Modules\Corporate\Http\Controllers\Corporate\ProfileController::class, 'edit'])->name('corporate.edit')->middleware('permission:customer.edit');
    Route::post('/update/{id}', [Modules\Corporate\Http\Controllers\Corporate\ProfileController::class, 'update'])->name('corporate.update');


    Route::get('all/grn', [Modules\Corporate\Http\Controllers\Grn\GrnController::class, 'index'])->name('corporate.all.grn');
    Route::get('retailer/datatableallgrn', [Modules\Corporate\Http\Controllers\Grn\GrnController::class, 'allGrnListing'])->name('corporate.datatable.all.grn');

    Route::get('view/grn', [Modules\Corporate\Http\Controllers\Grn\GrnController::class, 'view'])->name('admin.retail.grn.view')->middleware('permission:grn.view');
    Route::get('/validate/grn', [Modules\Corporate\Http\Controllers\Grn\GrnController::class, 'validate'])->name('admin.retail.grn.validate')->middleware('permission:grn.validate');
    Route::get('/validated/grn', [Modules\Corporate\Http\Controllers\Grn\GrnController::class, 'grnValidated'])->name('admin.retail.already.validate');

    Route::post('/move/grn', [Modules\Corporate\Http\Controllers\Grn\GrnController::class, 'moveToGrnSection'])->name('moveToGrnSection');


    

 


});
