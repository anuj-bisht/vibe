<?php

namespace Modules\Retail\Http\Controllers\Retail;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Master\Entities\Size;
use Modules\Order\Entities\Invoice;
use Modules\Order\Entities\InvoiceMaster;
use Modules\Order\Entities\InvoiceSubMaster;
use Modules\Retail\Entities\InvoiceDifference;
use Modules\Retail\Entities\InvoiceDifferenceSubMaster;
use Modules\Retail\Entities\Purchase;
use Modules\Retail\Entities\PurchaseMaster;
use Modules\Retail\Entities\PurchaseSubMaster;
use Modules\Retail\Entities\RetailWarehouse;
use Modules\Retail\Entities\RetailWarehouseQty;
use Yajra\DataTables\Facades\DataTables;


class RetailController extends Controller
{
    public function changeRetailStatus(Request $request)
    {
        $retail_id = $request->retail_id;
        $retail_detail = CorporateProfile::where('id', $retail_id)->first();
        $request->session()->put('retail', $retail_detail);
    }
    public function index(Request $request)
    {
        $ret = session::get('retail');
        $permission = 'Retail'.$ret->id.'.mrn.pending.view';
        if($request->user()->can($permission)){
        $retail_session_data = $request->session()->get('retail');
        $data['id'] = $retail_session_data->id;
        return view('retail::purchase.index', $data);
        }else{
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
        }
    }


    public function purchaseListing(Request $request)
    {
        if ($request->ajax()) {
            if (isset($request->retailer_id)) {
                $data = InvoiceMaster::with('tax', 'client')->where('client_id', $request->retailer_id)->get();
            }

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route('purchase.invoice.view', ['id' => $row->id]) . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    return $actionBtn;
                })
                ->rawColumns(['view', 'action'])
                ->make(true);
        }
    }

  
    public function view($id, Request $request)
    {

        $ret = session::get('retail');
        $permission = 'Retail'.$ret->id.'.mrn.pending.view';
        if($request->user()->can($permission)){
        $purchase['sizes'] = Size::get();
        $invoice_data = InvoiceMaster::with(['client', 'warehouse', 'tax', 'detail' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->pluck('qty')->toArray();
        }])->where('id', $id)->get();

        $data = [];
        foreach ($invoice_data as $ind) {
            $detail = [];
            $detail['id'] = $ind['id'];
            $detail['is_export'] = $ind['is_export'];
            $detail['warehouse_id'] = $ind['warehouse_id'];
            $detail['invoice_no'] = $ind['invoice_no'];
            $detail['regular'] = $ind['regular'];
            $detail['date'] = $ind['date'];
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
            foreach ($ind['detail'] as $val) {
                $d = [];
                $d['id'] = $val['id'];
                $d['export'] = false;
                $d['invoice_master_id'] = $val['invoice_master_id'];
                $d['color_id'] = $val['color_id'];
                $d['product_id'] = $val['product_id'];
                $d['per_qty'] = $val['per_qty'];
                $d['qty'] = $val['qty'];
                $d['total'] = $val['total'];
                $d['product'] = $val['product'];
                $d['color'] = $val['color'];
                $d['cs'] = $val['child']->pluck('qty', 'size_id');
                array_push($detail['detail'], $d);
            }
            array_push($data, $detail);
        }

        $purchase['invoice'] = $data[0];

        return view('retail::purchase.view', $purchase);
    }
    else{
        abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
    }
    }
    public function store(Request $request)
    {
        $ret = session::get('retail');
        $permission = 'Retail'.$ret->id.'.mrn.pending.validate';
        if($request->user()->can($permission)){
        $data = json_decode($request->data, true);
        $p_m = new PurchaseMaster();
        $p_m->warehouse_id = $data['warehouse_id'];
        $p_m->invoice_no = $data['invoice_no'];
        $p_m->regular = $data['regular'];
        $p_m->date = $data['data'];
        $p_m->client_id = $data['client_id'];
        $p_m->tax_id = $data['tax_id'];
        $p_m->total_pcs = $data['total_pcs'];
        $p_m->discount = $data['discount'];
        $p_m->discount_price = $data['discount_price'];
        $p_m->tax_price = $data['tax_price'];
        $p_m->sub_total = $data['sub_total'];
        $p_m->grand_total = $data['grand_total'];
        $p_m->save();

        foreach ($data['child'] as $child) {
      
            $invoice_actual_qty = Invoice::where('invoice_sub_master_id', $child['id'])->pluck('qty', 'size_id');
            $invoice_difference_qty = [];
            foreach ($child['cs'] as $pkey => $pval) {
                $invoice_difference_qty[$pkey] =   $invoice_actual_qty[$pkey] - $pval;
            }
            $p_s_m = new PurchaseSubMaster();
            $p_s_m->purchase_master_id = $p_m->id;
            $p_s_m->color_id = $child['color_id'];
            $p_s_m->product_id = $child['product_id'];
            $p_s_m->qty = $child['qty'];
            $p_s_m->total = $child['total'];
            $p_s_m->save();

            $invoice_difference_sub_master = new InvoiceDifferenceSubMaster();
            $invoice_difference_sub_master->invoice_master_id = $data['invoice_id'];
            $invoice_difference_sub_master->color_id = $child['color_id'];
            $invoice_difference_sub_master->product_id = $child['product_id'];
            $invoice_difference_sub_master->save();

            $retail_warehouse = RetailWarehouse::where('client_id',  $data['client_id'])->where('product_id', $child['product_id'])->where('color_id', $child['color_id'])->first();
            if (isset($retail_warehouse)) {
                $retail_warehouse_qty = RetailWarehouseQty::where('retail_warehouse_id', $retail_warehouse->id)->pluck('qty', 'size_id');
            }
            if (!isset($retail_warehouse)) {
                $retail_warehouse = new RetailWarehouse();
                $retail_warehouse->client_id = $data['client_id'];
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

                RetailWarehouse::where('client_id',  $data['client_id'])->where('product_id', $child['product_id'])->where('color_id', $child['color_id'])->update(['sum' => array_sum($new_retail_warehouse_qty)]);
                RetailWarehouseQty::where('retail_warehouse_id', $retail_warehouse->id)->delete();

                foreach ($new_retail_warehouse_qty as $key => $value) {
                    $retail_warehouse_qty = new RetailWarehouseQty();
                    $retail_warehouse_qty->retail_warehouse_id = $retail_warehouse->id;
                    $retail_warehouse_qty->size_id = $key;
                    $retail_warehouse_qty->qty = $value;
                    $retail_warehouse_qty->save();
                }
            }

            foreach ($child['cs'] as $pkey => $pval) {
                $purchases = new Purchase();
                $purchases->purchase_sub_master_id = $p_s_m->id;
                $purchases->size_id = $pkey;
                $purchases->qty = $pval;
                $purchases->save();
            }


            foreach ($invoice_difference_qty as $inkey => $inval) {
                $invoice_difference = new InvoiceDifference();
                $invoice_difference->invoice_difference_sub_master_id = $invoice_difference_sub_master->id;
                $invoice_difference->size_id = $inkey;
                $invoice_difference->qty = $inval;
                $invoice_difference->save();
            }
        }

        return redirect(route('purchase.validated.listing'));
    }else{
        abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
    }
    }
    


}
