<?php

namespace Modules\Corporate\Http\Controllers\Grn;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Modules\Corporate\Entities\GrnDefective;
use Modules\Corporate\Entities\GrnDefectiveSubMaster;
use Modules\Corporate\Entities\GrnUndefective;
use Modules\Corporate\Entities\GrnUndefectiveSubMaster;
use Modules\Master\Entities\FinishedWarehouse;
use Modules\Master\Entities\FinishedWarehouseQty;
use Modules\Master\Entities\Size;
use Modules\Master\Entities\Unfinished;
use Modules\Master\Entities\UnfinishedMaster;
use Modules\Master\Entities\Warehouse;
use Modules\Product\Entities\ProductSubMaster;
use Modules\Retail\Entities\GrnMaster;
use Modules\Retail\Entities\RetailWarehouse;
use Modules\Retail\Entities\RetailWarehouseQty;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Yajra\DataTables\Facades\DataTables;

class GrnController extends Controller
{
  
    public function index()
    {
        
        return view('corporate::grn.index');
    }

    public function allGrnListing(Request $request)
    {
        if ($request->ajax()) {
            $data = GrnMaster::leftjoin('corporate_profiles', 'corporate_profiles.id','=','grn_masters.retail_id')
            ->select('grn_masters.*', 'corporate_profiles.name as retailer_name');
            if(!empty($request->from_date)) {

                $data =  $data->whereBetween('grn_masters.created_at', array($request->from_date, Carbon::parse($request->to_date)->endOfDay()));

            }                    
            return DataTables::of($data->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route('admin.retail.grn.view', ['id' => $row->id]) . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    if($row->validated == 0){
                    $validateBtn = '<a class="btn btn-sm btn-danger"  href="' . route('admin.retail.grn.validate', ['id' => $row->id]) . '"  type="submit">Validate</a>';
                    return $actionBtn." ".$validateBtn;
                   }else{
                    $validatedBtn = '<a class="btn btn-sm btn-success"  href="' . route('admin.retail.already.validate', ['id' => $row->id]) . '" type="submit">Validated</a>';
                    return $actionBtn." ".$validatedBtn;
                   }
                })
                ->rawColumns(['view', 'action'])
                ->make(true);
        }
    }

    public function view(Request $request)
    {
        $id = $request->id;
        $data['sizes'] = Size::get();
        $data['grn_detail'] = GrnMaster::with(['corporate_profile', 'detail' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->get();
        }])->where('id', $id)->first();
        return view('corporate::grn.view', $data);
    }

    public function validate(Request $request){
        $purchase['warehouses'] = Warehouse::where('status', 'Active')->where('type', 'Finished')->get();
        $id =$request->id;
        $grn_detail = GrnMaster::with(['corporate_profile', 'detail' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->get();
        }])->where('id', $id)->get();

      $data = [];
        foreach ($grn_detail as $ind) {
            $detail = [];
            $detail['id'] = $ind['id'];
            $detail['grn_no'] = $ind['grn_no'];
            $detail['retailer_id'] = $ind['retail_id'];
            $detail['retailer_name'] = $ind['corporate_profile']['name'];
            $detail['is_export'] = 0;

         
            $detail['detail'] = [];
            foreach ($ind['detail'] as $val) {
                $d = [];
                $d['id'] = $val['id'];
                $d['validated'] = false;
                $d['grn_master_id'] = $val['grn_master_id'];
                $d['color_id'] = $val['color_id'];
                $d['product_id'] = $val['product_id'];
                $d['per_qty'] = $val['per_qty'];
                $d['total_price'] = $val['total_price'];
                $d['total_qty'] = $val['total_qty'];
                $d['product'] = $val['product'];
                $d['color'] = $val['color'];
                $d['defective'] = false;
                $d['cs'] = $val['child']->pluck('qty', 'size_id');
                array_push($detail['detail'], $d);
            }
            array_push($data, $detail);
        }
        $purchase['sizes'] = Size::all();
        $purchase['grn'] = $data[0];
    
        return view('corporate::grn.validate', $purchase);

    }


    public function moveToGrnSection(Request $request){
         $data = json_decode($request->data, true);
    // return $data;
    // die;
         foreach ($data['child'] as $child) {
 
             if ($child['defective'] == true) {
             
                $grn_defective_sub_master = new GrnDefectiveSubMaster();
                $grn_defective_sub_master->grn_master_id = $data['grn_master_id'];
                $grn_defective_sub_master->color_id = $child['color_id'];
                $grn_defective_sub_master->product_id = $child['product_id'];
                $grn_defective_sub_master->per_qty = $child['per_qty'];
                $grn_defective_sub_master->total_qty = $child['total_qty'];
                $grn_defective_sub_master->total_price = $child['total_price'];
                $grn_defective_sub_master->save();
 
                 foreach ($child['cs'] as $key => $val) {
 
                     $grn_defective = new GrnDefective();
                     $grn_defective->grn_defective_sub_master_id = $grn_defective_sub_master->id;
                     $grn_defective->size_id =  $key;
                     $grn_defective->qty =  $val;
                     $grn_defective->save();
                 }

                $unfi_master = UnfinishedMaster::where('product_master_id', $child['product_id'])->where('color_id', $child['color_id'])->first();
                $product_price = ProductSubMaster::where('product_master_id', $child['product_id'])->where('color_id', $child['color_id'])->first()->mrp;
                $unfi_master_qty = Unfinished::where('unfinished_master_id',  $unfi_master->id)->pluck('qty', 'size_id');
                $new_unfi_ware_qty = [];
                 foreach ($unfi_master_qty as $nunfikey => $nunfivalue) {
                     $new_unfi_ware_qty[$nunfikey] = $nunfivalue + $child['cs'][$nunfikey];
                 }
                 
                 Unfinished::where('unfinished_master_id',$unfi_master->id)->delete();
                 UnfinishedMaster::where('product_master_id', $child['product_id'])->where('color_id', $child['color_id'])->update(['sum'=>array_sum( $new_unfi_ware_qty), 'price'=>array_sum( $new_unfi_ware_qty)*$product_price]);
                    foreach ($new_unfi_ware_qty as $nunfinishedkey => $nunfinishedval) {
                     $fwq = new Unfinished();
                     $fwq->unfinished_master_id =  $unfi_master->id;
                     $fwq->size_id =  $nunfinishedkey;
                     $fwq->qty =   $nunfinishedval;
                     $fwq->save();
                 } 






                 $rw_id = RetailWarehouse::where('client_id',  $data['retail_id'])->where('product_id', $child['product_id'])->where('color_id', $child['color_id'])->first()->id;
                 $rw_qty = RetailWarehouseQty::where('retail_warehouse_id', $rw_id)->pluck('qty', 'size_id');
                 $new_rw_qty = [];
 
                 foreach ($rw_qty as $nukey => $nuvalue) {
                     $new_rw_qty[$nukey] = $nuvalue - $child['cs'][$nukey];
                 }
                 RetailWarehouseQty::where('retail_warehouse_id', $rw_id)->delete();
                 RetailWarehouse::where('client_id',  $data['retail_id'])->where('product_id', $child['product_id'])->where('color_id', $child['color_id'])->update(['sum' => array_sum($new_rw_qty)]);
                  foreach ($new_rw_qty as $nekey => $neval) {
                      $rw = new RetailWarehouseQty();
                      $rw->retail_warehouse_id =  $rw_id;
                      $rw->size_id =  $nekey;
                      $rw->qty =  $neval;
                      $rw->save();
                  }
 

             } 
             else {
             

                 $grn_undefective_sub_master = new GrnUndefectiveSubMaster();
                 $grn_undefective_sub_master->grn_master_id =  $data['grn_master_id'];
                 $grn_undefective_sub_master->color_id = $child['color_id'];
                 $grn_undefective_sub_master->product_id = $child['product_id'];
                 $grn_undefective_sub_master->per_qty = 0;
                 $grn_undefective_sub_master->total_qty = $child['total_qty'];
                 $grn_undefective_sub_master->total_price = $child['total_price'];
                 $grn_undefective_sub_master->save();
 
                 foreach ($child['cs'] as $key => $val) {
 
                     $grn_undefective = new GrnUndefective();
                     $grn_undefective->grn_undefective_sub_master_id =  $grn_undefective_sub_master->id;
                     $grn_undefective->size_id =  $key;
                     $grn_undefective->qty =  $val;
                     $grn_undefective->save();
                 }
 

                $ware = FinishedWarehouse::where('warehouse_id',  $data['warehouse_object']['id'])->where('product_master_id', $child['product_id'])->where('color_id', $child['color_id'])->first();
                if(isset($ware)){
                 $fi_ware_qty = FinishedWarehouseQty::where('finished_warehouse_id', $ware->id)->pluck('qty', 'size_id');
                
                 $new_fi_ware_qty = [];
                 foreach ($fi_ware_qty as $nfwkey => $nfwvalue) {
                     $new_fi_ware_qty[$nfwkey] = $nfwvalue + $child['cs'][$nfwkey];
                 }
                 FinishedWarehouseQty::where('finished_warehouse_id', $ware->id)->delete();
                 FinishedWarehouse::where('warehouse_id',  $data['warehouse_object']['id'])->where('product_master_id', $child['product_id'])->where('color_id', $child['color_id'])->update(['sum'=>array_sum($new_fi_ware_qty)]);
                    foreach ($new_fi_ware_qty as $nfiwarekey => $neval) {
                     $fwq = new FinishedWarehouseQty();
                     $fwq->finished_warehouse_id =  $ware->id;
                     $fwq->size_id =  $nfiwarekey;
                     $fwq->qty =  $neval;
                     $fwq->save();
                 } 
                        
                }else{
                    $finish_warehouse = new FinishedWarehouse();
                    $finish_warehouse->check_audit =  0;
                    $finish_warehouse->warehouse_id =   $data['warehouse_object']['id'];
                    $finish_warehouse->product_master_id =  $child['product_id'];
                    $finish_warehouse->color_id =  $child['color_id'];
                    $finish_warehouse->sum =  array_sum($child['cs']);
                    $finish_warehouse->save();

                    foreach ($child['cs'] as $key => $val) {
 
                        $finished_warehouse_qty = new FinishedWarehouseQty();
                        $finished_warehouse_qty->finished_warehouse_id =  $finish_warehouse->id;
                        $finished_warehouse_qty->size_id =  $key;
                        $finished_warehouse_qty->qty =  $val;
                        $finished_warehouse_qty->save();
                    }
                    
                    
                }


                 $rw_id = RetailWarehouse::where('client_id',  $data['retail_id'])->where('product_id', $child['product_id'])->where('color_id', $child['color_id'])->first()->id;
                 $rw_qty = RetailWarehouseQty::where('retail_warehouse_id', $rw_id)->pluck('qty', 'size_id');
                 $new_rw_qty = [];

                 foreach ($rw_qty as $nukey => $nuvalue) {
                     $new_rw_qty[$nukey] = $nuvalue - $child['cs'][$nukey];
                 }
                 RetailWarehouseQty::where('retail_warehouse_id', $rw_id)->delete();
                 RetailWarehouse::where('client_id',  $data['retail_id'])->where('product_id', $child['product_id'])->where('color_id', $child['color_id'])->update(['sum' => array_sum($new_rw_qty)]);
                 foreach ($new_rw_qty as $nekey => $neval) {
                     $rw = new RetailWarehouseQty();
                     $rw->retail_warehouse_id =  $rw_id;
                     $rw->size_id =  $nekey;
                     $rw->qty =  $neval;
                     $rw->save();
                 }
             }
         }

         GrnMaster::where('id', $data['grn_master_id'])->update(['validated'=>1]);
         return redirect(route('corporate.all.grn'));
    }

    public function grnValidated(Request $request){
        $id = $request->id;
        $data['sizes'] = Size::all();
        $data['grn_detail'] = GrnMaster::with(['corporate_profile', 'undefective' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->get();
        }, 'defective' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->get();
        }])->where('id', $id)->first();
        // return  $data['grn_detail'];
        // die;
        return view('corporate::grn.validated', $data);

    }
}
