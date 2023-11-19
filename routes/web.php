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

Route::get('/',[App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');









Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('flushRetailSession');
Route::get('/getcategory/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getCategory']);
Route::get('/getsubcategory/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getSubCategory']);
Route::get('/getsubsubcategory/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getSubSubCategory']);
Route::get('/getColorId/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getColorId']);


Route::get('/getSubCategory/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getSubCategoryForAudit']);
Route::get('/getSubSubCategory/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getSubSubCategoryForAudit']);
Route::get('/getSubSubSubCategory/{warehouse_id}/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getSubSubSubCategoryForAudit']);
Route::get('/getAllProduct/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getSubSubSubCategoryForAudit']);
  




//get Cuting Ratios

Route::get('/getCuttingRatios/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getCuttingRatio']);
Route::get('/getwarehouseqty/{wid}/{cpid}/{pid}', [Modules\Product\Http\Controllers\CommonController::class, 'getWarehouseQty']);

//get billing State city
Route::get('/getbillingstate/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getBillingState']);
Route::get('/getbillingcity/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getBillingCity']);
Route::get('/getdeliverystate/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getDeliveryState']);
Route::get('/getdeliverycity/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getDeliveryCity']);
Route::get('/getClientOrder/{order_id}', [Modules\Product\Http\Controllers\CommonController::class, 'getClientOrder']);
Route::get('/checkSeasonOrder/{season}', [Modules\Product\Http\Controllers\CommonController::class, 'checkSeasonCode']);
Route::get('/getPicklist/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getPicklist']);

Route::get('/getTotalPicklist/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getTotalPicklist']);
Route::get('/getPicklistProduct/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getPicklistProduct']);
Route::get('/getPicklistColor/{picklist_id}/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getPicklistColor']);

Route::get('/getPicklistListData/{id}/{warehouse_id}/{picklist_id}', [Modules\Product\Http\Controllers\CommonController::class, 'getPicklistData']);
Route::post('checkqty',[Modules\Product\Http\Controllers\CommonController::class, 'checkQty']);
Route::post('checkwarehouseqty',[Modules\Product\Http\Controllers\CommonController::class, 'checkWarehouseQty']);
Route::post('checkconsumerinvoiceqty',[Modules\Product\Http\Controllers\CommonController::class, 'checkConsumerInvoiceQty']);
Route::post('checkretailwarehouseqty',[Modules\Product\Http\Controllers\CommonController::class, 'checkRetailWarehouseQty']);
Route::post('checkUnfinishedWarehouseQty',[Modules\Product\Http\Controllers\CommonController::class, 'checkUnfinishedWarehouseQty']);





Route::post('updatePicklistData',[Modules\Product\Http\Controllers\CommonController::class, 'updatePicklistData']);


// Route::get('/getPublishedData/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getPublishedData']);
Route::get('/getProductCode/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getProductCode']);
Route::get('/getClient/{id}', [Modules\Product\Http\Controllers\CommonController::class, 'getClient']);
Route::get('/getWarehouseProductColor/{warehouse_id}/{product_id}', [Modules\Product\Http\Controllers\CommonController::class, 'getWarehouseProductColor']);
Route::get('/getWarehouseProductColorQty/{warehouse_id}/{product_id}/{color_id}', [Modules\Product\Http\Controllers\CommonController::class, 'getWarehouseProductColorQty']);
Route::get('/enableAudit/{warehouse_id}/{product_id}/{color_id}/{audit}', [Modules\Product\Http\Controllers\CommonController::class, 'enableAudit']);
Route::post('/getDataBySearch', [Modules\Product\Http\Controllers\CommonController::class, 'getDataBySearch']);
Route::post('/getDataBySearchh', [Modules\Product\Http\Controllers\CommonController::class, 'getDataBySearchh']);
Route::post('/getDataBySearchhh', [Modules\Product\Http\Controllers\CommonController::class, 'getDataBySearchhh']);
Route::post('/getQtyByRetailSearch', [Modules\Product\Http\Controllers\CommonController::class, 'getQtyByRetailSearch']);
Route::post('/getQtyByConsumerInvoiceSearch', [Modules\Product\Http\Controllers\CommonController::class, 'getQtyByConsumerInvoiceSearch']);
Route::post('/getQtyByRetailGrnSearch', [Modules\Product\Http\Controllers\CommonController::class, 'getQtyByRetailGrnSearch']);


Route::post('/getDataByStockSearch', [Modules\Product\Http\Controllers\CommonController::class, 'getDataByStockSearch']);
Route::post('/getDataByRetailStockSearch', [Modules\Product\Http\Controllers\CommonController::class, 'getDataByRetailStockSearch']);




Route::get('getWarehouseProduct/{warehouse_id}', [Modules\Product\Http\Controllers\CommonController::class, 'getWarehouseProduct']);


Route::get('getSearchProduct/{search_product}', [Modules\Product\Http\Controllers\CommonController::class, 'searchProduct']);
Route::get('getSearchColorBySeasonProduct/{product_id}/{color_id}', [Modules\Product\Http\Controllers\CommonController::class, 'getSearchColortBySeasonProduct']);

Route::get('getSearchProductBySeason/{search_product}/{season_id}', [Modules\Product\Http\Controllers\CommonController::class, 'searchProductBySeason']);

Route::get('getUnfinishedProductSearch/{search_product}', [Modules\Product\Http\Controllers\CommonController::class, 'searchUnfinishedProduct']);
Route::get('getProductSearch/{search_product}', [Modules\Product\Http\Controllers\CommonController::class, 'searchProduct']);
Route::get('getProductColorPrice/{p_id}/{c_id}', [Modules\Product\Http\Controllers\CommonController::class, 'getProductColorPrice']);


Route::post('checkquantity', [Modules\Product\Http\Controllers\CommonController::class, 'checkQuantity']);
Route::post('auditcheckquantity', [Modules\Product\Http\Controllers\CommonController::class, 'auditCheckQuantity']);

Route::post('getAuditProductSearch', [Modules\Product\Http\Controllers\CommonController::class, 'searchAuditProduct']);
Route::post('getRetailAuditProductSearch', [Modules\Product\Http\Controllers\CommonController::class, 'searchRetailAuditProduct']);

Route::post('getProductByGoods', [Modules\Product\Http\Controllers\CommonController::class, 'getProductByGoods']);
Route::post('getColorByGoods', [Modules\Product\Http\Controllers\CommonController::class, 'getColorByGoods']);
Route::post('getColorByAudit', [Modules\Product\Http\Controllers\CommonController::class, 'getColorByAudit']);
Route::post('getColorByRetailAudit', [Modules\Product\Http\Controllers\CommonController::class, 'getColorByRetailAudit']);

Route::post('getRetailProduct', [Modules\Product\Http\Controllers\CommonController::class, 'getRetailProduct']);
Route::post('getRetailProductColor', [Modules\Product\Http\Controllers\CommonController::class, 'getColorByRetailConsumer']);
Route::post('getUnfinishedProductColor', [Modules\Product\Http\Controllers\CommonController::class, 'getColorByUnfinishedProduct']);

Route::post('getRetailProductColorMrp', [Modules\Product\Http\Controllers\CommonController::class, 'getRetailProductColorMrp']);
Route::post('saveTempRetailAudit', [Modules\Product\Http\Controllers\CommonController::class, 'saveTempRetailAudit']);

Route::post('getConsumerInvoiceProduct', [Modules\Product\Http\Controllers\CommonController::class, 'getConsumerInvoiceProduct']);
Route::post('getConsumerInvoiceProductColor', [Modules\Product\Http\Controllers\CommonController::class, 'getConsumerInvoiceProductColor']);

// Route::post('getRetailGrnProduct', [Modules\Product\Http\Controllers\CommonController::class, 'getRetailGrnProduct']);
// Route::post('getConsumerInvoiceProductColor', [Modules\Product\Http\Controllers\CommonController::class, 'getConsumerInvoiceProductColor']);











































