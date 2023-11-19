<?php

namespace Modules\Product\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Exception;
use Illuminate\Http\Request;
use Modules\Master\Entities\Ean;
use Modules\Master\Entities\Fit;
use Modules\Master\Entities\Hsn;
use Modules\Master\Entities\Size;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Color;
use Modules\Master\Entities\Style;
use Illuminate\Support\Facades\Log;
use Modules\Master\Entities\Fabric;
use Modules\Master\Entities\Gender;
use Modules\Master\Entities\Margin;
use Modules\Product\Entities\Product;
use Modules\Master\Entities\Collection;
use Illuminate\Support\Facades\Redirect;
use Modules\Master\Entities\MainCategory;
use Modules\Product\Entities\ProductMaster;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;
use Modules\Master\Entities\Composition;
use Modules\Master\Entities\CuttingPlan;
use Modules\Master\Entities\Season;
use Modules\Master\Entities\SubCategory;
use Modules\Master\Entities\SubSubCategory;
use Modules\Order\Entities\Audit;
use Modules\Order\Entities\AuditMaster;
use Modules\Order\Entities\AuditSubMaster;
use Modules\Product\Entities\ProductSubMaster;
use Yajra\DataTables\Facades\DataTables;




class ProductController extends Controller
{
    function __construct()
    {
      
    }

    public function index()
    {
        $data['main_category'] = MainCategory::all();
        $data['fits'] = Fit::all();
        return view('product::index', $data);
    }

    public function ProductListing(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductSubMaster::with('parent', 'color');
            if($request->main_category != 'Select' && $request->main_category != null &&  $request->category != null && $request->subcategory != null && $request->sub_sub_category != null && $request->fit != 'Select' && $request->fit != null){
                $data =  $data->where('product_sub_masters.main_category_id',$request->main_category)->whereIn('product_sub_masters.category_id', $request->category)->whereIn('product_sub_masters.sub_category_id', $request->subcategory)->whereIn('product_sub_masters.sub_sub_category_id', $request->sub_sub_category)->where('product_sub_masters.fit_id', $request->fit);
            }
            else if($request->main_category != 'Select' && $request->main_category != null &&  $request->category != null && $request->subcategory != null && $request->sub_sub_category != null){
                $data =  $data->where('product_sub_masters.main_category_id',$request->main_category)->whereIn('product_sub_masters.category_id', $request->category)->whereIn('product_sub_masters.sub_category_id', $request->subcategory)->whereIn('product_sub_masters.sub_sub_category_id', $request->sub_sub_category);
            }
            else if($request->main_category != 'Select' && $request->main_category != null &&  $request->category != null && $request->subcategory != null && $request->fit != 'Select' && $request->fit != null){
                $data =  $data->where('product_sub_masters.main_category_id',$request->main_category)->whereIn('product_sub_masters.category_id', $request->category)->whereIn('product_sub_masters.sub_category_id', $request->subcategory)->where('product_sub_masters.fit_id', $request->fit);
            }
            else if($request->main_category != 'Select' && $request->main_category != null &&  $request->category != null && $request->subcategory != null){
                $data =  $data->where('product_sub_masters.main_category_id',$request->main_category)->whereIn('product_sub_masters.category_id', $request->category)->whereIn('product_sub_masters.sub_category_id', $request->subcategory);
            }
            else if($request->main_category != 'Select' && $request->main_category != null &&  $request->category != null && $request->fit != 'Select' && $request->fit != null) {
                $data =  $data->where('product_sub_masters.main_category_id',$request->main_category)->whereIn('product_sub_masters.category_id', $request->category)->where('product_sub_masters.fit_id', $request->fit);          
            }
            else if($request->main_category != 'Select' && $request->main_category != null &&  $request->category != null ) {
                $data =  $data->where('product_sub_masters.main_category_id',$request->main_category)->whereIn('product_sub_masters.category_id', $request->category);            
            }
            else if($request->main_category != 'Select' && $request->main_category != null &&  $request->fit != 'Select' && $request->fit != null) {
                $data =  $data->where('product_sub_masters.main_category_id',$request->main_category)->where('product_sub_masters.fit_id', $request->fit);            
            }
            else if($request->main_category != 'Select' && $request->main_category != null) {
                $data =  $data->where('product_sub_masters.main_category_id',$request->main_category);            
            }
            return Datatables::of($data->get())
                ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route('product.edit',['id'=>$row->id]). '"  type="submit"><svg
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                </svg></a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create(Request $request)
    {
        $permission = 'product.add';
        if(!$request->user()->can($permission)){
            return Redirect::back()->withErrors(['msg' => 'YOU HAVE NOT THE RIGHT PERMISSIONS TO ADD PRODUCT.']);
        }

        $data['gender'] = Gender::all();
        $data['fabric'] = Fabric::all();
        $data['style'] = Style::all();
        $data['color'] = Color::all();
        $data['sizes'] = Size::all();
        $data['season'] = Season::all();
        $data['ean'] = Ean::all();
        $data['hsn'] = Hsn::all();
        // $data['margin'] = Margin::all();
        $data['fit'] = Fit::all();
        $data['main_category'] = MainCategory::all();
        $data['compositions'] = Composition::all();

        return view('product::create', $data);
    }


    public function store(Request $request)
    {
       
        $request->validate([
            'gender' => 'required',
            'mrp' => 'required',
            'fabric_code' => 'required',
            'style_code' => 'required',
            'color_code' => 'required',
            'margin_code' => 'required',
            'hsn_code' => 'required',
            'ean_prefix' => 'required',
            'season_name' => 'required',
            'composition_name' => 'required',
            'cost_price' => 'required',
            'fit_id' => 'required',
            'description' => 'required',
            'main_category' => 'required',
            'category' => 'required',
            'subcategory' => 'required',
            'subsubcategory' => 'required',
            'image2' => 'required|image',
            'image1' => 'required|image'
        ]);
        $prefix = Ean::where('id',$request->ean_prefix)->first()->prefix;

        if ($files = $request->file('image1')) {
        
            $image1 = time() . rand(1, 100) . '.' . $files->getClientOriginalName();
            $files->move('ProductImage', $image1);
        }
        if ($file2 = $request->file('image2')) {
            
            $image2 = time() . rand(1, 100) . '.' . $file2->getClientOriginalName();
            $file2->move('ProductImage', $image2);
        }

        $sizes = Size::all();

        $G = Gender::where('id', $request->gender)->select('short_form')->first();
        $F = Fabric::where('id', $request->fabric_code)->select('code')->first();
        $S = Style::where('id', $request->style_code)->select('code')->first();
        $Color = Color::where('id', $request->color_code)->select('color_code')->first();
        if (ProductMaster::where('product_code', $G->short_form . $F->code . $S->code)->exists()) {

            $product_master_id = ProductMaster::where('product_code', $G->short_form . $F->code . $S->code)->first();

            if (ProductSubMaster::where('color_id', $request->color_code)->where('product_master_id', $product_master_id->id)->exists()) {
                return Redirect::back()->withErrors(['msg' => 'Same Product is already exist with this color']);
            } else {
                $product_sub_master = new ProductSubMaster();
                $product_sub_master->product_master_id = $product_master_id->id;
                $product_sub_master->gender_id = $request->gender;
                $product_sub_master->fabric_id  = $request->fabric_code;
                $product_sub_master->style_id = $request->style_code;
                $product_sub_master->color_id = $request->color_code;
                $product_sub_master->composition_id = $request->composition_name;
                $product_sub_master->margin = $request->margin_code;
                $product_sub_master->ean_id = $request->ean_prefix;
                $product_sub_master->hsn_id = $request->hsn_code;
                $product_sub_master->season_id = $request->season_name;
                $product_sub_master->mrp = $request->mrp;
                $product_sub_master->cost_price = $request->cost_price;
                $product_sub_master->fit_id = $request->fit_id;
                $product_sub_master->description = $request->description;
                $product_sub_master->type = $request->type_check;
                $product_sub_master->main_category_id = $request->main_category;
                $product_sub_master->category_id = $request->category;
                $product_sub_master->sub_category_id = $request->subcategory;
                $product_sub_master->sub_sub_category_id = $request->subsubcategory;
                $product_sub_master->image1 =  $image1;
                $product_sub_master->image2 =  $image2;

                if ($product_sub_master->save()) {

                    foreach ($sizes as $size) {
                        // $even_sum = 0;
                        // $even_sum_three = 0;
                        // $odd_sum = 0;
                        // $total_sum = 0;
                        // $next_ten = 0;
                        $ean_number = Product::select('ean_code')->get()->last();
                        $ean = $ean_number ? str_pad((int)$ean_number->ean_code + 1, 5, '0', STR_PAD_LEFT) : str_pad(1, 5, '0', STR_PAD_LEFT);
                        Product::create([
                            'product_sub_master_id' => $product_sub_master->id,
                            'size' => $size->id,
                            'color_code' => $Color->color_code,
                            'ean_code' => $ean 
                            
                        ]);
                    }
                }
                session()->flash('message', 'Product Add Successfully.');
                return redirect(route('product.index'));
            }
        } else {
            $product_master = new ProductMaster();
            $product_master->product_code = $G->short_form . $F->code . $S->code;
            if ($product_master->save()) {
                $product_sub_master = new ProductSubMaster();
                $product_sub_master->product_master_id = $product_master->id;
                $product_sub_master->gender_id = $request->gender;
                $product_sub_master->fabric_id  = $request->fabric_code;
                $product_sub_master->style_id = $request->style_code;
                $product_sub_master->color_id = $request->color_code;
                $product_sub_master->composition_id = $request->composition_name;
                $product_sub_master->margin = $request->margin_code;
                $product_sub_master->ean_id = $request->ean_prefix;
                $product_sub_master->hsn_id = $request->hsn_code;
                $product_sub_master->season_id = $request->season_name;
                $product_sub_master->mrp = $request->mrp;
                $product_sub_master->cost_price = $request->cost_price;
                $product_sub_master->fit_id = $request->fit_id;
                $product_sub_master->description = $request->description;
                $product_sub_master->type = $request->type_check;
                $product_sub_master->main_category_id = $request->main_category;
                $product_sub_master->category_id = $request->category;
                $product_sub_master->sub_category_id = $request->subcategory;
                $product_sub_master->sub_sub_category_id = $request->subsubcategory;
                $product_sub_master->image1 =  $image1;
                $product_sub_master->image2 =  $image2;
                if ($product_sub_master->save()) {
                    foreach ($sizes as $size) {
                        // $even_sum = 0;
                        // $even_sum_three = 0;
                        // $odd_sum = 0;
                        // $total_sum = 0;
                        // $next_ten = 0;
                        $ean_number = Product::select('ean_code')->get()->last();
                        $ean = $ean_number ? str_pad((int)$ean_number->ean_code + 1, 5, '0', STR_PAD_LEFT) : str_pad(1, 5, '0', STR_PAD_LEFT);
                      
                        Product::create([
                            'product_sub_master_id' => $product_sub_master->id,
                            'size' => $size->id,
                            'color_code' => $Color->color_code,
                            'ean_code' => $ean
                            
                        ]);
                    }
                }
            }
            session()->flash('message', 'Product Add Successfully.');
            return redirect(route('product.index'));
        }
    }


    public function show($id)
    {
        return view('product::show');
    }


    public function edit($id, Request $request)
    {

        $permission = 'product.view';
        if(!$request->user()->can($permission)){
            return Redirect::back()->withErrors(['msg' => 'YOU HAVE NOT THE RIGHT PERMISSIONS TO VIEW PRODUCT.']);
        }
        $data['gender'] = Gender::all();
        $data['fabric'] = Fabric::all();
        $data['style'] = Style::all();
        $data['color'] = Color::all();
        $data['sizes'] = Size::where('type', 'waist')->get();
        $data['sizetext'] = Size::where('type', 'top')->get();
        $data['ean'] = Ean::all();
        $data['hsn'] = Hsn::all();
        // $data['margin'] = Margin::all();
        $data['fit'] = Fit::all();
        $data['main_category'] = MainCategory::all();
        $data['compositions'] = Composition::all();

        $data['product_master'] = ProductSubMaster::where('id', $id)->with(['parent', 'category', 'main_child', 'main_child_sub_child', 'main_child_sub_sub_child', 'gender', 'fabric', 'style', 'color', 'season', 'fit', 'composition'])->first();
       
        return view('product::edit', $data);
    }


    public function update(Request $request, $id)
    {
      

        if ($files = $request->file('image1')) {
            if(file_exists(public_path('ProductImage'.'/'. $request->image11))){
               
                unlink(public_path('ProductImage'.'/'.$request->image11));
            }
            $image1 = time() . rand(1, 100) . '.' . $files->extension();
            $files->move('ProductImage', $image1);
        }
        else{
            $image1=$request->image11;
        }
     
        if ($file2 = $request->file('image2')) {
            if(file_exists(public_path('ProductImage'.'/'. $request->image22))){
               
                unlink(public_path('ProductImage'.'/'.$request->image22));
            }
            $image2 = time() . rand(1, 100) . '.' . $file2->getClientOriginalName();
            $file2->move('ProductImage', $image2);
        }else{
            $image2=$request->image22;
        }

        $product_master = ProductSubMaster::find($id);
        $product_master->composition_id = $request->composition_name;
        $product_master->margin = $request->margin_code;
        $product_master->hsn_id = $request->hsn_code;
        $product_master->mrp = $request->mrp;
        $product_master->cost_price = $request->cost_price;
        $product_master->fit_id = $request->fit_id;
        $product_master->description = $request->description;
        $product_master->main_category_id = $request->main_category;
        $product_master->category_id = $request->category;
        $product_master->sub_category_id = $request->subcategory;
        $product_master->sub_sub_category_id = $request->subsubcategory;
        $product_master->image1 =  $image1;
        $product_master->image2 =  $image2;
        $product_master->save();
        session()->flash('message', 'Product Update Successfully.');
        return redirect(route('product.index'));
    }


    public function delete($id)
    {
        ProductMaster::where('id', $id)->delete();
        return response()->json(['message' => 'data deleted']);
    }

    public function printBarcode($id)
    {
        $data['products'] = Product::with('sizes')->where('product_sub_master_id', $id)->get();

        return view('product::sizes', $data);
    }

    public function getBarcode($id)
    {
        $data['detail'] = Product::with(['sub_parent' => function ($query) {
            return $query->with(['parent', 'color', 'hsn']);
        }, 'sizes'])->where('id', $id)->first();
        // $pdf=PDF::loadView('product::generateBarcode',$data)->setOption(['defaultFont' => 'serif'])->setPaper('A4', 'landscape');
        // return $pdf->download('product.pdf');
        // return $pdf->render();

        return view('product::generateBarcode', $data);
    }

    public function createBarcode()
    {
        $data['sizes'] = Size::all();
        return view('product::productBarcode', $data);
    }

    public function productGetSubCategory(Request $request){
             $data = new SubCategory();
             $subcategory = $data->whereIn('category_id', $request->category)->get();
             if (!$subcategory->isEmpty()) {
                 return response()->json(['status' => 200, 'data' => $subcategory]);
             } else {
                 return response()->json(['status' => 400, 'data' => ""]);
             }      
    }

    public function productGetSubSubCategory(Request $request){
        $data = new SubSubCategory();
        $subsubcategory = $data->whereIn('sub_category_id', $request->sub_category)->get();
        if (!$subsubcategory->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $subsubcategory]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }   
    }
    
}
