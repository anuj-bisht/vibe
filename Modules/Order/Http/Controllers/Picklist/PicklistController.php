<?php

namespace Modules\Order\Http\Controllers\Picklist;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Corporate\Entities\State;
use Modules\Master\Entities\FinishedWarehouse;
use Modules\Master\Entities\FinishedWarehouseQty;
use Modules\Master\Entities\Size;
use Modules\Master\Entities\Tax;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderMaster;
use Modules\Order\Entities\OrderSubMaster;
use Modules\Order\Entities\Picklist;
use Modules\Order\Entities\PicklistMaster;
use Modules\Order\Entities\PicklistSubMaster;
use Modules\Order\Entities\PublishPicklist;
use Modules\Order\Entities\PublishPicklistMaster;
use Modules\Order\Entities\PublishPicklistSubMaster;
use Modules\Product\Entities\ProductMaster;
use Illuminate\Support\Facades\DB;
use Modules\Master\Entities\Warehouse;
use Modules\Product\Entities\ProductSubMaster;
use stdClass;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class PicklistController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data['start_date']= Carbon::now()->startOfMonth()->toDateString();
        $data['end_date']= Carbon::now()->toDateString();
        return view('order::picklist.picklist', $data);
    }

    public function picklistListing(Request $request)
    {
        if ($request->ajax()) {
            $data = PicklistMaster::leftjoin('states', 'states.id', '=', 'picklist_masters.state_id')
                ->leftjoin('corporate_profiles', 'corporate_profiles.id', '=', 'picklist_masters.client_id')
                ->leftjoin('order_masters', 'order_masters.id', '=', 'picklist_masters.order_id')
                ->select('picklist_masters.*', 'states.name as state_name', 'corporate_profiles.name as corporate_name');

            if (!empty($request->from_date)) {
                $data =  $data->whereBetween('picklist_masters.created_at', array($request->from_date, Carbon::parse($request->to_date)->endOfDay()));
            }
            return Datatables::of($data->get())
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route('picklist.view', ['id' => $row->id]) . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    $actionBtn = $actionBtn . '<a href="' . route('picklist.pdf', ['id' => $row->id]) . '"  class="btn btn-sm btn-primary">PDF</a>';
                    if ($row->status == 0) {
                        $actionBtn = $actionBtn . '<a href="javascript:void(0)"  class="btn btn-sm btn-danger">Pending</a>';
                    } else {
                        $actionBtn = $actionBtn . '<a href="' . route('picklist.invoice', ['id' => $row->id]) . '"  class="btn btn-sm btn-success">Generate Invoice</a>';
                    }
                    // <a href="{{$picklist->status == 0 ? 'javascript:void(0)' : route('picklist.invoice',['id'=>$picklist->id]) }}" class="{{$picklist->status == 0 ? 'btn btn-sm btn-danger' : 'btn btn-sm btn-success'}}">{{$picklist->status == 0 ? "Pending" : "Generate Invoice"}}</a>

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function picklistGenerator(Request $request)
    {
        $data['picklist_data'] = null;
        if ($request->input("id") != null) {
            $data['picklist_data'] = OrderMaster::with(['states', 'corporate_profiles', 'detail' => function ($q) {
                $q->with(['child', 'product', 'color']);
            }])->where('id', $request->input('id'))->first();
        }


        $data['states'] = State::get();
        $data['sizes'] = Size::all();
        $data['default_warehouse'] = Warehouse::where('type', 'Finished')->where('default_status', 1)->first();
        $data['warehouses'] = Warehouse::where('type', 'Finished')->get();
        $number = PicklistMaster::select('picklist_no')->get()->last();
        $data['picklistNumber'] = $number ? $number->picklist_no + 1 : 1;

        return view('order::picklist.create', $data);
    }

    public function moveToPicklist(Request $request)
    {
      
        $data = json_decode($request->data, true);

        $picklist_master = new PicklistMaster();
        $picklist_master->warehouse_id = $data['warehouse_id'];
        $picklist_master->picklist_no = $data['autoGeneratePicklistNo'];
        $picklist_master->state_id = $data['state_id'];
        $picklist_master->client_id = $data['client_id'];
        $picklist_master->order_id = $data['order_id'];
        $picklist_master->save();

        foreach ($data['totalData'] as $child) {

            $picklist_sub_master = new PicklistSubMaster();
            $picklist_sub_master->picklist_master_id = $picklist_master->id;
            $picklist_sub_master->color_id = $child['color_id'];
            $picklist_sub_master->product_id = $child['product_id'];
            $picklist_sub_master->total = array_sum($child['size']);
            $picklist_sub_master->save();

            foreach ($child['size'] as $key => $val) {
                $picklist = new Picklist();
                $picklist->picklist_sub_master_id = $picklist_sub_master->id;
                $picklist->size_id = $key;
                $picklist->qty = (int)$val ?? 0;
                $picklist->save();
            }
        };
        session()->flash('message', 'Picklist Create Successfully');

        return redirect(route('pick.index'));
    }
    public function picklistValidator()
    {
        $data['order_id'] = OrderMaster::get();
        $data['sizes'] = Size::all();
        $data['products'] = ProductMaster::all();
        return view('order::picklist.picklistvalidator', $data);
    }

    public function picklistView($id)
    {
        $data['sizes'] = Size::all();
        $data['picklist'] = PicklistMaster::with(['warehouse', 'corporate_profiles', 'order_master', 'detail' =>
        function ($q) {
            $q->with('child', 'product', 'color');
        }])->where('id', $id)->first();
        return view('order::picklist.picklistview', $data);
    }

    public function picklistUpdate(Request $request)
    {
        $old_pid = PicklistSubMaster::where('color_id', $request->attr['color_id'])->where('product_id', $request->attr['product_id'])->where('picklist_master_id', $request->attr['picklist_master_id'])->first()->id;
        $old_pqty = Picklist::where('picklist_sub_master_id', $old_pid)->pluck('qty', 'size_id');
        $ord_id = PicklistMaster::where('id', $request->attr['picklist_master_id'])->first()->order_id;
        $ord_sub_master_detail = OrderSubMaster::where('order_id', $ord_id)->where('color_id', $request->attr['color_id'])->where('product_id', $request->attr['product_id'])->first();
        $old_ord_qty = Order::where('order_sub_master_id', $ord_sub_master_detail->id)->pluck('qty', 'size_id');

        //   start calculation 
        $left_qty = [];
        foreach ($old_pqty as $key => $val) {
            $left_qty[$key] = $old_pqty[$key] - $request->ob[$key];
        }

        $new_ord_qty = [];
        foreach ($old_ord_qty as $keyy => $value) {
            $new_ord_qty[$keyy] = $old_ord_qty[$keyy] + $left_qty[$keyy];
        }

        // end calculation

        Order::where('order_sub_master_id', $ord_sub_master_detail->id)->delete();
        Picklist::where('picklist_sub_master_id', $old_pid)->delete();
        PicklistSubMaster::where('color_id', $request->attr['color_id'])->where('product_id', $request->attr['product_id'])->where('picklist_master_id', $request->attr['picklist_master_id'])->update(['total' => array_sum($request->ob)]);
        foreach ($request->ob as $key => $val) {
            $picklist = new Picklist();
            $picklist->picklist_sub_master_id = $old_pid;
            $picklist->size_id = $key;
            $picklist->qty = $val;
            $picklist->save();
        }

        OrderSubMaster::where('order_id', $ord_id)->where('color_id', $request->attr['color_id'])->where('product_id', $request->attr['product_id'])->update(['total' => array_sum($new_ord_qty)]);
        foreach ($new_ord_qty as $okey => $oval) {
            $order = new Order();
            $order->order_sub_master_id =  $ord_sub_master_detail->id;
            $order->size_id = $okey;
            $order->qty = $oval;
            $order->save();
        }


        PicklistSubMaster::where('color_id', $request->attr['color_id'])->where('product_id', $request->attr['product_id'])->where('picklist_master_id', $request->attr['picklist_master_id'])->update(['total' => array_sum($request->ob)]);
        return "success";
    }

    public function picklistPDF($id)
    {

        $data['sizes'] = Size::all();
        $data['picklist'] = PicklistMaster::with(['corporate_profiles' => function ($q) {
            $q->with('billing_citys', 'billing_states');
        }, 'detail' =>
        function ($q) {
            $q->with('child', 'product', 'color');
        }])->where('id', $id)->first();
        $pdf = PDF::loadView('order::picklist.pdfAttribute', $data)->setOption(['defaultFont' => 'serif'])->setPaper('A4', 'landscape');
        return $pdf->stream('picklist.pdf');
        return $pdf->render();
    }

    public function publishPicklist()
    {
        $publish_picklist['data'] = PublishPicklistMaster::with('states', 'corporate_profiles', 'order_master')->with(['detail' => function ($query) {
            $query->with('product', 'color', 'child')->get();
        }])->get();
        return view('order::picklist.publishpicklist', $publish_picklist);
    }



    public function publishPicklistView($id)
    {

        $publish_picklist['data'] = PublishPicklistMaster::with('states', 'corporate_profiles', 'order_master')->with(['detail' => function ($query) {
            $query->with('product', 'color', 'child')->get();
        }])->where('id', $id)->first();
        $publish_picklist['sizes'] = Size::all();
        return view('order::picklist.publishpicklistview', $publish_picklist);
    }
    public function storePicklistValidator(Request $request, $id)
    {


        DB::beginTransaction();
        try {
            $picklist_master_detail = PicklistMaster::where('id', $id)->first();
            $data = PicklistSubMaster::where('picklist_master_id', $id)->get();

            foreach ($data as $picklistData) {

                if (FinishedWarehouse::where('warehouse_id', $picklist_master_detail->warehouse_id)->where('product_master_id', $picklistData->product_id)->where('color_id', $picklistData->color_id)->exists()) {
                    $get_finishedwarehouse_detail = FinishedWarehouse::where('warehouse_id', $picklist_master_detail->warehouse_id)->where('product_master_id', $picklistData->product_id)->where('color_id', $picklistData->color_id)->first();
                    $order_detail = OrderSubMaster::where('order_id',  $picklist_master_detail->order_id)->where('product_id', $picklistData->product_id)->where('color_id', $picklistData->color_id)->first();
                    $picklist_qty = Picklist::where('picklist_sub_master_id', $picklistData->id)->pluck('qty', 'size_id');
                    $warehouse_qty = FinishedWarehouseQty::where('finished_warehouse_id', $get_finishedwarehouse_detail->id)->pluck('qty', 'size_id');
                    $order_qty = Order::where('order_sub_master_id', $order_detail->id)->pluck('qty', 'size_id');

                    $new_warehouse_qty = [];
                    $new_order_qty = [];

                    foreach ($warehouse_qty as $key => $val) {
                        $new_warehouse_qty[$key] = $warehouse_qty[$key] - $picklist_qty[$key];
                    }
                    FinishedWarehouse::where('id', $get_finishedwarehouse_detail->id)->update(['sum' => array_sum($new_warehouse_qty)]);

                    foreach ($order_qty as $key => $val) {
                        $new_order_qty[$key] = $order_qty[$key] - $picklist_qty[$key];
                    }
                    OrderSubMaster::where('id', $order_detail->id)->update(['total' => array_sum($new_order_qty)]);

                    $neg = array_filter($new_warehouse_qty, function ($x) {
                        return $x < 0;
                    });
                    $order_neg = array_filter($new_order_qty, function ($x) {
                        return $x < 0;
                    });

                    if (count($neg) > 0) {
                        return redirect()->back()->withErrors(['msg' =>  response()->json($neg)]);
                    }
                    if (count($order_neg) > 0) {
                        return redirect()->back()->withErrors(['msg' => json_encode($neg)]);
                    }
                    FinishedWarehouseQty::where('finished_warehouse_id', $get_finishedwarehouse_detail->id)->delete();

                    foreach ($new_warehouse_qty as $key => $val) {
                        $w_qty = new FinishedWarehouseQty();
                        $w_qty->finished_warehouse_id = $get_finishedwarehouse_detail->id;
                        $w_qty->size_id = $key;
                        $w_qty->qty = $val;
                        $w_qty->save();
                    }
                    Order::where('order_sub_master_id', $order_detail->id)->delete();

                    foreach ($new_order_qty as $key => $val) {
                        $o_qty = new Order();
                        $o_qty->order_sub_master_id = $order_detail->id;
                        $o_qty->size_id = $key;
                        $o_qty->qty = $val;
                        $o_qty->save();
                    }

                    PicklistMaster::where('id', $id)->update(['status' => 1]);
                }
            }
            session()->flash('message', 'Picklist Validate Successfully.');
            DB::commit();
        } catch (\Throwable $th) {

            Log::alert("message", $th->getMessage());
            DB::rollBack();
        }
        return redirect(route('pick.index'));
    }

    public function getClient(Request $request)
    {

        $data = CorporateProfile::with('order_masters')->whereRaw('id in (SELECT client_id FROM order_masters WHERE state_id=?)', [$request->id])->get();

        if (!$data->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }

    public function getOrder(Request $request)
    {
        $data = OrderMaster::where('client_id', $request->id)->where('state_id', $request->state_id)->get();
        if (!$data->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }

    public function getOrderData(Request $request)
    {
        $data = OrderMaster::with(['detail' => function ($query) {
            $query->with('child', 'product', 'color');
        }])->where('client_id', $request->client_id)->where('state_id', $request->state_id)->where('ord_id', $request->order_id)->get();
        if (!$data->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }

    public function getPicklistData(Request $request)
    {
        $order_data = OrderMaster::with(['detail' => function ($query) {
            $query->with('child', 'product', 'color');
        }])->where('ord_id', $request->order_id)->first();

        $products = [];
        foreach ($order_data->detail as $orderdata) {
            $product = $orderdata->toArray();
            if (FinishedWarehouse::where('warehouse_id', $request->warehouse_id)->where('product_master_id', $orderdata['product_id'])->where('color_id',  $orderdata['color_id'])->exists()) {
                $fw_id = FinishedWarehouse::where('warehouse_id', $request->warehouse_id)->where('product_master_id', $orderdata['product_id'])->where('color_id',  $orderdata['color_id'])->first();

                $fw_qty = FinishedWarehouseQty::where('finished_warehouse_id', $fw_id->id)->pluck('qty', 'size_id');


                foreach ($orderdata->child as $child) {

                    $product['size'][$child->size_id] = ($fw_qty[$child->size_id] - $child->qty) < 0 ? $fw_qty[$child->size_id] :  $child->qty;
                }
            } else {
                foreach ($orderdata->child as $child) {

                    $product['size'][$child->size_id] = 0;
                }
            }

            $products[] = $product;
        }

        if (isset($products)) {
            return response()->json(['status' => 200, 'data' => $products]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }
}
