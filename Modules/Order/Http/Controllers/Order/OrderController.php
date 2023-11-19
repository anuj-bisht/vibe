<?php

namespace Modules\Order\Http\Controllers\Order;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rules\Unique;
use Modules\Corporate\Entities\State;
use Modules\Master\Entities\Season;
use Modules\Master\Entities\Size;
use Modules\Order\Entities\Order;
use Modules\Order\Entities\OrderMaster;
use Modules\Order\Entities\OrderSubMaster;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;


class OrderController extends Controller
{
 
    public function index()
    {   
        $data['start_date']= Carbon::now()->startOfMonth()->toDateString();
        $data['end_date']= Carbon::now()->toDateString();
        return view('order::order.index', $data);
    }

    public function orderListing(Request $request){
        if ($request->ajax()) {
            $data =OrderMaster::leftjoin('corporate_profiles', 'corporate_profiles.id','=','order_masters.client_id')
            ->leftjoin('states', 'states.id','=','order_masters.state_id')
            ->select('order_masters.*','corporate_profiles.name as corporate_name','states.name as state_name');

         
            if(!empty($request->from_date) && !empty($request->client)) {
                $data =  $data->where('corporate_profiles.name','like','%'.$request->client.'%')->whereBetween('order_masters.created_at', array($request->from_date, Carbon::parse($request->to_date)->endOfDay()));            
            }
            else if(!empty($request->from_date)){
                $data =  $data->whereBetween('order_masters.created_at', array($request->from_date, Carbon::parse($request->to_date)->endOfDay()));
            }
            return Datatables::of($data->get())
                ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route("order.view", ["id" => $row->id]) . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    $actionBtn = $actionBtn.'<a href="' . route("picklist.generator", ["id" => $row->id]) . '"  class="edit btn btn-primary btn-sm">Picklist</a>';
                    return $actionBtn;
                })
                ->addColumn('date', function($data){
                    return Carbon::parse($data->created_at)->format('d-m-Y');
                })
                ->rawColumns(['action'])
                ->make(true);

        }

    }

    public function create()
    {
        $data['sizes']=Size::all();
        $data['states']=State::with(['corporate_profiles'])->get();
        $data['season_code']=Season::get();
        $order_no = OrderMaster::select('order_no')->get()->last();
        if(isset($order_no)){
            $s_no = $order_no->order_no + 1;
        }
        $data['order_serial_no'] = $order_no ? (int)$s_no : 0;
        return view('order::order.create', $data);
    }

 
    public function store(Request $request)
    {
        $data = json_decode($request->data, true);
        $str_arr = explode("-", $data['order_no']); 
       
        $order_master = new OrderMaster();
        $order_master->check_order= $data['checkorder'];
        $order_master->ord_id= $data['order_no'];
        $order_master->order_no=$str_arr[1];
        $order_master->state_id= $data['state'];
        $order_master->client_id= $data['client'];
        $order_master->save();
        
        foreach ($data['child'] as $child) {
            $order_sub_master = new OrderSubMaster();
            $order_sub_master->order_id = $order_master->id; 
            $order_sub_master->color_id = $child['color_id'];
            $order_sub_master->season_id = $child['season_id'];
            $order_sub_master->product_id = $child['product_id'];
            $order_sub_master->total = $child['totalq'];
            $order_sub_master->total_amount = $child['amount'];
            $order_sub_master->save();

            foreach($child['cs'] as $key => $val){
                    $order=new Order();
                    $order->order_sub_master_id = $order_sub_master->id;
                    $order->size_id = $key;
                    $order->qty = $val??0;
                    $order->save();
                }
        };
        session()->flash('message', 'Order Create Successfully.');
        return redirect(route('order.index'));
    }

    public function view($id)
    {
        $data['sizes'] = Size::all();

        $data['order'] = OrderMaster::with(['detail' => function ($detail) {
            $detail->with(['product','color'])
           ->with('child')->get();
        }])->where('id', $id)->first();

        return view('order::order.view', $data);
    }
    public function updateorderAttribute(Request $request, $id)
    {

        Order::where('order_sub_master_id',$id)->delete();
        $sizes=Size::all();
      
       OrderSubMaster::where('id',$id)->update([
        'total'=>array_sum($request->cutting_qtys)]);

        $qty=$request->cutting_qtys;

        foreach($sizes as $size){
                $order= new Order();
                $order->order_sub_master_id = $id;
                $order->size_id= $size->id;
                $order->qty=$qty[$size->id];
                $order->save();
        }
        session()->flash('message', 'Order Detail Update Successfully.');
        return redirect()->back();
    }
}
