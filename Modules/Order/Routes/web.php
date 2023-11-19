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

Route::middleware(['auth'])->prefix('order')->group(function() {
    Route::get('/index', [Modules\Order\Http\Controllers\Order\OrderController::class, 'index'])->name('order.index');
    Route::get('/order/listing', [Modules\Order\Http\Controllers\Order\OrderController::class, 'orderListing'])->name('order.listing');
    Route::get('/create', [Modules\Order\Http\Controllers\Order\OrderController::class, 'create'])->name('order.create')->middleware('permission:order.create');
    Route::post('/save/order', [Modules\Order\Http\Controllers\Order\OrderController::class, 'store'])->name('moveToOrder');
    Route::get('/view/{id}', [Modules\Order\Http\Controllers\Order\OrderController::class, 'view'])->name('order.view')->middleware('permission:order.view');
    Route::post('update/order/attribute/{id}', [Modules\Order\Http\Controllers\Order\OrderController::class, 'updateOrderAttribute'])->name('update.orderAttribute');



    Route::get('/picklist/generator', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'picklistGenerator'])->name('picklist.generator')->middleware('permission:picklist.generate');
    // Route::get('/picklist/generate/directly/{id}', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'generatePicklistDirectly'])->name('generatePicklistDirectly');
    Route::get('/picklist/getClient', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'getClient'])->name('getClient');
    Route::get('/picklist/getOrder', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'getOrder'])->name('getOrder');
    Route::get('/picklist/getClientOrderData', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'getOrderData'])->name('getClientOrderData');
    Route::get('/picklist/getPicklistData', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'getPicklistData'])->name('getPicklistData');

    Route::get('/product/in/warehouse', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'productInWarehouse'])->name('product.warehouse');
    Route::post('move/to/picklist', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'moveToPicklist'])->name('moveToPicklist');

    // Picklist validator
    Route::get('picklist/validator', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'picklistValidator'])->name('picklist.validator');
    // Route::post('save/picklist/validator', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'storePicklistValidator'])->name('moveToFinalPicklist');
    Route::get('publish/picklist', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'publishPicklist'])->name('publish.picklist');
    Route::get('picklist/listing', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'index'])->name('pick.index');
    Route::get('picklist/datatablelisting', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'picklistListing'])->name('picklist.listing');
    Route::get('picklist/view/{id}', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'picklistView'])->name('picklist.view')->middleware('permission:picklist.view');
    Route::post('picklist/update', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'picklistUpdate'])->name('update.picklistAttribute');
    Route::get('picklist/pdf/{id}', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'picklistPDF'])->name('picklist.pdf')->middleware('permission:picklist.generate.pdf');
    Route::get('save/picklist/validator/{id}', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'storePicklistValidator'])->name('store.picklist.validator')->middleware('permission:picklist.validate');
    // Route::get('publish/picklist/view/{id}', [Modules\Order\Http\Controllers\Picklist\PicklistController::class, 'publishPicklistView'])->name('publish.picklist.view');



    // Picklist Invoice
   
    Route::get('invoice/index', [Modules\Order\Http\Controllers\Picklist\InvoiceController::class, 'index'])->name('picklist.invoice.index');
    Route::get('invoice/listing', [Modules\Order\Http\Controllers\Picklist\InvoiceController::class, 'invoiceListing'])->name('picklist.invoice.listing');
    Route::get('picklist/invoice', [Modules\Order\Http\Controllers\Picklist\InvoiceController::class, 'picklistInvoice'])->name('picklist.invoice')->middleware('permission:picklist.generate.invoice');
    Route::post('save/picklist/invoice', [Modules\Order\Http\Controllers\Picklist\InvoiceController::class, 'moveToInvoice'])->name('moveToInvoice');
    Route::get('picklist/invoice/view/{id}', [Modules\Order\Http\Controllers\Picklist\InvoiceController::class, 'view'])->name('picklist.invoice.view')->middleware('permission:invoice.view');
    Route::get('picklist/invoice/difference', [Modules\Order\Http\Controllers\Picklist\InvoiceController::class, 'differenceIndex'])->name('picklist.invoice.difference');
    Route::get('picklist/dtinvoice/difference', [Modules\Order\Http\Controllers\Picklist\InvoiceController::class, 'invoiceDifferenceListing'])->name('picklist.dtinvoice.difference');
    Route::get('view/invoice/difference/{id}', [Modules\Order\Http\Controllers\Picklist\InvoiceController::class, 'viewInvoiceDifference'])->name('picklist.differenceinvoice.view')->middleware('permission:invoice.difference.view');

    

    


    // goods returns
    Route::get('goods/returns/index', [Modules\Order\Http\Controllers\Picklist\GoodsController::class, 'index'])->name('goods.returns.index');
    Route::get('good/listing', [Modules\Order\Http\Controllers\Picklist\GoodsController::class, 'goodReturnListing'])->name('goodreturn.listing');

    Route::get('goods/returns', [Modules\Order\Http\Controllers\Picklist\GoodsController::class, 'goodReturns'])->name('goods.returns');
    Route::post('save/goods/returns', [Modules\Order\Http\Controllers\Picklist\GoodsController::class, 'moveToGoods'])->name('moveToGoods');
    Route::get('return/good/view', [Modules\Order\Http\Controllers\Picklist\GoodsController::class, 'view'])->name('goods.returns.view');
    Route::get('goods/undefective', [Modules\Order\Http\Controllers\Picklist\GoodsController::class, 'Undefective'])->name('goods.undefective');
    Route::get('goods/defective', [Modules\Order\Http\Controllers\Picklist\GoodsController::class, 'Defective'])->name('goods.defective');




    // Picklist Invoice
    Route::get('stock/index', [Modules\Order\Http\Controllers\Picklist\StockAuditController::class, 'index'])->name('stock.audit.index');
    Route::get('stock/audit', [Modules\Order\Http\Controllers\Picklist\StockAuditController::class, 'stockAudit'])->name('stock.audit');


    Route::post('save/tempAuditDetail', [Modules\Order\Http\Controllers\Picklist\StockAuditController::class, 'moveToTempAuditDetail'])->name('moveToTempAuditDetail');
    Route::post('store/tempAudit', [Modules\Order\Http\Controllers\Picklist\StockAuditController::class, 'storeTempAudit'])->name('storeTempAudit');
    Route::post('save/stock', [Modules\Order\Http\Controllers\Picklist\StockAuditController::class, 'moveToStock'])->name('moveToStock');
    Route::get('stock/view/{id}', [Modules\Order\Http\Controllers\Picklist\StockAuditController::class, 'view'])->name('stock.audit.view');
    Route::get('/audit/status', [Modules\Order\Http\Controllers\Picklist\StockAuditController::class, 'auditStatus'])->name('stock.audit.status');
    Route::get('/reset/cateData', [Modules\Order\Http\Controllers\Picklist\StockAuditController::class, 'resetData'])->name('resetCate');


   










});
