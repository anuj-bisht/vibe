<?php

namespace Modules\Retail\Http\Controllers\Retail;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Size;
use Modules\Retail\Entities\RetailWarehouse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $ret = session::get('retail');
        $permission = 'Retail'.$ret->id.'.retailer.warehouse.view';
        if($request->user()->can($permission)){
        $data['sizes']=Size::get();
        $retail_session_data = $request->session()->get('retail');
        $data['id'] = $retail_session_data->id;
        return view('retail::product.index', $data);
        }else{
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS.');
        }
    }


    public function productListing(Request $request){
        if ($request->ajax()) {
            if (isset($request->retailer_id)) {
                $data =   RetailWarehouse::where('client_id',$request->retailer_id)
                        ->leftJoin('product_masters', 'product_masters.id', '=', 'retail_warehouses.product_id')
                        ->leftJoin('colors','colors.id','retail_warehouses.color_id')
                        ->select('retail_warehouses.*');
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('_product_code',function($row){
                    $product_code = $row->product->product_code;
                    return $product_code;
                })
                ->filterColumn('_product_code', function($query, $keyword) {
                    $sql = "product_masters.product_code  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('_color_code', function($query, $keyword) {
                    $sql = "colors.color_code  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
               
                ->addColumn('_color_code', function($row){
                    $color_code = $row->color->color_code;
                    return $color_code;
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
                
                
                ->rawColumns(['view'])
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
    public function show($id)
    {
        return view('retail::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('retail::edit');
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
