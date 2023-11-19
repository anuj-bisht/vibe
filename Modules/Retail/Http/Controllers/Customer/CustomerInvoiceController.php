<?php

namespace Modules\Retail\Http\Controllers\Customer;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Corporate\Entities\Country;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Entities\CustomerInvoice as EntitiesCustomerInvoice;
use Modules\Customer\Entities\CustomerInvoiceMaster;
use Modules\Customer\Entities\CustomerInvoiceSubMaster;
use Modules\Master\Entities\Coupon;
use Modules\Master\Entities\Size;
use Modules\Retail\Entities\CustomerGoodReturn;
use Modules\Retail\Entities\CustomerGoodReturnMaster;
use Modules\Retail\Entities\CustomerGoodReturnSubMaster;
use Modules\Retail\Entities\CustomerInvoice;
use Modules\Retail\Entities\RetailWarehouse;
use Modules\Retail\Entities\RetailWarehouseQty;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;



class CustomerInvoiceController extends Controller
{
    public function index()
    {
        $data['start_date']= Carbon::now()->startOfMonth()->toDateString();
        $data['end_date']= Carbon::now()->toDateString();
        return view('retail::customer.index', $data);
    }

    public function invoiceListing(Request $request)
    {
        $retail = $request->session()->get('retail');
        if ($request->ajax()) {
            $data = CustomerInvoiceMaster::with('customer')->where('retail_id',   $retail->id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route('customer.invoice.view', ['id' => $row->id]) . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    $returnButton = '<a class="btn btn-sm global_btn_color"  href="' . route('retail.goodreturns', ['id' => $row->id]) . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file"><path d="M13 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V9z"></path><polyline points="13 2 13 9 20 9"></polyline></svg></a>';
                    if(CustomerGoodReturnMaster::where('customer_invoice_master_id', $row->id)->exists()){
                        $returndataButton = '<a class="btn btn-sm global_btn_color"  href="' . route('retail.goodreturndata', ['id' => $row->id]) . '"  type="submit">Return Data</a>';
                        return $actionBtn . " " . $returnButton . " " . $returndataButton;
                    }else{
                        return $actionBtn . " " . $returnButton;
                    }
                })
                ->rawColumns(['view', 'action'])
                ->make(true);
        }
    }


    public function create(Request $request)
    {
        $retail = Session::get('retail');
        $permission = 'Retail'.$retail->id.'.retailer.create.invoice';
        if($request->user()->can($permission)){
        $data['cash'] = CustomerInvoiceMaster::where('payment_mode', 'Cash')
        ->where('payment_status', 0)
        ->where('retail_id', $retail->id)
        ->select(DB::raw('date , sum(grant_total) as total'))
        ->groupBy('date')
        ->get();
        $number = CorporateProfile::where('id', $retail->id)->first()->cash_deliver;
        
        if(count($data['cash']) == $number || count($data['cash']) > $number){
            return abort(400);
        }
        $data['coupons'] = Coupon::where('status', 1)->get();
        $data['country'] = Country::all();
        $data['sizes'] = Size::all();
        $number = CustomerInvoiceMaster::select('invoice_no')->get()->last();
        $data['invoiceNumber'] = $number ? $number->invoice_no + 1 : 1;
        return view('retail::customer.createInvoice', $data);
    }else{
        abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
    }
    }


    public function moveToInvoice(Request $request)
    {
        
        $retail = Session::get('retail');
        $data = json_decode($request->data, true);

        $customer_invoice_master = new CustomerInvoiceMaster();
        $customer_invoice_master->invoice_no = $data['invoiceNumber'];
        $customer_invoice_master->date = $data['invoiceDate'];
        $customer_invoice_master->retail_id = $retail->id;
        $customer_invoice_master->customer_id = $data['customer_id'];
        $customer_invoice_master->total_pcs = $data['total_pcs'] ?? 0;
        $customer_invoice_master->discount = $data['discount_amount'] ?? 0;
        $customer_invoice_master->coupon_id = $data['coupon_id'];
        $customer_invoice_master->sub_total = $data['sub_total'];
        $customer_invoice_master->grant_total = $data['grandTotal'] ?? 0;
        $customer_invoice_master->payment_mode = $data['payment_mode'];
        $customer_invoice_master->payment_status = 0;

        $customer_invoice_master->save();

        foreach ($data['child'] as $detail) {
            $retail_warehouse_id = RetailWarehouse::where('client_id', $retail->id)->where('color_id',$detail['color_id'])->where('product_id',$detail['product_id'])->first()->id;
            $retail_warehouse_qty = RetailWarehouseQty::where('retail_warehouse_id',$retail_warehouse_id)->pluck('qty','size_id');
            $customer_invoice_sub_master = new CustomerInvoiceSubMaster();
            $customer_invoice_sub_master->customer_invoice_master_id = $customer_invoice_master->id;
            $customer_invoice_sub_master->color_id = $detail['color_id'];
            $customer_invoice_sub_master->product_id = $detail['product_id'];
            $customer_invoice_sub_master->qty = $detail['totalq'];
            $customer_invoice_sub_master->per_qty = $detail['per_qty'];
            $customer_invoice_sub_master->total = $detail['total_price'];
            $customer_invoice_sub_master->save();

            foreach ($detail['cs'] as $key => $val) {
                $customerinvoice = new EntitiesCustomerInvoice();
                $customerinvoice->customer_invoice_sub_master_id = $customer_invoice_sub_master->id;
                $customerinvoice->size_id = $key;
                $customerinvoice->qty = $val;
                $customerinvoice->save();
            }

            foreach ($detail['cs'] as $keyy => $valuee) {
                $new_retail_warehouse_qty[$keyy] = $retail_warehouse_qty[$keyy] - $valuee;
            } 
            RetailWarehouseQty::where('retail_warehouse_id',$retail_warehouse_id)->delete();
            foreach ($new_retail_warehouse_qty as $rwkey => $rwvalue) {
                $rwq = new RetailWarehouseQty();
                $rwq->retail_warehouse_id = $retail_warehouse_id;
                $rwq->size_id = $rwkey;
                $rwq->qty = $rwvalue;
                $rwq->save();
            } 
        }
        session()->flash('message', 'Invoice Create Successfully.');
        return redirect(route('retailcustomer.invoiceList'));
    }

    public function view($id, Request $request)
    {
        $ret = session::get('retail');
        $permission = 'Retail'.$ret->id.'.retailer.view.invoice';
        if($request->user()->can($permission)){
        $data['sizes'] = Size::get();
        $data['customer_invoice'] = CustomerInvoiceMaster::with(['customer', 'detail' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->get();
        }])->where('id', $id)->first();
        return view('retail::customer.view', $data);
    }
    else{
        abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
    }
    }

    public function search(Request $request)
    {
        $data = Customer::with(['country', 'state', 'city'])->where('mobile', 'LIKE', '%' . $request->q . '%')->get();
        if (!$data->isEmpty()) {
            return response()->json(['total_count' => count($data), 'incomplete_results' => true, 'items' => $data]);
        } else {
            return response()->json(['total_count' => 1, 'incomplete_results' => true, 'items' => [["is_create"  => true]]]);
        }
    }

    public function checkCouponLimit(Request $request)
    {
        $sendlimit = CustomerInvoiceMaster::where('customer_id', $request->customer_id)->where('coupon_id',  $request->coupon_id)->get();

        return response()->json(['status' => true,  'data' => $sendlimit->count()]);
    }

    public function checkCouponType(Request $request)
    {
        $retail = $request->session()->get('retail');
        $customer_id = $request->customer_id;
        $data = CustomerInvoiceMaster::join('coupons', 'coupons.id', '=', 'customer_invoice_masters.coupon_id')
            ->where('retail_id',  $retail->id)->where('customer_id', $customer_id)
            ->select('coupons.coupon_type')->get();
        $coupons_type = [];
        foreach ($data as $type) {
            array_push($coupons_type, $type['coupon_type']);
        }

        if (in_array('First Order', $coupons_type)) {
            return response()->json(['status' => true, 'data' => 1]);
        } else {
            return response()->json(['status' => false, 'data' => 0]);
        }
    }

    public function GoodReturn(Request $request)
    {
    
        $data['id'] = $request->id;
        $data['data'] = CustomerInvoiceMaster::where('id', $request->id)->first();
        $data['sizes'] = Size::all();
        return view('retail::customer.goodReturn', $data);
        
    }


    public function customerReturnStore(Request $request){
        $data= json_decode($request->data, true);

        $retail = Session::get('retail');

        $cgrm = new CustomerGoodReturnMaster();
        $cgrm->invoice_no = $data['invoiceNumber'];
        $cgrm->customer_id = $data['customer_id'];
        $cgrm->customer_invoice_master_id = $data['customer_invoice_master_id'];
        $cgrm->save();

        foreach ($data['child'] as $child) {
            $retail_warehouse_id = RetailWarehouse::where('client_id', $retail->id)->where('color_id',$child['color_id'])->where('product_id',$child['product_id'])->first()->id;
            $retail_warehouse_qty = RetailWarehouseQty::where('retail_warehouse_id',$retail_warehouse_id)->pluck('qty','size_id');
            $new_retail_warehouse_qty = [];
            $cgrsm = new CustomerGoodReturnSubMaster();
            $cgrsm->cgood_return_master_id = $cgrm->id;
            $cgrsm->color_id = $child['color_id'];
            $cgrsm->product_id = $child['product_id'];
            $cgrsm->total_qty = $child['totalq'];
            $cgrsm->per_qty = $child['per_qty'];
            $cgrsm->total_price = $child['total_price'];
            $cgrsm->save();
     
            foreach ($child['cs'] as $keyy => $valuee) {
                $new_retail_warehouse_qty[$keyy] = $retail_warehouse_qty[$keyy] + $valuee;
            }  

            RetailWarehouseQty::where('retail_warehouse_id',$retail_warehouse_id)->delete();
           
            foreach ($child['cs'] as $key => $value) {
                $cgr = new CustomerGoodReturn();
                $cgr->cgood_return_sub_master_id = $cgrsm->id;
                $cgr->size_id = $key;
                $cgr->qty = $value;
                $cgr->save();
            }  
            foreach ($new_retail_warehouse_qty as $rwkey => $rwvalue) {
                $rwq = new RetailWarehouseQty();
                $rwq->retail_warehouse_id = $retail_warehouse_id;
                $rwq->size_id = $rwkey;
                $rwq->qty = $rwvalue;
                $rwq->save();
            }     
            }

            return redirect(route('retailcustomer.invoiceList'));
    }

    public function goodReturnData(Request $request){
        $customer_invoice_master_id = $request->id;
        $data['sizes'] = Size::all();
        $data['returnData'] = CustomerGoodReturnMaster::with(['customers',  'detail' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child');
        }])->where('customer_invoice_master_id', $customer_invoice_master_id)->first();

        // return  $data['returnData'];
        // die;
        return view('retail::customer.returnData', $data);

    }
}
