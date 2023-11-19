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
use Modules\Master\Entities\Warehouse;
use Modules\Order\Entities\Invoice;
use Modules\Order\Entities\InvoiceMaster;
use Modules\Order\Entities\InvoiceSubMaster;
use Modules\Order\Entities\OrderMaster;
use Modules\Order\Entities\Picklist;
use Modules\Order\Entities\PicklistMaster;
use Modules\Order\Entities\PicklistSubMaster;
use Modules\Order\Entities\PublishPicklistMaster;
use Modules\Product\Entities\ProductMaster;
use Modules\Product\Entities\ProductSubMaster;
use Modules\Retail\Entities\InvoiceDifferenceSubMaster;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{


    public function index()
    {
        $data['start_date']= Carbon::now()->startOfMonth()->toDateString();
        $data['end_date']= Carbon::now()->toDateString();
        return view('order::invoice.index',$data);
    }

    public function invoiceListing(Request $request){
        if ($request->ajax()) {
            $data = InvoiceMaster::leftjoin('corporate_profiles', 'corporate_profiles.id','=','invoice_masters.client_id')
            ->leftjoin('taxes', 'taxes.id','=','invoice_masters.tax_id')
            ->select('invoice_masters.*','corporate_profiles.name as corporate_name');

            if(!empty($request->from_date)) {

                $data =  $data->whereBetween('invoice_masters.created_at', array($request->from_date, Carbon::parse($request->to_date)->endOfDay()));

            }
            return Datatables::of($data->get())
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route('picklist.invoice.view',['id'=>$row->id]). '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    return $actionBtn;
                })
                ->rawColumns(['view', 'action'])
                ->make(true);
        }
    }

    public function picklistInvoice(Request $request)
    {
        $data['invoice_data'] = null;
        if ($request->input("id") != null) {
            $data['invoice_data'] = PicklistMaster::with(['warehouse', 'corporate_profiles' => function ($qu) {
                $qu->with('discounts', 'commissions', 'billing_states');
            }, 'order_master', 'detail' =>
            function ($q) {
                $q->with('child', 'product', 'color');
            }])->where('id', $request->id)->first();
            $margins= $data['invoice_data']->corporate_profiles->first(['A','B','C','D']) ;
      
            $detaill = [];
            foreach ($data['invoice_data']->detail as $det) {
                $product_price = ProductSubMaster::where('product_master_id', $det->product_id)->where('color_id', $det->color_id)->first();
                
              
                switch ($product_price->margin) {
                    case "A":
                       $margin_percent = $margins->A;
                      break;
                    case "B":
                        $margin_percent = $margins->A;

                      break;
                    case "C":
                        $margin_percent = $margins->A;

                      break;
                     case "D":
                        $margin_percent = $margins->A;

                    default:
                      $margin_percent = 0;
                  }

                
                $cal = ($product_price->mrp * $margin_percent) / 100;
                $detail['product_id'] = $det->product_id;
                $detail['product_name'] = $det->product->product_code;
                $detail['color_id'] = $det->color_id;
                $detail['color_name'] = $det->color->color_code;
                $detail['cs'] = $det->child->pluck('qty', 'size_id');
                $detail['per_qty'] = $product_price->mrp - $cal;
                $detail['totalq'] = array_sum($detail['cs']->toArray());
                $detail['total_price'] = $detail['totalq'] * $detail['per_qty'];
                array_push($detaill, $detail);
            }
            $data['child'] = $detaill;
           
            $grant_total = 0;
            foreach ($data['child'] as $ch) {
                $grant_total += $ch['total_price'];
            }
            $data['grant_total'] = $grant_total;
            $cal_dis=$data['grant_total']*$data['invoice_data']->corporate_profiles->discounts->percent/100;
            
            $data['amtAfterDiscount']=$cal_dis;
            $data['amtAfterDiscountt']=$data['grant_total']-$cal_dis;
            $data['picklist_master_id']=$request->id;
        }

        $data['warehouses'] = Warehouse::where('status', 'Active')->where('type', 'Finished')->get();
        $data['default_warehouse'] = Warehouse::where('type', 'Finished')->where('default_status', 1)->first();
        $data['tax'] = Tax::all();
        $data['discount'] = Discount::all();
        $data['sizes'] = Size::get();
        $data['orders'] = OrderMaster::get();
        $data['products'] = ProductMaster::where('check_audit', 0)->get();
        $data['states'] = State::all();
        $data['plucksize']=Size::pluck('size','id');

        $number = InvoiceMaster::select('invoice_no')->get()->last();
        $data['invoiceNumber'] = $number ? $number->invoice_no + 1 : 1;

        return view('order::invoice.picklistinvoice', $data);
    }

    public function moveToInvoice(Request $request)
    {
        $data = json_decode($request->data, true);
       
        if ($data['regular'] == 0) {
            $invoice_master = new InvoiceMaster();
            $invoice_master->warehouse_id = $data['warehouse_id'];
            $invoice_master->invoice_no = $data['invoiceNumber'];
            $invoice_master->regular = $data['regular'];
            $invoice_master->date = $data['invoiceDate'];
            $invoice_master->client_id = $data['client_id'];
            $invoice_master->order_id = null;
            $invoice_master->picklist_id = null;
            $invoice_master->tax_id = $data['tax_id'];
            $invoice_master->total_pcs = $data['total_pcs'];
            $invoice_master->discount = $data['discount'];
            $invoice_master->discount_price = $data['discount_price'];
            $invoice_master->tax_price = $data['tax_price'];
            $invoice_master->sub_total = $data['sub_total'];
            $invoice_master->grand_total = $data['grant_total'];
            $invoice_master->save();

            foreach ($data['child'] as $detail) {
                $invoice_sub_master = new InvoiceSubMaster();
                $invoice_sub_master->invoice_master_id = $invoice_master->id;
                $invoice_sub_master->color_id = $detail['color_id'];
                $invoice_sub_master->product_id = $detail['product_id'];
                $invoice_sub_master->qty = $detail['totalq'];
                $invoice_sub_master->per_qty = $detail['per_qty'];
                $invoice_sub_master->total = $detail['total_price'];
                $invoice_sub_master->save();

                if( $data['picklist_master_id'] > 0){
                    $picklist_sub_master_id=PicklistSubMaster::where('picklist_master_id',$data['picklist_master_id'])->where('color_id',$detail['color_id'])->where('product_id',$detail['product_id'])->first()->id;
                    $picklist_qty=Picklist::where('picklist_sub_master_id', $picklist_sub_master_id)->pluck('qty','size_id');
                    $new_picklist_qty=[];
                    foreach($picklist_qty as $pkey => $pvalue){
                        $new_picklist_qty[$pkey]= $pvalue - $detail['cs'][$pkey];
                    }
                    Picklist::where('picklist_sub_master_id', $picklist_sub_master_id)->delete();
                      foreach ($new_picklist_qty as $npkey => $npval) {
                        $picklist = new Picklist();
                        $picklist->picklist_sub_master_id = $picklist_sub_master_id;
                        $picklist->size_id = $npkey;
                        $picklist->qty = $npval;
                        $picklist->save();
                    }
                }else{
                    $finished_warehouse_id=FinishedWarehouse::where('warehouse_id',$data['warehouse_id'])->where('product_master_id', $detail['product_id'])->where('color_id',$detail['color_id'])->first()->id;
                    $finished_warehouse_qty=FinishedWarehouseQty::where('finished_warehouse_id',$finished_warehouse_id)->pluck('qty','size_id');
                    $new_finished_warehouse_qty=[];
                    foreach($finished_warehouse_qty as $fkey => $fvalue){
                        $new_finished_warehouse_qty[$fkey]= $fvalue - $detail['cs'][$fkey];
                    }
                    FinishedWarehouseQty::where('finished_warehouse_id',$finished_warehouse_id)->delete();
                    foreach ($new_finished_warehouse_qty as $nfkey => $nfval) {
                        $finished_warehouse = new FinishedWarehouseQty();
                        $finished_warehouse->finished_warehouse_id = $finished_warehouse_id;
                        $finished_warehouse->size_id = $nfkey;
                        $finished_warehouse->qty = $nfval;
                        $finished_warehouse->save();
                    }
                }
                foreach ($detail['cs'] as $key => $val) {
                    $invoice = new Invoice();
                    $invoice->invoice_sub_master_id = $invoice_sub_master->id;
                    $invoice->size_id = $key;
                    $invoice->qty = $val;
                    $invoice->save();
                }
            }
        }
        session()->flash('message', 'Invoice Create Successfully.');
        return redirect(route('picklist.invoice.index'));
    }
    
    public function view($id)
    {
        $data['sizes'] = Size::get();
        $data['invoice'] = InvoiceMaster::with(['client','warehouse','tax','detail' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->get();
        }])->where('id', $id)->first();
   
        return view('order::invoice.view', $data);
    }

    public function differenceIndex()
    {
      
        return view('order::invoice.differenceindex');
    }

    public function invoiceDifferenceListing(Request $request){
        if ($request->ajax()) {
            $data = InvoiceMaster::whereHas('invoiceDifferenceSubMaster')->with('tax','client')->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route('picklist.differenceinvoice.view',['id'=>$row->id]). '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    return $actionBtn;
                })
                ->rawColumns(['view', 'action'])
                ->make(true);
        }
    }

    public function viewInvoiceDifference($id){

        $data['sizes'] = Size::get();
        $data['invoice'] = InvoiceMaster::whereHas('invoiceDifferenceSubMaster')->with(['client','warehouse','tax','invoiceDifferenceSubMaster' => function ($detail) {
            $detail->with(['product', 'color'])
                ->with('child')->get();
        }])->where('id', $id)->first();
   
        return view('order::invoice.differenceView', $data);
    }
}
