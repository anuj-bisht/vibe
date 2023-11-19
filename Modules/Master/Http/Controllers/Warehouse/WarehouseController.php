<?php

namespace Modules\Master\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\CuttingPlan;
use Illuminate\Contracts\Support\Renderable;
use Modules\Master\Entities\CuttingPlanDetail;
use Modules\Master\Entities\CuttingPlanQuantity;
use Modules\Master\Entities\CuttingPlanQuantityLeft;
use Modules\Master\Entities\FinishedWarehouse;
use Modules\Master\Entities\FinishedWarehouseQty;
use Modules\Master\Entities\Size;
use Modules\Master\Entities\Unfinished;
use Modules\Master\Entities\UnfinishedMaster;
use Modules\Master\Entities\Warehouse;
use Illuminate\Support\Facades\Log;
use Modules\Master\Entities\Fit;
use Modules\Master\Entities\MainCategory;
use Yajra\DataTables\Facades\DataTables;


class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {   
        $data['all_warehouse']= Warehouse::all();
        $data['sizes']= Size::all();
        $data['main_category']=MainCategory::all();
        $data['fits']=Fit::all();
        $select= $data['all_warehouse'][0]->id;
        if ($request->input("warehouse") != null) {
            $select= $request->input("warehouse");
        }
        $data['select']= $select;
        return view('master::warehouse.index', $data);
    }
    public function Listing(Request $request)
    {
        if ($request->ajax()) {
            Log::alert('main_category', ['main_category'=>$request->main_category]);
            Log::alert('category', ['category'=>$request->category]);
            Log::alert('sub_category', ['sub_category'=>$request->sub_category]);
            Log::alert('sub_sub_category', ['sub_sub_category'=>$request->sub_sub_category]);


            $data =FinishedWarehouse::
            join("product_sub_masters", function($join){
                $join->on("product_sub_masters.product_master_id", "=", "finished_warehouses.product_master_id")
                ->on("product_sub_masters.color_id", "=", "finished_warehouses.color_id");
            })
            ->leftjoin('product_masters', 'product_masters.id','finished_warehouses.product_master_id')
            ->leftjoin('colors', 'colors.id','finished_warehouses.color_id')
            ->select('finished_warehouses.*','colors.color_code','product_masters.product_code', 'product_sub_masters.mrp as rate');
           if($request->warehouse_id != null && $request->main_category != null && $request->main_category != 'Select' && $request->category != null && $request->sub_category != null && $request->sub_sub_category != null && $request->fit != 'Select' && $request->fit != null){
            $data->where("warehouse_id", $request->warehouse_id)->where('product_sub_masters.main_category_id', $request->main_category)->whereIn('category_id',$request->category)->whereIn('sub_category_id',$request->sub_category)->whereIn('sub_sub_category_id',  $request->sub_sub_category)->where('fit_id', $request->fit);
           }
            else if($request->warehouse_id != null && $request->main_category != null && $request->main_category != 'Select' && $request->category != null && $request->sub_category != null && $request->sub_sub_category != null){
                $data->where("warehouse_id", $request->warehouse_id)->where('product_sub_masters.main_category_id', $request->main_category)->whereIn('category_id',$request->category)->whereIn('sub_category_id',$request->sub_category)->whereIn('sub_sub_category_id',  $request->sub_sub_category);
            }
            else if($request->warehouse_id != null && $request->main_category != null && $request->main_category != 'Select' && $request->category != null && $request->sub_category != null){
                $data->where("warehouse_id", $request->warehouse_id)->where('product_sub_masters.main_category_id', $request->main_category)->whereIn('category_id',$request->category)->whereIn('sub_category_id',$request->sub_category);
            }
            else if($request->warehouse_id != null && $request->main_category != null && $request->main_category != 'Select' && $request->category != null){
                $data->where("warehouse_id", $request->warehouse_id)->where('product_sub_masters.main_category_id', $request->main_category)->whereIn('category_id',$request->category);
            }
            else if($request->warehouse_id != null && $request->main_category != null && $request->main_category != 'Select'){
                $data->where("warehouse_id", $request->warehouse_id)->where('product_sub_masters.main_category_id', $request->main_category);
            }
            else if ($request->warehouse_id != null) {
                $data->where("warehouse_id", $request->warehouse_id);
            }
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('_p_code', function($row){
                    return $row->product_code;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route("warehouse.qty.view", ["id" => $row->id]) . '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    return $actionBtn;
                })
                ->addColumn('_rate', function($row){
                    return $row->rate;
                })
               
                ->addColumn('_26', function($row){ 
                    $child= $row->child->pluck('qty','size_id'); 
                    return $child[1];
                })
                ->addColumn('_28', function($row){ 
                    $child= $row->child->pluck('qty','size_id'); 
                    return $child[2];
                })
             
                ->addColumn('_30', function($row){ 
                    $child= $row->child->pluck('qty','size_id'); 
                    return $child[3];
                })
                ->addColumn('_32', function($row){ 
                    $child= $row->child->pluck('qty','size_id'); 
                    return $child[4];
                })
                ->addColumn('_S34', function($row){ 
                    $child= $row->child->pluck('qty','size_id'); 
                    return $child[5];
                })
                ->addColumn('_M36', function($row){ 
                    $child= $row->child->pluck('qty','size_id'); 
                    return $child[6];
                })
                ->addColumn('_L38', function($row){ 
                    $child= $row->child->pluck('qty','size_id'); 
                    return $child[7];
                })
                ->addColumn('_XL40', function($row){ 
                    $child= $row->child->pluck('qty','size_id'); 
                    return $child[8];
                })
                ->addColumn('_XXL42', function($row){ 
                    $child= $row->child->pluck('qty','size_id'); 
                    return $child[12];
                })
                ->addColumn('_XXXL44', function($row){ 
                    $child= $row->child->pluck('qty','size_id'); 
                    return $child[13];
                })
                ->addColumn('_46', function($row){ 
                    $child= $row->child->pluck('qty','size_id'); 
                    return $child[14];
                })
                ->addColumn('_48', function($row){ 
                    $child= $row->child->pluck('qty','size_id'); 
                    return $child[15];
                })
                ->addColumn('_total_amt', function($row){ 
                    $total_amt =  $row->rate*$row->sum;
                    return $total_amt;
                })
             
                ->filter(function ($query) {
                    if (request()->search['value']) {
                        $query->where('product_masters.product_code', 'like', "%" . request()->search['value'] . "%");
                    }
                })
                ->rawColumns(['view', 'action',])
                ->make(true);
        }

    }

    public function viewQTY($id){
    
        $data['size']=Size::all();
        $data['qtys']=FinishedWarehouseQty::where('finished_warehouse_id', $id)->get();
        return view('master::warehouse.qtys', $data);

    }


    public function unfinishedWarehouse()
    {

        $unfinished['sizes']=Size::all();
        $unfinished['data']=UnfinishedMaster::with(['color','product','child','productsubmaster'])->get();
      
        return view('master::warehouse.unfinished', $unfinished);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::warehouse.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'email'=>'required',
            'type'=>'required',
            'status'=>'required',
        ]);
        $warehouse=new Warehouse();
        $warehouse->name=$request->name;
        $warehouse->address=$request->address;
        $warehouse->contact=$request->contact;
        $warehouse->email=$request->email;
        $warehouse->type=$request->type;
        $warehouse->status=$request->status;
        $warehouse->save();
        session()->flash('message', 'Warehouse Create Successfully.');
        return redirect(route('warehouse.listing.index'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('master::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data['warehouse']=Warehouse::find($id);
        return view('master::warehouse.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'email'=>'required',
            'type'=>'required',
            'status'=>'required',
        ]);
        $warehouse=Warehouse::find($id);
        $warehouse->name=$request->name;
        $warehouse->address=$request->address;
        $warehouse->contact=$request->contact;
        $warehouse->email=$request->email;
        $warehouse->type=$request->type;
        $warehouse->status=$request->status;
        $warehouse->save();
        session()->flash('message', 'Detail update Successfully.');
        return redirect(route('warehouse.index'));
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

    public function exportProduct(){
        $data['sizes']=Size::all();
        $data['plucksize']=Size::pluck('size','id');
        $data['cutting_plan']=CuttingPlan::with(['detail'=>fn($query)=>$query->with(['product','color','season'])->with(['child','subChild'])->get()])->get();
        $data['default_warehouse'] = Warehouse::where('type', 'Finished')->where('default_status', 1)->first();
        $data['warehouses'] = Warehouse::where('status', 'Active')->where('type', 'Finished')->get();

        return view('master::warehouse.export', $data);

    }

    public function exportProductStore(Request $request){
        $data = json_decode($request->data, true);    
        $w_id=$data['warehouse_id'];
      
        foreach($data['child'] as $child){
         
            $unfinished_master = UnfinishedMaster::where('product_master_id',$child['product_id'])->where('color_id',$child['color_id'])->first();
            $finished_warehouse= FinishedWarehouse::where('warehouse_id',$w_id)->where('product_master_id',$child['product_id'])->where('color_id',$child['color_id'])->first();
        
            $unfinished_warehouse_qty = Unfinished::where('unfinished_master_id', $unfinished_master->id)->pluck('qty','size_id');

            if(isset($finished_warehouse)){
                $finished_warehouse_qty= FinishedWarehouseQty::where('finished_warehouse_id',$finished_warehouse->id)->pluck('qty','size_id');
            }

            if(!isset($finished_warehouse)){
                $finished_warehouse=new FinishedWarehouse();
                $finished_warehouse->warehouse_id=$data['warehouse_id'];
                $finished_warehouse->product_master_id=$child['product_id'];
                $finished_warehouse->color_id=$child['color_id'];
                $finished_warehouse->sum=(int)$child['totalq'];
                $finished_warehouse->date=now();

                if($finished_warehouse->save()){
                    foreach ($child['cs'] as $key => $value) {
                        $finished_warehouse_qty=new FinishedWarehouseQty();
                        $finished_warehouse_qty->finished_warehouse_id= $finished_warehouse->id;
                        $finished_warehouse_qty->size_id=$key;
                        $finished_warehouse_qty->qty=$value;
                        $finished_warehouse_qty->save();
                    }

                    $new_unfinished_warehouse_qty=[];
                    foreach ($unfinished_warehouse_qty as $key => $value) {
                        $new_unfinished_warehouse_qty[$key] =  $unfinished_warehouse_qty[$key] - (int)$child['cs'][$key];
                    }
                    UnfinishedMaster::where('product_master_id',$child['product_id'])->where('color_id',$child['color_id'])->update(['sum'=>array_sum($new_unfinished_warehouse_qty)]);
                    Unfinished::where('unfinished_master_id', $unfinished_master->id)->delete();

                    foreach($new_unfinished_warehouse_qty as $keyyy => $valueee){
                        $unfinished=new Unfinished();
                        $unfinished->unfinished_master_id=  $unfinished_master->id;
                        $unfinished->size_id=$keyyy;
                        $unfinished->qty=$valueee;
                        $unfinished->save();
                    }
                }
            }
            else{
          
           
                    $new_finished_qty=[];
                    foreach ($child['cs'] as $key => $value) {
                        $new_finished_qty[$key] = $finished_warehouse_qty[$key] + $value;
                    }
                    $new_unfinished_warehouse_qty=[];
                    foreach ($unfinished_warehouse_qty as $key => $value) {
                        $new_unfinished_warehouse_qty[$key] =  $unfinished_warehouse_qty[$key] - (int)$child['cs'][$key];
                    } 
                  
            
                    FinishedWarehouse::where('warehouse_id',$data['warehouse_id'])->where('product_master_id',$child['product_id'])->where('color_id',$child['color_id'])->update(['sum'=>array_sum($new_finished_qty)]);
                    FinishedWarehouseQty::where('finished_warehouse_id', $finished_warehouse->id)->delete();
                  
                    UnfinishedMaster::where('product_master_id',$child['product_id'])->where('color_id',$child['color_id'])->update(['sum'=>array_sum($new_unfinished_warehouse_qty)]);
                    Unfinished::where('unfinished_master_id', $unfinished_master->id)->delete();
                    foreach($new_finished_qty as $key => $value){
                        $finished_warehouse_qty=new FinishedWarehouseQty();
                        $finished_warehouse_qty->finished_warehouse_id= $finished_warehouse->id;
                        $finished_warehouse_qty->size_id=$key;
                        $finished_warehouse_qty->qty=$value;
                        $finished_warehouse_qty->save();
                    }

                    foreach($new_unfinished_warehouse_qty as $keyy => $valuee){
                        $unfinished=new Unfinished();
                        $unfinished->unfinished_master_id=  $unfinished_master->id;
                        $unfinished->size_id=$keyy;
                        $unfinished->qty=$valuee;
                        $unfinished->save();
                    }
                    
                

            }
        
        }
        session()->flash('message', 'Export Successfully.');

        return redirect(route('export.product.index'));
    }


    public function view($id){
        $data['sizes'] = Size::all();
        $data['audit'] = FinishedWarehouse::with(['product_masters', 'color','child'])->where('id', $id)->first();
        return view('master::warehouse.view', $data);
    }

    public function AllWarehouseListing(){
       $warehouse =  Warehouse::find(1);
 
       return $warehouse;
       die;



        // $data['warehouse']=Warehouse::getwarehouse()->get();
        // return view('master::warehouse.warehouseListing', $data);
    }

    public function changeDefaultStatus($id,$status){
        Warehouse::query()->update(['default_status' => 0]);
        Warehouse::where('id', $id)->update(['default_status'=>$status]);
        session()->flash('msg', 'Status Changed');
        return redirect()->back();
    }

  
}
