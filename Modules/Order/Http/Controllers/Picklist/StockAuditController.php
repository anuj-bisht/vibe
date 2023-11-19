<?php

namespace Modules\Order\Http\Controllers\Picklist;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Modules\Master\Entities\FinishedWarehouse;
use Modules\Master\Entities\FinishedWarehouseQty;
use Modules\Master\Entities\MainCategory;
use Modules\Master\Entities\Size;
use Modules\Master\Entities\Warehouse;
use Modules\Order\Entities\Audit;
use Modules\Order\Entities\AuditMaster;
use Modules\Order\Entities\AuditSubMaster;
use Modules\Order\Entities\OldAudit;
use Modules\Order\Entities\OldAuditSubMaster;
use Modules\Order\Entities\TempAuditDetail;
use Modules\Product\Entities\ProductMaster;
use Modules\Product\Entities\ProductSubMaster;

class StockAuditController extends Controller
{
  public function index(){
    $audit['data']= AuditMaster::all();
    return view('order::stockAudit.index', $audit);

  }

  // public function stockAudit()
  // {
  //   $data['main_categories'] = MainCategory::with('product_sub_masters')->get();
  //   $data['warehouses'] = Warehouse::with(['child'=>function($query){
  //     $query->with(['product_masters','color','child']);
  //   }])->get();
   
 
  //   $data['products'] = ProductMaster::all();
  //   $data['sizes'] = Size::all();
  //   $number=AuditMaster::select('audit_no')->get()->last();
  //   $data['auditNumber']=$number?$number->audit_no + 1:1;
    
  //   return view('order::stockAudit.stock', $data);
  // }

  public function stockAudit()
  {
  
    $data['cat_data']=null;
    $data['child']=null;
    if(TempAuditDetail::first()){
     $data['cat']=TempAuditDetail::first()->cate_data;
     $data['tchild']=TempAuditDetail::first()->data;

      $data['cat_data']=json_decode($data['cat'], true);
      $data['child']=json_decode($data['tchild']);
    }
   

    $data['main_categories'] = MainCategory::all();
    $data['warehouses'] = Warehouse::all();
    $data['sizes'] = Size::all();
    $number=AuditMaster::select('audit_no')->get()->last();
    $data['auditNumber']=$number?$number->audit_no + 1:1;
    
    return view('order::stockAudit.stock', $data);
  }

  public function getProducts(Request $request){
      $ware_id= $request->input("ware_id");

      $products= ProductSubMaster::leftJoin("finished_warehouses" , function($join) use ($ware_id){
        $join->on("finished_warehouses.product_master_id","product_sub_masters.product_master_id")->where("finished_warehouses.color_id","product_sub_masters.color_id")
        ->where("finished_warehouses.product_master_id","product_sub_masters.product_master_id")->where("finished_warehouses.id", $ware_id);
      })->with(["child", "parent" ])->select("product_sub_masters.*")->get();

      return $products;
      
  }


  public function moveToStock(Request $request)
  {
    $data = json_decode($request->data, true);
    $audit_master = new AuditMaster();
    $audit_master->audit_no = $data['auditNumber'];
    $audit_master->save();

    foreach ($data['oldChild'] as $detail) {
      $finished_warehouse = FinishedWarehouse::where('warehouse_id', $data['warehouse_id'])->where('product_master_id', $detail['product_id'])->where('color_id', $detail['color_id'])->first();
      FinishedWarehouse::where('warehouse_id', $data['warehouse_id'])->where('product_master_id', $detail['product_id'])->where('color_id', $detail['color_id'])->update(['check_audit'=>0]);
      $finished_warehouse_qty = FinishedWarehouseQty::where('finished_warehouse_id', $finished_warehouse->id)->pluck('qty', 'size_id');
  
      $old_fw_q=[];
      foreach ($finished_warehouse_qty as $fwkey => $fwvalue) {
        $old_fw_q[$fwkey] = (int)$fwvalue;
    }
   
      $cs=[];
      foreach ($finished_warehouse_qty as $key => $value) {
          $cs[$key] = (int)$detail['cs'][$key];
      }
  
      $audit_sub_master = new AuditSubMaster();
      $audit_sub_master->audit_master_id = $audit_master->id;
      $audit_sub_master->warehouse_id =  $data['warehouse_id'];
      $audit_sub_master->color_id = $detail['color_id'];
      $audit_sub_master->product_id = $detail['product_id'];
      $audit_sub_master->total_qty =  array_sum($cs);
      $audit_sub_master->save();

      $oldaudit_sub_master = new OldAuditSubMaster();
      $oldaudit_sub_master->audit_master_id = $audit_master->id;
      $oldaudit_sub_master->warehouse_id =  $data['warehouse_id'];
      $oldaudit_sub_master->color_id = $detail['color_id'];
      $oldaudit_sub_master->product_id = $detail['product_id'];
      $oldaudit_sub_master->total_qty = array_sum($old_fw_q);
      $oldaudit_sub_master->save();


      foreach ($finished_warehouse_qty as $okey => $oval) {
        $old_audit = new OldAudit();
        $old_audit->old_audit_sub_master_id = $oldaudit_sub_master->id;
        $old_audit->size_id = (int)$okey;
        $old_audit->qty = (int)$oval;
        $old_audit->save();
      }

      foreach ($detail['cs'] as $key => $val) {
        $audit = new Audit();
        $audit->audit_sub_master_id = $audit_sub_master->id;
        $audit->size_id = (int)$key;
        $audit->qty = (int)$val;
        $audit->save();
      }
      FinishedWarehouse::where('id', $finished_warehouse->id)->update(['sum' => array_sum($cs)]);
      FinishedWarehouseQty::where('finished_warehouse_id',  $finished_warehouse->id)->delete();
      foreach ($detail['cs'] as $keyy => $value) {
        $finished_warehouse_qty = new FinishedWarehouseQty();
        $finished_warehouse_qty->finished_warehouse_id = $finished_warehouse->id;
        $finished_warehouse_qty->size_id = (int)$keyy;
        $finished_warehouse_qty->qty = (int)$value;
        $finished_warehouse_qty->save();
    }
    }
    TempAuditDetail::truncate();
    session()->flash('message', 'Auditing Completed.');
    return redirect(route('stock.audit.index'));

  }


  public function view($id){
    $data['sizes']=Size::all();
    $data['audit'] = AuditMaster::with(['olddetail'=>function($olddetail){
      $olddetail->with(['product','color'])->with('child')->get();
    },'detail' => function ($detail) {
      $detail->with(['product','color'])
     ->with('child')->get();
  }])->where('id', $id)->first();
 
    return view('order::stockAudit.view', $data);
  }



  public function auditStatus(){
    $data['products']=FinishedWarehouse::with(['product_masters', 'color','warehouses'])->where('check_audit',1)->get();
    return view('order::stockAudit.auditStatus', $data);
  }

  public function moveToTempAuditDetail(Request $request){
    $data = json_decode($request->data, true);

    if(!empty($data['main_category_id']) && !empty($data['array_sub_category'])){
    $asc= $data['array_sub_category'];
    $q=  implode(',' ,array_fill(0, count($asc), '?'));
   

      FinishedWarehouse::where("warehouse_id", 1)
      ->whereRaw("(product_master_id, color_id)
       IN (select product_master_id, color_id from product_sub_masters where main_category_id=? and category_id IN ($q))",
       [$data['main_category_id']['id'], ...$asc])->update(['check_audit'=>1]);

    }
    else if(!empty($data['main_category_id'])){
      FinishedWarehouse::where("warehouse_id", 1)->whereRaw("(product_master_id, color_id) IN (select product_master_id, color_id from product_sub_masters where main_category_id=?)",[$data['main_category_id']['id']])->update(['check_audit'=>1]);
    }

    TempAuditDetail::insert(['cate_data'=>  json_encode($data),'data'=>'']);
    session()->flash('message', 'You Can Start The Auditing.');
    return redirect(route('stock.audit'));

  }

  public function storeTempAudit(Request $request){
    $id=TempAuditDetail::first()->id;
    TempAuditDetail::where('id',$id)->update(['data'=>  json_encode($request->child)]);

    return redirect(route('stock.audit.index'));
  }

  public function resetData(){
   $data= TempAuditDetail::first()->cate_data;
  $d= json_decode($data);
  if(isset($d->main_category_id)){
  FinishedWarehouse::where("warehouse_id", 1)->whereRaw("(product_master_id, color_id) IN (select product_master_id, color_id from product_sub_masters where main_category_id=?)",[$d->main_category_id->id])->update(['check_audit'=>0]);
  }

    TempAuditDetail::truncate();
    session()->flash('message', 'Data Reset.');
    return redirect(route('stock.audit'));


  }
}
