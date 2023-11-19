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
// Route::group(['middleware' => ['permission:publish articles|edit articles']]
Route::middleware(['auth'])->prefix('product')->group(function() {
// Route::middleware(['auth'])->prefix('product')->group(function() {
    Route::get('/index', [Modules\Product\Http\Controllers\ProductController::class, 'index'])->name('product.index');
    Route::get('/listing', [Modules\Product\Http\Controllers\ProductController::class, 'ProductListing'])->name('product.listing');
    Route::get('/create', [Modules\Product\Http\Controllers\ProductController::class, 'create'])->name('product.create');
    Route::post('/store', [Modules\Product\Http\Controllers\ProductController::class, 'store'])->name('product.store');
    Route::get('/edit/{id}', [Modules\Product\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
    Route::post('/update/{id}', [Modules\Product\Http\Controllers\ProductController::class, 'update'])->name('product.update');
    Route::get('/delete/{id}', [Modules\Product\Http\Controllers\ProductController::class, 'delete']);
    Route::get('/print/barcode/{id}', [Modules\Product\Http\Controllers\ProductController::class, 'printBarcode'])->name('print.barcode');
    Route::get('/get/barcode/{id}', [Modules\Product\Http\Controllers\ProductController::class, 'getBarcode'])->name('get.barcode');
    Route::get('/generate/pdf/', [Modules\Product\Http\Controllers\ProductController::class, 'generatePdf'])->name('generate.pdf');
    Route::get('/create/barcode/', [Modules\Product\Http\Controllers\ProductController::class, 'createBarcode'])->name('product.create.barcode');
    Route::get('productGetSubCategory', [Modules\Product\Http\Controllers\ProductController::class, 'productGetSubCategory'])->name('product.getSubCategory');
    Route::get('productGetSubSubCategory', [Modules\Product\Http\Controllers\ProductController::class, 'productGetSubSubCategory'])->name('product.getSubSubCategory');


});


