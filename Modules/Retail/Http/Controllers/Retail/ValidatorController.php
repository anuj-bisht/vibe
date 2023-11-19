<?php

namespace Modules\Retail\Http\Controllers\Retail;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Carbon;
use Modules\Master\Entities\Size;
use Modules\Order\Entities\InvoiceMaster;
use Modules\Retail\Entities\PurchaseMaster;
use Modules\Retail\Entities\RetailWarehouse;
use Modules\Retail\Entities\RetailWarehouseQty;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Session;

class ValidatorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $data['start_date']= Carbon::now()->startOfMonth()->toDateString();
        $data['end_date']= Carbon::now()->toDateString();
        $retail_session_data = $request->session()->get('retail');
        $data['id'] = $retail_session_data->id;
      

        return view('retail::validated.index', $data);
    }

    public function validateListing(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->retailer_id)) {
                $data = PurchaseMaster::leftjoin('corporate_profiles', 'corporate_profiles.id','=','purchase_masters.client_id')
                ->leftjoin('taxes', 'taxes.id','=','purchase_masters.tax_id')
                ->select('purchase_masters.*','corporate_profiles.name as retailer_name')->where('purchase_masters.client_id', $request->retailer_id);
            }
            if(!empty($request->from_date)) {

                $data =  $data->whereBetween('purchase_masters.created_at', array($request->from_date, Carbon::parse($request->to_date)->endOfDay()));

            }    
            return Datatables::of($data->get())
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route('validate.list.view', ['id' => $row->id]) . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    return $actionBtn;
                })
                ->rawColumns(['view', 'action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        return view('retail::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function view($id, Request $request)
    {
        $ret = session::get('retail');
        $permission = 'Retail'.$ret->id.'.mrn.validate.view';
        if($request->user()->can($permission)){
        $purchase['sizes'] = Size::get();
        $validate_data = PurchaseMaster::with(['client', 'warehouse', 'tax', 'pdetail' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->pluck('qty');
        }])->where('id', $id)->get();

    
        $data = [];
        foreach ($validate_data as $ind) {
            $detail = [];
            $detail['id'] = $ind['id'];
            $detail['is_export'] = $ind['is_export'];
            $detail['warehouse_id'] = $ind['warehouse_id'];
            $detail['invoice_no'] = $ind['invoice_no'];
            $detail['regular'] = $ind['regular'];
            $detail['date'] = $ind['created_at'];
            $detail['client_id'] = $ind['client_id'];
            $detail['order_id'] = $ind['order_id'];
            $detail['picklist_id'] = $ind['picklist_id'];
            $detail['tax_id'] = $ind['tax_id'];
            $detail['total_pcs'] = $ind['total_pcs'];
            $detail['discount'] = $ind['discount'];
            $detail['discount_price'] = $ind['discount_price'];
            $detail['tax_price'] = $ind['tax_price'];
            $detail['sub_total'] = $ind['sub_total'];
            $detail['grand_total'] = $ind['grand_total'];
            $detail['client'] = $ind['client'];
            $detail['warehouse'] = $ind['warehouse'];
            $detail['tax'] = $ind['tax'];
            $detail['detail'] = [];
            foreach ($ind['pdetail'] as $val) {

                $d = [];
                $d['id'] = $val['id'];
                $d['invoice_master_id'] = $val['purchase_master_id'];
                $d['color_id'] = $val['color_id'];
                $d['product_id'] = $val['product_id'];
                // $d['per_qty'] = $val['per_qty'];
                $d['qty'] = $val['qty'];
                $d['total'] = $val['total'];
                $d['product'] = $val['product'];
                $d['color'] = $val['color'];
                $d['cs'] = $val['child']->pluck('qty', 'size_id');
                array_push($detail['detail'], $d);
            }
            array_push($data, $detail);
        }
        $purchase['eproducts'] = $data[0];

        return view('retail::validated.view', $purchase);
    }else{
        abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');

    }
    }

    public function export(Request $request)
    {
        
        $data = json_decode($request->data, true);
         
        return $data;
        die;
        $purchase_master_id = $data['id'];
        $client_id = $data['client_id'];

        foreach ($data['child'] as $child) {

            $retail_warehouse = RetailWarehouse::where('client_id', $client_id)->where('product_id', $child['product_id'])->where('color_id', $child['color_id'])->first();

            if (isset($retail_warehouse)) {
                $retail_warehouse_qty = RetailWarehouseQty::where('retail_warehouse_id', $retail_warehouse->id)->pluck('qty', 'size_id');
            }

            if (!isset($retail_warehouse)) {
                $retail_warehouse = new RetailWarehouse();
                $retail_warehouse->client_id = $client_id;
                $retail_warehouse->product_id = $child['product_id'];
                $retail_warehouse->color_id = $child['color_id'];
                $retail_warehouse->sum = array_sum($child['cs']);


                if ($retail_warehouse->save()) {
                    foreach ($child['cs'] as $key => $value) {
                        $retail_warehouse_qty = new RetailWarehouseQty();
                        $retail_warehouse_qty->retail_warehouse_id = $retail_warehouse->id;
                        $retail_warehouse_qty->size_id = $key;
                        $retail_warehouse_qty->qty = $value;
                        $retail_warehouse_qty->save();
                    }
                }
            } else {
                $new_retail_warehouse_qty = [];
                foreach ($child['cs'] as $nkey => $nvalue) {
                    $new_retail_warehouse_qty[$nkey] = $retail_warehouse_qty[$nkey] + $nvalue;
                }

                RetailWarehouse::where('client_id', $client_id)->where('product_id', $child['product_id'])->where('color_id', $child['color_id'])->update(['sum' => array_sum($new_retail_warehouse_qty)]);
                RetailWarehouseQty::where('retail_warehouse_id', $retail_warehouse->id)->delete();

                foreach ($new_retail_warehouse_qty as $key => $value) {
                    $retail_warehouse_qty = new RetailWarehouseQty();
                    $retail_warehouse_qty->retail_warehouse_id = $retail_warehouse->id;
                    $retail_warehouse_qty->size_id = $key;
                    $retail_warehouse_qty->qty = $value;
                    $retail_warehouse_qty->save();
                }
            }
        }

        PurchaseMaster::where('id', $purchase_master_id )->update(['is_export' => 1]);
        return redirect()->back();
    }
}
