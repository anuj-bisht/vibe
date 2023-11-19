<?php

namespace Modules\Order\Http\Controllers\Picklist;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Corporate\Entities\State;
use Modules\Master\Entities\Discount;
use Modules\Master\Entities\FinishedWarehouse;
use Modules\Master\Entities\FinishedWarehouseQty;
use Modules\Master\Entities\Size;
use Modules\Master\Entities\Tax;
use Modules\Master\Entities\Unfinished;
use Modules\Master\Entities\UnfinishedMaster;
use Modules\Master\Entities\UnfinishedWarehouse;
use Modules\Master\Entities\UnfinishedWarehouseQty;
use Modules\Master\Entities\Warehouse;
use Modules\Order\Entities\DefectiveGood;
use Modules\Order\Entities\DefectiveGoodSubMaster;
use Modules\Order\Entities\Good;
use Modules\Order\Entities\GoodMaster;
use Modules\Order\Entities\GoodSubMaster;
use Modules\Order\Entities\InvoiceMaster;
use Modules\Order\Entities\OrderMaster;
use Modules\Product\Entities\ProductMaster;
use Yajra\DataTables\Facades\DataTables;


class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index()
    {
        $data['start_date']= Carbon::now()->startOfMonth()->toDateString();
        $data['end_date']= Carbon::now()->toDateString();
        return view('order::goods.index',$data);
    }

    public function goodReturnListing(Request $request)
    {
        if ($request->ajax()) {
            $data = GoodMaster::leftjoin('corporate_profiles', 'corporate_profiles.id', '=', 'goods_masters.client_id')
                ->select('goods_masters.*', 'corporate_profiles.name as client_name');

            if (!empty($request->from_date)) {
                $data =  $data->whereBetween('goods_masters.created_at', array($request->from_date, Carbon::parse($request->to_date)->endOfDay()));
            }
            return Datatables::of($data->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route('goods.returns.view', ['id' => $row->id]) . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    return $actionBtn;
                })
                ->rawColumns(['view', 'action'])
                ->make(true);
        }
    }
    public function goodReturns()
    {
        $data['warehouses'] = Warehouse::where('status', 'Active')->where('type', 'Finished')->get();
        $data['default_warehouse'] = Warehouse::where('type', 'Finished')->where('default_status', 1)->first();
        $data['sizes'] = Size::get();
        $data['orders'] = OrderMaster::get();
        $data['products'] = ProductMaster::where('check_audit', 0)->get();
        $data['states'] = State::all();
        $data['plucksize'] = Size::pluck('size', 'id');

        $number = GoodMaster::select('grn_no')->get()->last();
        $data['grnNumber'] = $number ? $number->grn_no + 1 : 1;


        return view('order::goods.returns', $data);
    }


    public function moveToGoods(Request $request)
    {
        $data = json_decode($request->data, true);

        $good_master = new GoodMaster();
        $good_master->grn_no = $data["grnNumber"];
        $good_master->client_id = $data['client_id'];
        $good_master->warehouse_id = $data['warehouse']['id'];
        $good_master->save();


        foreach ($data['child'] as $child) {

            if ($child['defective'] == true) {

                $defective_good_sub_master = new DefectiveGoodSubMaster();
                $defective_good_sub_master->goods_master_id = $good_master->id;
                $defective_good_sub_master->color_id = $child['color_id'];
                $defective_good_sub_master->product_id = $child['product_id'];
                $defective_good_sub_master->qty = 0;
                $defective_good_sub_master->total = $child['totalq'];
                $defective_good_sub_master->save();

                foreach ($child['cs'] as $key => $val) {

                    $defective_good = new DefectiveGood();
                    $defective_good->defective_goods_sub_master_id =  $defective_good_sub_master->id;
                    $defective_good->size_id =  $key;
                    $defective_good->qty =  $val;
                    $defective_good->save();
                }

                $uf_id = UnfinishedMaster::where('product_master_id', $child['product_id'])->where('color_id', $child['color_id'])->first()->id;

                $uf_qty = Unfinished::where('unfinished_master_id', $uf_id)->pluck('qty', 'size_id');

                $new_uf_qty = [];

                foreach ($uf_qty as $nukey => $nuvalue) {
                    $new_uf_qty[$nukey] = $nuvalue + $child['cs'][$nukey];
                }
                Unfinished::where('unfinished_master_id', $uf_id)->delete();
                UnfinishedMaster::where('product_master_id', $child['product_id'])->where('color_id', $child['color_id'])->update(['sum' => array_sum($new_uf_qty)]);
                foreach ($new_uf_qty as $nekey => $neval) {
                    $uf_w = new Unfinished();
                    $uf_w->unfinished_master_id =  $uf_id;
                    $uf_w->size_id =  $nekey;
                    $uf_w->qty =  $neval;
                    $uf_w->save();
                }
            } else {

                $good_sub_master = new GoodSubMaster();
                $good_sub_master->goods_master_id = $good_master->id;
                $good_sub_master->color_id = $child['color_id'];
                $good_sub_master->product_id = $child['product_id'];
                $good_sub_master->qty = 0;
                $good_sub_master->total = $child['totalq'];
                $good_sub_master->save();

                foreach ($child['cs'] as $key => $val) {

                    $good = new Good();
                    $good->goods_sub_master_id =  $good_sub_master->id;
                    $good->size_id =  $key;
                    $good->qty =  $val;
                    $good->save();
                }

                $fw_id = FinishedWarehouse::where('warehouse_id', $data['warehouse']['id'])->where('product_master_id', $child['product_id'])->where('color_id', $child['color_id'])->first()->id;
                $fw_qty = FinishedWarehouseQty::where('finished_warehouse_id', $fw_id)->pluck('qty', 'size_id');
                $new_fw_qty = [];

                foreach ($fw_qty as $nufwkey => $nufwvalue) {
                    $new_fw_qty[$nufwkey] = $nufwvalue + $child['cs'][$nufwkey];
                }
                FinishedWarehouseQty::where('finished_warehouse_id', $fw_id)->delete();
                FinishedWarehouse::where('warehouse_id', $data['warehouse']['id'])->where('product_master_id', $child['product_id'])->where('color_id', $child['color_id'])->update(['sum' => array_sum($new_fw_qty)]);
                foreach ($new_fw_qty as $nfwkey => $nfwval) {
                    $f_w = new FinishedWarehouseQty();
                    $f_w->finished_warehouse_id =  $fw_id;
                    $f_w->size_id =  $nfwkey;
                    $f_w->qty =  $nfwval;
                    $f_w->save();
                }
            }
        }
        session()->flash('message', 'Good Return Successfully.');
        return redirect(route('goods.returns.index'));
    }

    public function view(Request $request)
    {
        $id = $request->id;
        $data['sizes'] = Size::all();
        $data['good_return_detail'] = GoodMaster::with(['warehouse', 'client', 'defective_goods_sub_masters' => function ($det) {
            $det->with(['product', 'color'])->with('child')->get();
        }, 'detail' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->get();
        }])->where('id', $id)->first();

        return view('order::goods.view', $data);
    }


    public function Undefective()
    {
        $data['sizes'] = Size::all();
        $data['undefective'] = GoodSubMaster::with(['product', 'color', 'child'])->get();
        return view('order::goods.undefective', $data);
    }

    public function Defective()
    {

        $data['sizes'] = Size::all();
        $data['defective'] = UnfinishedWarehouse::with(['product', 'color', 'child'])->get();

        return view('order::goods.defective', $data);
    }
}
