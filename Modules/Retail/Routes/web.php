<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Modules\Corporate\Entities\CorporateProfile;

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

Route::middleware(['auth'])->prefix('retail')->group(function() {
    Route::get('/home', function(Request $request){ 
        $retail_session = $request->session()->get('retail');
    
        if(!isset($retail_session->id)){
            $request->session()->put('retail', CorporateProfile::where('is_retail', 1)->first());
        }
        return view('retail::dashboard');
    })->name('isRetailSession');

    Route::get('change/session', [Modules\Retail\Http\Controllers\Retail\RetailController::class, 'changeRetailStatus'])->name('changeRetailSession');
    //without validated purchase listing

    Route::get('purchase/listing',[Modules\Retail\Http\Controllers\Retail\RetailController::class,'index'])->name('purchase.listing');
    Route::get('pdatatable/listing', [Modules\Retail\Http\Controllers\Retail\RetailController::class, 'purchaseListing'])->name('listing.datatable');
    Route::get('purchase/view/{id}', [Modules\Retail\Http\Controllers\Retail\RetailController::class, 'view'])->name('purchase.invoice.view');
    Route::post('purchase/store', [Modules\Retail\Http\Controllers\Retail\RetailController::class, 'store'])->name('moveToPurchase');



    //validated Purchase listing
    Route::get('validate/listing', [Modules\Retail\Http\Controllers\Retail\ValidatorController::class, 'index'])->name('purchase.validated.listing');
    Route::get('dvalidate/listing', [Modules\Retail\Http\Controllers\Retail\ValidatorController::class, 'validateListing'])->name('validatelisting.datatable');
    Route::get('validate/reatil/view/{id}', [Modules\Retail\Http\Controllers\Retail\ValidatorController::class, 'view'])->name('validate.list.view');
    Route::post('data/export', [Modules\Retail\Http\Controllers\Retail\ValidatorController::class, 'export'])->name('moveToClientExport');



   //Retailer Product
   Route::get('stock/allproducts', [Modules\Retail\Http\Controllers\Retail\ProductController::class, 'index'])->name('retail.products');
   Route::get('retail/datatableallproducts', [Modules\Retail\Http\Controllers\Retail\ProductController::class, 'productListing'])->name('retailProductListing');


   //Customer Invoice
   Route::get('create/customer/invoice', [Modules\Retail\Http\Controllers\Customer\CustomerInvoiceController::class, 'create'])->name('customer.create.invoice');
   Route::get('customer/search', [Modules\Retail\Http\Controllers\Customer\CustomerInvoiceController::class, 'search'])->name('retail.customer.search');
   Route::post('save/customer/invoice', [Modules\Retail\Http\Controllers\Customer\CustomerInvoiceController::class, 'moveToInvoice'])->name('moveToCustomerInvoice');
   Route::post('customercouponlimit', [Modules\Retail\Http\Controllers\Customer\CustomerInvoiceController::class, 'checkCouponLimit'])->name('checkCouponLimit');
   Route::post('customercoupontype', [Modules\Retail\Http\Controllers\Customer\CustomerInvoiceController::class, 'checkCouponType'])->name('checkCouponType');
   Route::get('customer/goodreturn', [Modules\Retail\Http\Controllers\Customer\CustomerInvoiceController::class, 'GoodReturn'])->name('retail.goodreturns');

   //Retail Grn Management

      Route::get('pending/grn', [Modules\Retail\Http\Controllers\Retail\GrnController::class, 'index'])->name('retail.pending.grn');
      Route::get('pending/datatablegrn', [Modules\Retail\Http\Controllers\Retail\GrnController::class, 'grnPendingListing'])->name('retail.grnPendingListing');
      Route::get('grn/detail', [Modules\Retail\Http\Controllers\Retail\GrnController::class, 'view'])->name('retailer.grn.view');


      Route::get('validated/grn', [Modules\Retail\Http\Controllers\Retail\GrnController::class, 'validatedIndex'])->name('retail.validated.grn');
      Route::get('validated/datatablegrn', [Modules\Retail\Http\Controllers\Retail\GrnController::class, 'validatedGrnPendingListing'])->name('retail.grnValidatedListing');
      Route::get('validated/grn/detail', [Modules\Retail\Http\Controllers\Retail\GrnController::class, 'Validatedview'])->name('retailer.validatedgrn.view');


      Route::get('create/grn', [Modules\Retail\Http\Controllers\Retail\GrnController::class, 'create'])->name('retail.create.grn');
      Route::post('move/grn', [Modules\Retail\Http\Controllers\Retail\GrnController::class, 'moveToGrn'])->name('moveToGrn');











   Route::get('invoice/list', [Modules\Retail\Http\Controllers\Customer\CustomerInvoiceController::class, 'index'])->name('retailcustomer.invoiceList');
   Route::get('invoice/listing', [Modules\Retail\Http\Controllers\Customer\CustomerInvoiceController::class, 'invoiceListing'])->name('retailcustomer.invoiceListing');
   Route::get('customer/invoice/view/{id}', [Modules\Retail\Http\Controllers\Customer\CustomerInvoiceController::class, 'view'])->name('customer.invoice.view');

   Route::post('customer/return/store', [Modules\Retail\Http\Controllers\Customer\CustomerInvoiceController::class, 'customerReturnStore'])->name('moveToCustomerInvoiceGoodReturn');
   Route::get('retail/good/return/data', [Modules\Retail\Http\Controllers\Customer\CustomerInvoiceController::class, 'goodReturnData'])->name('retail.goodreturndata');
 

   //Stock Audit
   Route::get('stock/audit', [Modules\Retail\Http\Controllers\Retail\AuditController::class, 'index'])->name('retail.stockAudit');
   Route::get('stock/audit/form', [Modules\Retail\Http\Controllers\Retail\AuditController::class, 'create'])->name('retail.stock.audit.form');
   Route::post('save/stock', [Modules\Retail\Http\Controllers\Retail\AuditController::class, 'moveToRetailStock'])->name('moveToRetailStock');
   Route::get('stock/{id}', [Modules\Retail\Http\Controllers\Retail\AuditController::class, 'view'])->name('stock.retailaudit.view');


     //Petty Cash Module
  Route::get('pettycash', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'index'])->name('retailpetty.index');
  Route::get('pettycash/datatable', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'cashListing'])->name('retailpettycash.listing');
  Route::get('incoming/pettycase', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'incomingPettycash'])->name('incoming.pettycash');
  Route::get('incoming/datatable', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'incomingPettyDatatable'])->name('retailpettycash.listingg');
  Route::get('pettycash/edit', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'edit'])->name('retailpetty.cash.edit');
  Route::post('validate/incomingcash', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'validateIncomingCash'])->name('validate.incoming.cash');

 
  
  Route::post('pettycash/update', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'update'])->name('retailpetty.cash.update');
  Route::get('pettycash/transaction/history', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'transactionHistory'])->name('retail.transaction.history');
  Route::get('pettycash/transaction/dhistory', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'transactionListing'])->name('retail.datatransaction.history');

 //Petty Cash Module
 Route::get('cashTransfer', [Modules\Retail\Http\Controllers\Customer\CashTransferController::class, 'index'])->name('retail.cashtransfer');
 Route::post('deposit/transfer', [Modules\Retail\Http\Controllers\Customer\CashTransferController::class, 'cashTransfer'])->name('transferCash');
 Route::get('cashDeposit', [Modules\Retail\Http\Controllers\Customer\CashTransferController::class, 'depositHistory'])->name('retail.cash.deposit');
  Route::get('deposit/datatable', [Modules\Retail\Http\Controllers\Customer\CashTransferController::class, 'depositHistoryListing'])->name('retaildeposit.listing');

//  Route::get('pettycash/datatable', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'cashListing'])->name('retailpettycash.listing');
//  Route::get('pettycash/edit', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'edit'])->name('retailpetty.cash.edit');
//  Route::post('pettycash/update', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'update'])->name('retailpetty.cash.update');
//  Route::get('pettycash/transaction/history', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'transactionHistory'])->name('retail.transaction.history');
//  Route::get('pettycash/transaction/dhistory', [Modules\Retail\Http\Controllers\Petty\PettyCashController::class, 'transactionListing'])->name('retail.datatransaction.history');






});
