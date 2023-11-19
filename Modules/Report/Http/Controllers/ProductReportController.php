<?php

namespace Modules\Report\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\FinishedWarehouse;
use Modules\Master\Entities\MainCategory;
use Modules\Master\Entities\Size;
use Modules\Master\Entities\Warehouse;
use Modules\Product\Entities\ProductSubMaster;

class ProductReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
// return $request->input("sub_sub_category_id");
// die;
        $data['sizes'] = Size::all();
        $data['main_category'] = MainCategory::all();
        $data['all_warehouse'] = Warehouse::all();
        $select = $data['all_warehouse'][0]->id;
        if ($request->input("warehouse") != null) {
            $select = $request->input("warehouse");
        }
        $data['select'] = $select;


        $data['finished_data'] = FinishedWarehouse::Join('product_sub_masters AS b', function ($join) {
            $join->on('finished_warehouses.product_master_id', '=', 'b.product_master_id')
                ->on('finished_warehouses.color_id', '=', 'b.color_id');
        })->with(['product_masters', 'warehouses', 'color', 'child' => function ($q) {
            $q->pluck('qty', 'size_id');
        }])->select('finished_warehouses.*', 'b.main_category_id', 'b.id as psm_id', 'b.image1 as p_image1', 'b.mrp as p_mrp')->paginate(2);

        //warehouse_id, main_category , sub_category , sub_sub_category

        if ($request->input("warehouse_id") != null && $request->input("main_category_id") != "null"  &&  $request->input("sub_category_id") != "null"  && $request->input("sub_sub_category_id") != "null") {
            $mcid = $request->input("main_category_id");
            
            $data['finished_data'] = FinishedWarehouse::Join('product_sub_masters AS b', function ($join)  use ($mcid, $request){
                $join->on('finished_warehouses.product_master_id', '=', 'b.product_master_id')
                    ->on('finished_warehouses.color_id', '=', 'b.color_id')
                    ->where('b.main_category_id', $mcid)
                    ->whereIn('b.category_id', [$request->input('sub_category_id')])
                    ->whereIn('b.sub_category_id', [$request->input("sub_sub_category_id")]);

            })->with(['product_masters', 'warehouses', 'color', 'child' => function ($q) {
                $q->pluck('qty', 'size_id');
            }])->select('finished_warehouses.*', 'b.main_category_id', 'b.id as psm_id', 'b.image1 as p_image1', 'b.mrp as p_mrp')->where('finished_warehouses.warehouse_id', $request->input("warehouse_id"))->paginate(2);
        }

        //warehouse_id,  main_category , sub_category

        if ($request->input("warehouse_id") != null && $request->input("main_category_id") != "null"  &&  $request->input("sub_category_id") != "null" && $request->input("sub_sub_category_id") == "null") {
            $mcid = $request->input("main_category_id");

            $data['finished_data'] = FinishedWarehouse::Join('product_sub_masters AS b', function ($join)  use ($mcid, $request){
                $join->on('finished_warehouses.product_master_id', '=', 'b.product_master_id')
                    ->on('finished_warehouses.color_id', '=', 'b.color_id')
                    ->where('b.main_category_id', $mcid)
                    ->whereIn('b.category_id', [$request->input('sub_category_id')]);
            })->with(['product_masters', 'warehouses', 'color', 'child' => function ($q) {
                $q->pluck('qty', 'size_id');
            }])->select('finished_warehouses.*', 'b.main_category_id', 'b.id as psm_id', 'b.image1 as p_image1', 'b.mrp as p_mrp')->where('finished_warehouses.warehouse_id', $request->input("warehouse_id"))->paginate(2);
        }


        //warehouse_id,  main_category 
        if ($request->input("warehouse_id") != null && $request->input("main_category_id") != "null"   &&  $request->input("sub_category_id") == "null" && $request->input("sub_sub_category_id") == "null") {
            $mcid = $request->input("main_category_id");
           
            $data['finished_data'] = FinishedWarehouse::Join('product_sub_masters AS b', function ($join) use ($mcid) {
                $join->on('finished_warehouses.product_master_id', '=', 'b.product_master_id')
                    ->on('finished_warehouses.color_id', '=', 'b.color_id')
                    ->where('b.main_category_id', $mcid);
            })->with(['product_masters', 'warehouses', 'color', 'child' => function ($q) {
                $q->pluck('qty', 'size_id');
            }])->where('finished_warehouses.warehouse_id', $request->input("warehouse_id"))->select('finished_warehouses.*', 'b.main_category_id', 'b.id as psm_id', 'b.image1 as p_image1', 'b.mrp as p_mrp')->paginate(1);
        }


        // only warehouse id
        if ($request->input("warehouse_id") != null && $request->input("main_category_id") == "null"  &&  $request->input("sub_category_id") == "null" && $request->input("sub_sub_category_id") == "null") {
          
            $data['finished_data'] = FinishedWarehouse::Join('product_sub_masters AS b', function ($join) {
                $join->on('finished_warehouses.product_master_id', '=', 'b.product_master_id')
                    ->on('finished_warehouses.color_id', '=', 'b.color_id');
            })->with(['product_masters', 'warehouses', 'color', 'child' => function ($q) {
                $q->pluck('qty', 'size_id');
            }])->select('finished_warehouses.*', 'b.main_category_id', 'b.id as psm_id', 'b.image1 as p_image1', 'b.mrp as p_mrp')->where('finished_warehouses.warehouse_id', $request->input("warehouse_id"))->paginate(2);
        }


        if ($request->input("warehouse_id") != null) {
            $select = $request->input("warehouse_id");
        }
        $data['select'] = $select;

        $main_category_selected=null;
        if ($request->input("main_category_id") != null) {
            $main_category_selected = $request->input("main_category_id");
        }
        $data['main_category_selected'] = $main_category_selected;
        $sub_category_selected = null;
        if ( $request->input("sub_category_id") != null) {
            $sub_category_selected =  $request->input("sub_category_id");
        }
        $data['sub_category_selected'] = explode(",",$sub_category_selected);



        // $data['warehouse_name']=$request->input("warehouse_id");
        // $data['main_category_name']=$request->input("main_category_id");
      
        
        return view('report::productSummary', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('report::create');
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
    public function show($id)
    {
        return view('report::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('report::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
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
}
