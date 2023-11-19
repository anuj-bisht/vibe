<?php

namespace Modules\Master\Http\Controllers\CuttingPlan;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Cutting;
use Modules\Master\Entities\CuttingPlan;
use Modules\Master\Entities\CuttingPlanDetail;
use Modules\Master\Entities\CuttingPlanQuantity;
use Modules\Master\Entities\CuttingPlanTemporaryDetail;
use Modules\Master\Entities\Season;
use Modules\Master\Entities\Size;
use Modules\Product\Entities\ProductMaster;
use Illuminate\Support\Facades\Session;
use Modules\Master\Entities\Unfinished;
use Modules\Master\Entities\UnfinishedMaster;
use Modules\Master\Entities\UnfinishedWarehouse;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSubMaster;
use Barryvdh\DomPDF\Facade\Pdf as PDF;


class CuttingPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function AllPlan()
    {
        $data['cutting_plan'] = CuttingPlan::get();
        
       
        // $data['sizes']=Size::all();
        return view('master::cuttingplan.allplan', $data);
    }
    public function index()
    {
        $data['sizes'] = Size::all();
        $data['season'] = Season::all();
        $data['cuttingData'] = Cutting::all();
        $data['products'] = ProductMaster::where('check_audit', 0)->get();
        $id = CuttingPlan::select('id')->get()->last();
        $data['unique_id'] = $id ? $id->id + 1 : 1;
        return view('master::cuttingplan.cuttingplan', $data);
    }


    public function create()
    {
        return view('master::create'); 
    }


    public function Move(Request $request)
    {
        $data = json_decode($request->data, true);
      
        $sizes = Size::all();

        $cuttingplan = CuttingPlan::select('id')->get()->last();
        $cuttingplan = $cuttingplan ? (int)$cuttingplan->id : 0;
        $season = Season::find($data['seasion_id']);


        $cutting_plan = new CuttingPlan();
        $cutting_plan->plan_season_code = $data['planSeasonName'];
        $cutting_plan->save();


        foreach ($data['child'] as $child) {
            $cutting_plan_detail = new CuttingPlanDetail();
            $cutting_plan_detail->cutting_plan_id = $cutting_plan->id;
            $cutting_plan_detail->season_id = $data['seasion_id'];
            $cutting_plan_detail->cutting_id = $child['ratio_id']['id'];
            $cutting_plan_detail->sum = $child['totalq'];
            $cutting_plan_detail->product_id = $child['product_id'];
            $cutting_plan_detail->color_id = $child['color_id'];
            $cutting_plan_detail->save();

            foreach ($sizes as $size) {
                $cutting_PQ = new CuttingPlanQuantity();
                $cutting_PQ->cutting_plan_detail_id = $cutting_plan_detail->id;
                $cutting_PQ->size_id = $size->id;
                $cutting_PQ->qty = $child['cs'][$size->id] ?? 0;
                $cutting_PQ->save();
            }
        };
        session()->flash('message', 'Cutting Plan Create Successfully.');
        return redirect(route('Allplan'));
    }


    public function deletePlanAttribute($id)
    {
        CuttingPlanDetail::where('id', $id)->delete();
        return redirect(route('master.cuttingplan'));
    }

    public function viewPlanAttribute($id)
    {
        $data['cutting_plan'] = CuttingPlan::with(['detail' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->get();
        }])->where('id', $id)->first();

        $data['sizes'] = Size::all();

        return view('master::cuttingplan.viewAttribute', $data);
    }


    public function editPlanAttribute($id)
    {
        $data['sizes'] = Size::all();
        $data['ratios'] = CuttingPlanDetail::with('child')->where('id', $id)->first();
        return view('master::cuttingplan.edit', $data);
    }

    public function statusChange($id, $status)
    {

        $status == 0 ? CuttingPlan::where('id', $id)->update(['status' => 1]) : CuttingPlan::where('id', $id)->update(['status' => 0]);
        return redirect(route('Allplan'));
    }

    public function updateplanAttribute(Request $request, $id)
    {


        CuttingPlanQuantity::where('cutting_plan_detail_id', $id)->delete();
        $sizes = Size::all();
        $cutting_detail = CuttingPlanDetail::find($id);
        $cutting_detail->sum = array_sum($request->cutting_qtys);
        $cutting_detail->save();


        $qty = $request->cutting_qtys;

        foreach ($sizes as $size) {


            $cuttingPQ = new CuttingPlanQuantity();
            $cuttingPQ->cutting_plan_detail_id = $cutting_detail->id;
            $cuttingPQ->size_id = $size->id;
            $cuttingPQ->qty = $qty[$size->id];
            $cuttingPQ->save();
        }
        $ratios = $request->cutting_ratios;
        session()->flash('message', 'Cutting Plan Update Successfully.');
        return redirect(route('plan.detail', ['id' => $cutting_detail->cutting_plan_id]));
    }

    public function cuttingPlanValidate($id)
    {
        $cutting_plan_product = CuttingPlanDetail::where('cutting_plan_id', $id)->get();
       
        

        foreach ($cutting_plan_product as $cp_product) {

            
            if (UnfinishedMaster::where('product_master_id', $cp_product['product_id'])->where('color_id', $cp_product['color_id'])->exists()) {
                $product_price = ProductSubMaster::where('product_master_id',  $cp_product['product_id'])->where('color_id',  $cp_product['color_id'])->first();
                $unfinished_master = UnfinishedMaster::where('product_master_id', $cp_product['product_id'])->where('color_id', $cp_product['color_id'])->first();
                $cutting_plan_detail_id = CuttingPlanDetail::where('cutting_plan_id', $id)->where('product_id', $cp_product['product_id'])->where('color_id', $cp_product['color_id'])->first();
                $cutting_plan_qty = CuttingPlanQuantity::where('cutting_plan_detail_id',  $cutting_plan_detail_id->id)->pluck('qty', 'size_id');
                $exist_product_qty = Unfinished::where('unfinished_master_id',  $unfinished_master->id)->pluck('qty', 'size_id')->all();
             
                $new_updated_qty = [];
                foreach ($exist_product_qty as $key => $val) {
                    $new_updated_qty[$key] = $cutting_plan_qty[$key] + $val;
                }
              
                Unfinished::where('unfinished_master_id',  $unfinished_master->id)->delete();
                UnfinishedMaster::where('id', $unfinished_master->id)->update(['sum' => array_sum($new_updated_qty), 'price' => array_sum($new_updated_qty) * $product_price->mrp]);
                foreach ($new_updated_qty as $updated_key => $updated_val) {
                    $new_upq = new Unfinished();
                    $new_upq->unfinished_master_id = $unfinished_master->id;
                    $new_upq->size_id = $updated_key;
                    $new_upq->qty = $updated_val;
                    $new_upq->save();
                }
            } else {

                $product_price = ProductSubMaster::where('product_master_id',  $cp_product['product_id'])->where('color_id',  $cp_product['color_id'])->first();
                $cutting_plan_detail_id = CuttingPlanDetail::where('cutting_plan_id', $id)->where('product_id', $cp_product['product_id'])->where('color_id', $cp_product['color_id'])->first();
                $cutting_plan_qty = CuttingPlanQuantity::where('cutting_plan_detail_id',  $cutting_plan_detail_id->id)->pluck('qty', 'size_id');
                $new_up = new UnfinishedMaster();
                $new_up->product_master_id = $cp_product['product_id'];
                $new_up->color_id = $cp_product['color_id'];
                $new_up->sum = $cp_product['sum'];
                $new_up->price = $cp_product['sum'] * $product_price->mrp;
                $new_up->save();

                foreach ($cutting_plan_qty as $key => $val) {
                    $new_upq = new Unfinished();
                    $new_upq->unfinished_master_id = $new_up->id;
                    $new_upq->size_id = $key;
                    $new_upq->qty = $val;
                    $new_upq->save();
                }
            }
            CuttingPlan::where('id', $id)->update(['status' => 1]);
        }
        session()->flash('msg', 'Successfully done the operation.');
        return redirect()->back();
    }


    public function createPDF($id)
    {
        $data['cutting_plan'] = CuttingPlan::with(['detail' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->get();
        }])->where('id', $id)->first();

        $data['sizes'] = Size::all();
        $pdf = PDF::loadView('master::cuttingplan.pdfAttribute', $data)->setOption(['defaultFont' => 'serif'])->setPaper('A4', 'landscape');
        return $pdf->stream('product.pdf');
        return $pdf->render();
    }
}
