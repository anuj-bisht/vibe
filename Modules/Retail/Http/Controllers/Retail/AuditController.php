<?php

namespace Modules\Retail\Http\Controllers\Retail;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Master\Entities\Size;
use Modules\Order\Entities\AuditMaster;
use Modules\Retail\Entities\RetailAuditMaster;
use Modules\Retail\Entities\RetailAuditSubMaster;
use Illuminate\Support\Facades\Session;
use Modules\Retail\Entities\OldRetailAudit;
use Modules\Retail\Entities\OldRetailAuditSubMaster;
use Modules\Retail\Entities\RetailAudit;
use Modules\Retail\Entities\RetailWarehouse;
use Modules\Retail\Entities\RetailWarehouseQty;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $retail = Session::get('retail');
        $permission = 'Retail'.$retail->id.'.retailer.stock.audit';
        if($request->user()->can($permission)){
        $retailaudit['data']= RetailAuditMaster::where('client_id', $retail->id)->get();
        return view('retail::stock.index', $retailaudit);
        }
        else{
          abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');

        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $retail = Session::get('retail');
        $temp_audit =  DB::table('temp_retail_audit')->where('retail_id', $retail->id)->first();
        if(isset( $temp_audit)){
         $data['temp_audit'] = 1;
        }else{
            $data['temp_audit'] = 0;
        }

        $data['sizes']=Size::all();
        $number=RetailAuditMaster::select('audit_no')->get()->last();
        $data['auditNumber']=$number?$number->audit_no + 1:1;
        return view('retail::stock.create',  $data);
    }

   
    public function moveToRetailStock(Request $request)
    {
        $retail= Session::get('retail');
        $data = json_decode($request->data, true);
       $retail_audit_master = new RetailAuditMaster();
       $retail_audit_master->audit_no = $data['auditNumber'];
       $retail_audit_master->save();
    
        foreach ($data['child'] as $detail) {
          
          $retail_warehouse = RetailWarehouse::where('client_id', $retail->id)->where('product_id', $detail['product_id'])->where('color_id', $detail['color_id'])->first();
          $retail_warehouse_qty = RetailWarehouseQty::where('retail_warehouse_id', $retail_warehouse->id)->pluck('qty', 'size_id');
      
 
    
          $old_rw_q=[];
          foreach ($retail_warehouse_qty as $rwkey => $rwvalue) {
            $old_rw_q[$rwkey] = (int)$rwvalue;
        }
       
          $cs=[];
          foreach ($retail_warehouse_qty as $key => $value) {
              $cs[$key] = (int)$detail['cs'][$key];
          }
      
     
          
    
          $retail_audit_sub_master = new RetailAuditSubMaster();
          $retail_audit_sub_master->retail_audit_master_id =$retail_audit_master->id;
          $retail_audit_sub_master->client_id =   $retail->id;
          $retail_audit_sub_master->color_id = $detail['color_id'];
          $retail_audit_sub_master->product_id = $detail['product_id'];
          $retail_audit_sub_master->total_qty =  array_sum($cs);
          $retail_audit_sub_master->save();
    
          $oldretail_audit_sub_master = new OldRetailAuditSubMaster();
          $oldretail_audit_sub_master->retail_audit_master_id =$retail_audit_master->id;
          $oldretail_audit_sub_master->client_id =  $retail->id;
          $oldretail_audit_sub_master->color_id = $detail['color_id'];
          $oldretail_audit_sub_master->product_id = $detail['product_id'];
          $oldretail_audit_sub_master->total_qty = array_sum($old_rw_q);
          $oldretail_audit_sub_master->save();
    
    
          foreach ($retail_warehouse_qty as $okey => $oval) {
            $old_retail_audit = new OldRetailAudit();
            $old_retail_audit->old_retail_audit_sub_master_id = $oldretail_audit_sub_master->id;
            $old_retail_audit->size_id = (int)$okey;
            $old_retail_audit->qty = (int)$oval;
            $old_retail_audit->save();
          }
    
          foreach ($detail['cs'] as $key => $val) {
            $retail_audit = new RetailAudit();
            $retail_audit->retail_audit_sub_master_id = $retail_audit_sub_master->id;
            $retail_audit->size_id = (int)$key;
            $retail_audit->qty = (int)$val;
            $retail_audit->save();
          }
          RetailWarehouse::where('id',  $retail_warehouse->id)->update(['sum' => array_sum($cs)]);
          RetailWarehouseQty::where('retail_warehouse_id',  $retail_warehouse->id)->delete();
          foreach ($detail['cs'] as $keyy => $value) {
            $retail_warehouse_qty = new RetailWarehouseQty();
            $retail_warehouse_qty->retail_warehouse_id = $retail_warehouse->id;
            $retail_warehouse_qty->size_id = (int)$keyy;
            $retail_warehouse_qty->qty = (int)$value;
            $retail_warehouse_qty->save();
        }
        }
        return redirect(route('retail.stockAudit'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */


    
  public function view($id){
    $data['sizes']=Size::all();
    $data['audit'] = RetailAuditMaster::with(['olddetail'=>function($olddetail){
      $olddetail->with(['product','color'])->with('child')->get();
    },'detail' => function ($detail) {
      $detail->with(['product','color'])
     ->with('child')->get();
  }])->where('id', $id)->first();


  return view('retail::stock.view', $data);

  }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('retail::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
