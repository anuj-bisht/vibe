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

Route::middleware(['auth'])->prefix('master')->group(function() {

    //Gender Module
    Route::get('gender', [Modules\Master\Http\Controllers\GenderController::class, 'index'])->name('master.gender');
    Route::get('gender/create', [Modules\Master\Http\Controllers\GenderController::class, 'create'])->name('master.gender.create');
    Route::post('gender/submit', [Modules\Master\Http\Controllers\GenderController::class, 'store'])->name('master.gender.store');
    Route::get('gender/edit/{id}', [Modules\Master\Http\Controllers\GenderController::class, 'edit'])->name('master.gender.edit');
    Route::post('gender/update/{id}', [Modules\Master\Http\Controllers\GenderController::class, 'update'])->name('master.gender.update');


    //Fabric Module
    Route::get('fabric', [Modules\Master\Http\Controllers\Fabric\FabricController::class, 'index'])->name('master.fabric');
    Route::get('fabric/create', [Modules\Master\Http\Controllers\Fabric\FabricController::class, 'create'])->name('master.fabric.create');
    Route::post('fabric/submit', [Modules\Master\Http\Controllers\Fabric\FabricController::class, 'store'])->name('master.fabric.store');
    Route::get('fabric/edit/{id}', [Modules\Master\Http\Controllers\Fabric\FabricController::class, 'edit'])->name('master.fabric.edit');
    Route::post('fabric/update/{id}', [Modules\Master\Http\Controllers\Fabric\FabricController::class, 'update'])->name('master.fabric.update');


   //tax Module
   Route::get('tax', [Modules\Master\Http\Controllers\Tax\TaxController::class, 'index'])->name('master.tax');
   Route::get('tax/create', [Modules\Master\Http\Controllers\Tax\TaxController::class, 'create'])->name('master.tax.create')->middleware('permission:master.add');
   Route::post('tax/submit', [Modules\Master\Http\Controllers\Tax\TaxController::class, 'store'])->name('master.tax.store');
   Route::get('tax/edit/{id}', [Modules\Master\Http\Controllers\Tax\TaxController::class, 'edit'])->name('master.tax.edit')->middleware('permission:master.edit');
   Route::post('tax/update/{id}', [Modules\Master\Http\Controllers\Tax\TaxController::class, 'update'])->name('master.tax.update');


    //Color Module
    Route::get('color', [Modules\Master\Http\Controllers\Color\ColorController::class, 'index'])->name('master.color');
    Route::get('color/create', [Modules\Master\Http\Controllers\Color\ColorController::class, 'create'])->name('master.color.create')->middleware('permission:master.add');
    Route::post('color/submit', [Modules\Master\Http\Controllers\Color\ColorController::class, 'store'])->name('master.color.store');
    Route::get('color/edit/{id}', [Modules\Master\Http\Controllers\Color\ColorController::class, 'edit'])->name('master.color.edit')->middleware('permission:master.edit');
    Route::post('color/update/{id}', [Modules\Master\Http\Controllers\Color\ColorController::class, 'update'])->name('master.color.update');


    //EAN Module
    Route::get('ean', [Modules\Master\Http\Controllers\Ean\EanController::class, 'index'])->name('master.ean');
    Route::get('ean/create', [Modules\Master\Http\Controllers\Ean\EanController::class, 'create'])->name('master.ean.create')->middleware('permission:master.add');
    Route::post('ean/submit', [Modules\Master\Http\Controllers\Ean\EanController::class, 'store'])->name('master.ean.store');
    Route::get('ean/edit/{id}', [Modules\Master\Http\Controllers\Ean\EanController::class, 'edit'])->name('master.ean.edit')->middleware('permission:master.edit');
    Route::post('ean/update/{id}', [Modules\Master\Http\Controllers\Ean\EanController::class, 'update'])->name('master.ean.update');

    //HSN Module
    Route::get('hsn', [Modules\Master\Http\Controllers\Hsn\HsnController::class, 'index'])->name('master.hsn');
    Route::get('hsn/create', [Modules\Master\Http\Controllers\Hsn\HsnController::class, 'create'])->name('master.hsn.create')->middleware('permission:master.add');
    Route::post('hsn/submit', [Modules\Master\Http\Controllers\Hsn\HsnController::class, 'store'])->name('master.hsn.store');
    Route::get('hsn/edit/{id}', [Modules\Master\Http\Controllers\Hsn\HsnController::class, 'edit'])->name('master.hsn.edit')->middleware('permission:master.edit');
    Route::post('hsn/update/{id}', [Modules\Master\Http\Controllers\Hsn\HsnController::class, 'update'])->name('master.hsn.update');


    Route::get('composition', [Modules\Master\Http\Controllers\Composition\CompositionController::class, 'index'])->name('master.composition');
    Route::get('composition/create', [Modules\Master\Http\Controllers\Composition\CompositionController::class, 'create'])->name('master.composition.create');
    Route::post('composition/submit', [Modules\Master\Http\Controllers\Composition\CompositionController::class, 'store'])->name('master.composition.store');
    Route::get('composition/edit/{id}', [Modules\Master\Http\Controllers\Composition\CompositionController::class, 'edit'])->name('master.composition.edit');
    Route::post('composition/update/{id}', [Modules\Master\Http\Controllers\Composition\CompositionController::class, 'update'])->name('master.composition.update');

    //Style Module
    Route::get('style', [Modules\Master\Http\Controllers\Style\StyleController::class, 'index'])->name('master.style');
    Route::get('style/create', [Modules\Master\Http\Controllers\Style\StyleController::class, 'create'])->name('master.style.create')->middleware('permission:master.add');
    Route::post('style/submit', [Modules\Master\Http\Controllers\Style\StyleController::class, 'store'])->name('master.style.store');
    Route::get('style/edit/{id}', [Modules\Master\Http\Controllers\Style\StyleController::class, 'edit'])->name('master.style.edit')->middleware('permission:master.edit');
    Route::post('style/update/{id}', [Modules\Master\Http\Controllers\Style\StyleController::class, 'update'])->name('master.style.update');


   //Petty Head Module
   Route::get('pettyhead', [Modules\Master\Http\Controllers\Petty\PettyHeadController::class, 'index'])->name('master.pettyhead');
   Route::get('pettyhead/create', [Modules\Master\Http\Controllers\Petty\PettyHeadController::class, 'create'])->name('master.pettyhead.create')->middleware('permission:master.add');
   Route::post('pettyhead/submit', [Modules\Master\Http\Controllers\Petty\PettyHeadController::class, 'store'])->name('master.pettyhead.store');
   Route::get('pettyhead/edit/{head}', [Modules\Master\Http\Controllers\Petty\PettyHeadController::class, 'edit'])->name('master.pettyhead.edit')->middleware('permission:master.edit');
   Route::post('pettyhead/update/{id}', [Modules\Master\Http\Controllers\Petty\PettyHeadController::class, 'update'])->name('master.pettyhead.update');

    // Size Module
    Route::get('size', [Modules\Master\Http\Controllers\Size\SizeController::class, 'index'])->name('master.size');
    Route::get('size/create', [Modules\Master\Http\Controllers\Size\SizeController::class, 'create'])->name('master.size.create');
    Route::post('size/submit', [Modules\Master\Http\Controllers\Size\SizeController::class, 'store'])->name('master.size.store');
    Route::get('size/edit/{id}', [Modules\Master\Http\Controllers\Size\SizeController::class, 'edit'])->name('master.size.edit');
    Route::post('size/update/{id}', [Modules\Master\Http\Controllers\Size\SizeController::class, 'update'])->name('master.size.update');


    // Margin Module
    Route::get('margin', [Modules\Master\Http\Controllers\Margin\MarginController::class, 'index'])->name('master.margin');
    Route::get('marin/create', [Modules\Master\Http\Controllers\Margin\MarginController::class, 'create'])->name('master.margin.create')->middleware('permission:master.add');
    Route::post('margin/submit', [Modules\Master\Http\Controllers\Margin\MarginController::class, 'store'])->name('master.margin.store');
    Route::get('margin/edit/{id}', [Modules\Master\Http\Controllers\Margin\MarginController::class, 'edit'])->name('master.margin.edit')->middleware('permission:master.edit');
    Route::post('margin/update/{id}', [Modules\Master\Http\Controllers\Margin\MarginController::class, 'update'])->name('master.margin.update');

    // Fit Module
    Route::get('fit', [Modules\Master\Http\Controllers\Fit\FitController::class, 'index'])->name('master.fit');
    Route::get('fit/create', [Modules\Master\Http\Controllers\Fit\FitController::class, 'create'])->name('master.fit.create')->middleware('permission:master.add');
    Route::post('fit/submit', [Modules\Master\Http\Controllers\Fit\FitController::class, 'store'])->name('master.fit.store');
    Route::get('fit/edit/{id}', [Modules\Master\Http\Controllers\Fit\FitController::class, 'edit'])->name('master.fit.edit')->middleware('permission:master.edit');
    Route::post('fit/update/{id}', [Modules\Master\Http\Controllers\Fit\FitController::class, 'update'])->name('master.fit.update');

    // Transport Module
    Route::get('transport', [Modules\Master\Http\Controllers\Transport\TransportController::class, 'index'])->name('master.transport');
    Route::get('transport/create', [Modules\Master\Http\Controllers\Transport\TransportController::class, 'create'])->name('master.transport.create')->middleware('permission:master.add');
    Route::post('transport/submit', [Modules\Master\Http\Controllers\Transport\TransportController::class, 'store'])->name('master.transport.store');
    Route::get('transport/edit/{id}', [Modules\Master\Http\Controllers\Transport\TransportController::class, 'edit'])->name('master.transport.edit')->middleware('permission:master.edit');
    Route::post('transport/update/{id}', [Modules\Master\Http\Controllers\Transport\TransportController::class, 'update'])->name('master.transport.update');

 // Collection Module
    Route::get('collection', [Modules\Master\Http\Controllers\Collection\CollectionController::class, 'index'])->name('master.collection');
    Route::get('collection/create', [Modules\Master\Http\Controllers\Collection\CollectionController::class, 'create'])->name('master.collection.create')->middleware('permission:master.add');
    Route::post('collection/submit', [Modules\Master\Http\Controllers\Collection\CollectionController::class, 'store'])->name('master.collection.store');
    Route::get('collection/edit/{id}', [Modules\Master\Http\Controllers\Collection\CollectionController::class, 'edit'])->name('master.collection.edit')->middleware('permission:master.edit');
    Route::post('collection/update/{id}', [Modules\Master\Http\Controllers\Collection\CollectionController::class, 'update'])->name('master.collection.update');

    // Agent Module
    Route::get('agent', [Modules\Master\Http\Controllers\Agent\AgentController::class, 'index'])->name('master.agent');
    Route::get('agent/create', [Modules\Master\Http\Controllers\Agent\AgentController::class, 'create'])->name('master.agent.create')->middleware('permission:master.add');
    Route::post('agent/submit', [Modules\Master\Http\Controllers\Agent\AgentController::class, 'store'])->name('master.agent.store');
    Route::get('agent/edit/{id}', [Modules\Master\Http\Controllers\Agent\AgentController::class, 'edit'])->name('master.agent.edit')->middleware('permission:master.edit');
    Route::post('agent/update/{id}', [Modules\Master\Http\Controllers\Agent\AgentController::class, 'update'])->name('master.agent.update');

    // Commision Module
    Route::get('commission', [Modules\Master\Http\Controllers\Commission\CommissionController::class, 'index'])->name('master.commission');
    Route::get('commission/create', [Modules\Master\Http\Controllers\Commission\CommissionController::class, 'create'])->name('master.commission.create')->middleware('permission:master.add');
    Route::post('commission/submit', [Modules\Master\Http\Controllers\Commission\CommissionController::class, 'store'])->name('master.commission.store');
    Route::get('commission/edit/{id}', [Modules\Master\Http\Controllers\Commission\CommissionController::class, 'edit'])->name('master.commission.edit')->middleware('permission:master.edit');
    Route::post('commission/update/{id}', [Modules\Master\Http\Controllers\Commission\CommissionController::class, 'update'])->name('master.commission.update');


    // CRM Module
    Route::get('crm', [Modules\Master\Http\Controllers\Crm\CrmController::class, 'index'])->name('master.crm');
    Route::get('crm/create', [Modules\Master\Http\Controllers\Crm\CrmController::class, 'create'])->name('master.crm.create')->middleware('permission:master.add');
    Route::post('crm/submit', [Modules\Master\Http\Controllers\Crm\CrmController::class, 'store'])->name('master.crm.store');
    Route::get('crm/edit/{id}', [Modules\Master\Http\Controllers\Crm\CrmController::class, 'edit'])->name('master.crm.edit')->middleware('permission:master.edit');
    Route::post('crm/update/{id}', [Modules\Master\Http\Controllers\Crm\CrmController::class, 'update'])->name('master.crm.update');

    // Discount Module
    Route::get('discount', [Modules\Master\Http\Controllers\Discount\DiscountController::class, 'index'])->name('master.discount');
    Route::get('discount/create', [Modules\Master\Http\Controllers\Discount\DiscountController::class, 'create'])->name('master.discount.create')->middleware('permission:master.add');
    Route::post('discount/submit', [Modules\Master\Http\Controllers\Discount\DiscountController::class, 'store'])->name('master.discount.store');
    Route::get('discount/edit/{id}', [Modules\Master\Http\Controllers\Discount\DiscountController::class, 'edit'])->name('master.discount.edit')->middleware('permission:master.edit');
    Route::post('discount/update/{id}', [Modules\Master\Http\Controllers\Discount\DiscountController::class, 'update'])->name('master.discount.update');

    // Season Module
    Route::get('season', [Modules\Master\Http\Controllers\Season\SeasonController::class, 'index'])->name('master.season');
    Route::get('season/create', [Modules\Master\Http\Controllers\Season\SeasonController::class, 'create'])->name('master.season.create')->middleware('permission:master.add');
    Route::post('season/submit', [Modules\Master\Http\Controllers\Season\SeasonController::class, 'store'])->name('master.season.store');
    Route::get('season/edit/{id}', [Modules\Master\Http\Controllers\Season\SeasonController::class, 'edit'])->name('master.season.edit')->middleware('permission:master.edit');
    Route::post('season/update/{id}', [Modules\Master\Http\Controllers\Season\SeasonController::class, 'update'])->name('master.season.update');

    // Main Catgory Module
    Route::get('maincategory', [Modules\Master\Http\Controllers\Category\CategoryController::class, 'index'])->name('master.maincategory');
    Route::get('maincategory/create', [Modules\Master\Http\Controllers\Category\CategoryController::class, 'create'])->name('master.maincategory.create')->middleware('permission:category.add');
    Route::get('maincategory/edit/{id}', [Modules\Master\Http\Controllers\Category\CategoryController::class, 'edit'])->name('master.maincategory.edit')->middleware('permission:category.edit');
    Route::post('maincategory/submit', [Modules\Master\Http\Controllers\Category\CategoryController::class, 'store'])->name('master.maincategory.store');
    Route::post('maincategory/update/{id}', [Modules\Master\Http\Controllers\Category\CategoryController::class, 'update'])->name('master.maincategory.update');

    //Catgory Module
    Route::get('category', [Modules\Master\Http\Controllers\Category\CategoryController::class, 'categoryIndex'])->name('master.category');
    Route::get('category/create', [Modules\Master\Http\Controllers\Category\CategoryController::class, 'categoryCreate'])->name('master.category.create')->middleware('permission:category.add');
    Route::post('category/submit', [Modules\Master\Http\Controllers\Category\CategoryController::class, 'categoryStore'])->name('master.category.store');
    Route::get('category/edit/{id}', [Modules\Master\Http\Controllers\Category\CategoryController::class, 'categoryEdit'])->name('master.category.edit')->middleware('permission:category.edit');
    Route::post('category/update/{id}', [Modules\Master\Http\Controllers\Category\CategoryController::class, 'categoryUpdate'])->name('master.category.update');


    //SubCatgory Module
    Route::get('subcategory', [Modules\Master\Http\Controllers\Category\SubCategoryController::class, 'index'])->name('master.subcategory');
    Route::get('subcategory/create', [Modules\Master\Http\Controllers\Category\SubCategoryController::class, 'create'])->name('master.subcategory.create')->middleware('permission:category.add');
    Route::post('subcategory/submit', [Modules\Master\Http\Controllers\Category\SubCategoryController::class, 'store'])->name('master.subcategory.store');
    Route::get('subcategory/edit/{id}', [Modules\Master\Http\Controllers\Category\SubCategoryController::class, 'edit'])->name('master.subcategory.edit')->middleware('permission:category.edit');
    Route::post('subcategory/update/{id}', [Modules\Master\Http\Controllers\Category\SubCategoryController::class, 'update'])->name('master.subcategory.update');

   //SubSubCatgory Module
   Route::get('subsubcategory', [Modules\Master\Http\Controllers\Category\SubSubCategoryController::class, 'index'])->name('master.subsubcategory');
   Route::get('subsubcategory/create', [Modules\Master\Http\Controllers\Category\SubSubCategoryController::class, 'create'])->name('master.subsubcategory.create')->middleware('permission:category.add');
   Route::post('subsubcategory/submit', [Modules\Master\Http\Controllers\Category\SubSubCategoryController::class, 'store'])->name('master.subsubcategory.store');
   Route::get('subsubcategory/edit/{id}', [Modules\Master\Http\Controllers\Category\SubSubCategoryController::class, 'edit'])->name('master.subsubcategory.edit')->middleware('permission:category.edit');
   Route::post('subsubcategory/update/{id}', [Modules\Master\Http\Controllers\Category\SubSubCategoryController::class, 'update'])->name('master.subsubcategory.update');



   //Cutting Module
   Route::get('cutting', [Modules\Master\Http\Controllers\CuttingRatio\CuttingController::class, 'index'])->name('master.cutting');
   Route::get('cutting/create', [Modules\Master\Http\Controllers\CuttingRatio\CuttingController::class, 'create'])->name('master.cutting.create')->middleware('permission:master.add');
   Route::post('cutting/submit', [Modules\Master\Http\Controllers\CuttingRatio\CuttingController::class, 'store'])->name('master.cutting.store');
   Route::get('cutting/edit/{id}', [Modules\Master\Http\Controllers\CuttingRatio\CuttingController::class, 'edit'])->name('master.cutting.edit')->middleware('permission:master.edit');
   Route::post('cutting/update/{id}', [Modules\Master\Http\Controllers\CuttingRatio\CuttingController::class, 'update'])->name('master.cutting.update');

   //Cutting Plan
   Route::get('cuttingplan', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'index'])->name('master.cuttingplan')->middleware('permission:cutting.plan.add');
   //  Route::get('cuttingplan/create', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'create'])->name('master.cuttingpan.create');
   Route::post('cuttingplan/submit', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'store'])->name('master.cuttingplan.store');
   Route::get('cuttingplan/edit/{id}', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'edit'])->name('master.cuttingplan.edit');
   Route::post('cuttingplan/update/{id}', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'update'])->name('master.cuttingplan.update');
   Route::get('delete/plan/attribute/{id}', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'deletePlanAttribute'])->name('delete.planAttribute');
   Route::get('all/plan', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'AllPlan'])->name('Allplan');
   Route::get('plan/detail/{id}', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'viewPlanAttribute'])->name('plan.detail')->middleware('permission:cutting.plan.view');
   Route::get('plan/detail/edit/{id}', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'editPlanAttribute'])->name('plan.detail.edit');
   Route::get('cutting/plan/validate/{id}', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'cuttingPlanValidate'])->name('plan.validated');
   Route::get('create/pdf/{id}', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'createPdf'])->name('cutting.pdf');
   Route::get('create/status/{id}/{status}', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'statusChange'])->name('cutting.status.change');


   Route::post('update/plan/attribute/{id}', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'updatePlanAttribute'])->name('update.planAttribute');
   Route::post('move/to/quantity', [Modules\Master\Http\Controllers\CuttingPlan\CuttingPlanController::class, 'Move'])->name('moveToQuantity');



   //Warehouse
   Route::get('export/product/index', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'index'])->name('export.product.index');
   Route::get('export/product', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'exportProduct'])->name('export.product');
   Route::post('export/product/store', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'exportProductStore'])->name('export.product.store');



   Route::get('warehouse', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'index'])->name('warehouse.index');
   Route::get('warehouse/listing', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'AllWarehouseListing'])->name('warehouse.listing.index');
   Route::get('warehouse/change/defaultstatus/{id}/{status}', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'changeDefaultStatus'])->name('changeDefaultStatus');

   Route::get('unfinished/warehouse', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'unfinishedWarehouse'])->name('unfinishedwarehouse.index')->middleware('permission:warehouse.view');
   Route::get('warehouse/list', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'Listing'])->name('warehouse.list');

   Route::get('warehouse/create', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'create'])->name('warehouse.create')->middleware('permission:warehouse.add');
   Route::post('warehouse/store', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'store'])->name('warehouse.store');
   Route::get('warehouse/edit/{id}', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'edit'])->name('warehouse.edit');
   Route::post('warehouse/update/{id}', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'update'])->name('warehouse.update');
   Route::get('warehouse/view/{id}', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'view'])->name('warehouse.view');

   Route::get('warehouse/qty/view/{id}', [Modules\Master\Http\Controllers\Warehouse\WarehouseController::class, 'viewQTY'])->name('warehouse.qty.view');


   //Online Warehouse
   Route::get('online/warehouse', [Modules\Master\Http\Controllers\OnlineWarehouse\OnlineWarehouseController::class, 'index'])->name('onlinewarehouse.index');


   //Coupon Module
   //   Route::get('gender', [Modules\Master\Http\Controllers\GenderController::class, 'index'])->name('master.gender');
   Route::get('coupon/list', [Modules\Master\Http\Controllers\Coupon\CouponController::class, 'index'])->name('coupon.list');
   Route::get('coupon/create', [Modules\Master\Http\Controllers\Coupon\CouponController::class, 'create'])->name('coupon.create')->middleware('permission:coupon.add');
   Route::post('coupon/store', [Modules\Master\Http\Controllers\Coupon\CouponController::class, 'store'])->name('coupon.store');
   Route::get('coupon/edit/{id}', [Modules\Master\Http\Controllers\Coupon\CouponController::class, 'edit'])->name('coupon.edit')->middleware('permission:coupon.edit');
   Route::post('coupon/update/{id}', [Modules\Master\Http\Controllers\Coupon\CouponController::class, 'update'])->name('coupon.update');
   Route::post('coupon/status', [Modules\Master\Http\Controllers\Coupon\CouponController::class, 'updateStatus'])->name('update.status.coupon');



   //Petty Cash Module
   Route::get('pettycash', [Modules\Master\Http\Controllers\Petty\PettyCashController::class, 'index'])->name('petty.index');
   Route::get('pettycash/datatable', [Modules\Master\Http\Controllers\Petty\PettyCashController::class, 'cashListing'])->name('pettycash.listing');
   Route::get('pettycash/create', [Modules\Master\Http\Controllers\Petty\PettyCashController::class, 'create'])->name('petty.cash.create')->middleware('permission:pettycash.add');
   Route::post('pettycash/store', [Modules\Master\Http\Controllers\Petty\PettyCashController::class, 'store'])->name('petty.cash.store');
   Route::get('pettycash/edit', [Modules\Master\Http\Controllers\Petty\PettyCashController::class, 'edit'])->name('petty.cash.edit');
   Route::post('pettycash/update', [Modules\Master\Http\Controllers\Petty\PettyCashController::class, 'update'])->name('petty.cash.update');

   Route::get('pettycash/transaction/history', [Modules\Master\Http\Controllers\Petty\PettyCashController::class, 'transactionHistory'])->name('admin.transaction.history')->middleware('permission:pettycash.viewtransaction');
   Route::get('pettycash/transaction/dhistory', [Modules\Master\Http\Controllers\Petty\PettyCashController::class, 'transactionListing'])->name('admin.datatransaction.history');


   //Cash Management
   Route::get('cash/transfer/history', [Modules\Master\Http\Controllers\Petty\CashTransferController::class, 'index'])->name('cash.transfer.index')->middleware('permission:cashtransfer.view.history');
   Route::get('cashtransferhistory', [Modules\Master\Http\Controllers\Petty\CashTransferController::class, 'cashTransferHistoryListing'])->name('cash.transfer.datatable');

   });






