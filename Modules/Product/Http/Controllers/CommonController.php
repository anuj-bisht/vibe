<?php

namespace Modules\Product\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Master\Entities\Size;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Corporate\Entities\City;
use Modules\Corporate\Entities\State;
use Modules\Master\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Master\Entities\SubCategory;
use Modules\Master\Entities\CuttingRatio;
use Modules\Order\Entities\OrderSubMaster;
use Modules\Master\Entities\SubSubCategory;
use Modules\Product\Entities\ProductMaster;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Session;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Entities\CustomerInvoice;
use Modules\Customer\Entities\CustomerInvoiceSubMaster;
use Modules\Master\Entities\FinishedWarehouse;
use Modules\Product\Entities\ProductSubMaster;
use Modules\Master\Entities\FinishedWarehouseQty;
use Modules\Master\Entities\Season;
use Modules\Master\Entities\Unfinished;
use Modules\Master\Entities\UnfinishedMaster;
use Modules\Order\Entities\OrderMaster;
use Modules\Order\Entities\Picklist;
use Modules\Order\Entities\PicklistMaster;
use Modules\Order\Entities\PicklistSubMaster;
use Modules\Order\Entities\PublishPicklistMaster;
use Modules\Order\Entities\PublishPicklistSubMaster;
use Modules\Retail\Entities\RetailAudit;
use Modules\Retail\Entities\RetailWarehouse;
use Modules\Retail\Entities\RetailWarehouseQty;

class CommonController extends Controller
{


    public function getCategory($id)
    {
        $data = new Category();
        $category = $data->with('products')->where('main_category', $id)->get();
        if (!$category->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $category]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }


    public function getSubCategory($id)
    {
        $data = new SubCategory();
        $subcategory = $data->where('category_id', $id)->get();
        if (!$subcategory->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $subcategory]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getSubSubCategory($id)
    {
        $data = new SubSubCategory();
        $subsubcategory = $data->where('sub_category_id', $id)->get();
        if (!$subsubcategory->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $subsubcategory]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }


    public function getCuttingRatio($id)
    {
        $cutting_ratio = CuttingRatio::where('cutting_id', $id)->get();
        $total = CuttingRatio::where('cutting_id', $id)->sum('ratio');
        if (!$cutting_ratio->isEmpty()) {
            return response()->json(['status' => 200, 'data' => [$cutting_ratio, $total]]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getColorId($id)
    {
        $color = ProductSubMaster::with('color')->where('product_master_id', $id)->get();

        if (isset($color)) {
            return response()->json(['status' => 200, 'data' => $color]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }


    public function getWarehouseQty($wid, $cpid, $pid)
    {
        $qty = FinishedWarehouse::with('child')->where('warehouse_id', $wid)->where('cutting_plan_id', $cpid)->where('product_master_id', $pid)->first();

        if (isset($qty)) {
            return response()->json(['status' => 200, 'data' => $qty]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getBillingState($id)
    {
        $data = new State();
        $billing_country = $data->where('country_id', $id)->get();
        if (!$billing_country->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $billing_country]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getBillingCity($id)
    {
        $data = new City();
        $billing_state = $data->where('state_id', $id)->get();
        if (!$billing_state->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $billing_state]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }


    public function getDeliveryState($id)
    {
        $data = new State();
        $delivery_country = $data->where('country_id', $id)->get();
        if (!$delivery_country->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $delivery_country]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getDeliveryCity($id)
    {
        $data = new City();
        $delivery_state = $data->where('state_id', $id)->get();
        if (!$delivery_state->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $delivery_state]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getClientOrder($order_id)
    {
        $data = OrderSubMaster::with('child', 'color', 'product')->where('order_id', $order_id)->get();
        $array = [];
        for ($i = 0; $i < count($data); $i++) {
            $pr = $data[$i];
            $data[$i]->pickupList = FinishedWarehouseQty::whereIN('finished_warehouse_id', function ($query) use ($pr) {
                $query->select('id')->where('product_master_id', $pr->product_id)->where('color_id', $pr->color_id)->from("finished_warehouses");
            })->pluck('qty', 'size_id');

        }

        if (!$data->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function checkSeasonCode($data)
    {
        $season_id = Season::where('code', $data)->first()->id;
        $order_id = OrderSubMaster::where('season_id', $season_id)->exists();
        if ($order_id) {
            $id = OrderSubMaster::where('season_id', $season_id)->get()->last();
            $main_order_id = OrderMaster::where('id', $id->order_id)->first()->order_no;
            return response()->json(['status' => 201, 'data' => $main_order_id + 1]);
        } else {
            return response()->json(['status' => 200, 'data' => 1]);
        }
    }

    public function getPicklist($id)
    {
        $data = PicklistMaster::where('order_id', $id)->get();
        if (!$data->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getTotalPicklist($id)
    {
        $data = PicklistSubMaster::with('child', 'product', 'color')->where('picklist_master_id', $id)->get();
        if ($data) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getPicklistProduct($id)
    {
        $picklist_master_id = PicklistMaster::where('picklist_no', $id)->first()->id;
        $data = PicklistSubMaster::with('product', 'color')->where('picklist_master_id', $picklist_master_id)->get();

        if ($data) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getPicklistColor($picklist_id, $product_id)
    {
        $picklist_master_id = PicklistMaster::where('picklist_no', $picklist_id)->first()->id;
        $data = PicklistSubMaster::with('color')->where('picklist_master_id', $picklist_master_id)->where('product_id', $product_id)->get();
        if ($data) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getPicklistData($id, $warehouse_id, $picklist_id)
    {

        $data = PicklistMaster::with(['corporate_profiles', 'warehouse', 'detail' => function ($q) {
            $q->with('child', 'product', 'color');
        }])->where('warehouse_id', $warehouse_id)->where('order_id', $id)->where('status', 1)->where('picklist_no', $picklist_id)->first();

        if (isset($data)) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    //    public function getPublishedData($id){
    //     $data['discount']=PublishPicklistMaster::with(['corporate_profiles'=>function($query){
    //         $query->with('discounts');
    //     }])->where('id', $id)->first();
    //     $data['publish_data']=PublishPicklistSubMaster::with('product','color','child')
    //     ->where('p_picklist_master_id', $id)->get();
    //     if($data){     
    //         return response()->json(['status'=>200,'data'=>$data]);

    //     }else{
    //     return response()->json(['status'=>400,'data'=>""]);
    //     }
    //    }   

    public function getProductCode($id)
    {
        $data = ProductSubMaster::with('color')->where('product_master_id', $id)->get();
        if ($data) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getClient($id)
    {
        $data = CorporateProfile::with('discounts','commissions')->where('bstate_id', $id)->get();
        if ($data) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }

    public function getWarehouseProduct($warehouse_id)
    {

      
       $data=ProductMaster::whereRaw('id in (select product_master_id from finished_warehouses where warehouse_id = ?)',[$warehouse_id])->with('subproduct');

        // $data = ProductSubMaster::leftJoin("finished_warehouses", "finished_warehouses.product_master_id", "=", "product_sub_masters.product_master_id")->whereRaw("finished_warehouses.color_id = product_sub_masters.color_id")
        //     ->whereRaw("finished_warehouses.product_master_id = product_sub_masters.product_master_id")->where("finished_warehouses.warehouse_id", $warehouse_id)
        //     ->with(["child", "parent"])->select("finished_warehouses.*", "product_sub_masters.*");
        if ($data) {
            return response()->json(['status' => 200,  'data' => $data->get()]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getWarehouseProductColor($warehouse_id, $product_id)
    {
        $data = FinishedWarehouse::with('color')->where('warehouse_id', $warehouse_id)->where('product_master_id', $product_id)->get();
        if ($data) {
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getWarehouseProductColorQty($warehouse_id, $product_id, $color_id)
    {
        $data['finished_warehouse'] = FinishedWarehouse::with('color')->where('warehouse_id', $warehouse_id)->where('product_master_id', $product_id)->where('color_id', $color_id)->first();
        $data['qty'] = FinishedWarehouseQty::where('finished_warehouse_id', $data['finished_warehouse']->id)->pluck('qty', 'size_id');

        if ($data) {
            // return $data;
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function enableAudit($warehouse_id, $product_id, $color_id, $audit)
    {
        $data['finished_warehouse'] = FinishedWarehouse::where('warehouse_id', $warehouse_id)->where('product_master_id', $product_id)->where('color_id', $color_id)->update(['check_audit' => $audit]);
        // $data['finished_warehouse']=ProductMaster::where('id',$product_id)->update(['check_audit'=> $audit]);

        if ($data) {
            // return $data;
            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getSubCategoryForAudit($id)
    {
        $ids = explode(",", $id);
        $subcategory = SubCategory::with('products')->whereIn('category_id', $ids)->get();

        if (!$subcategory->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $subcategory]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getSubSubCategoryForAudit($id)
    {

        $sub_ids = explode(",", $id);

        $subsubcategory = SubSubCategory::whereIn('sub_category_id', $sub_ids)->get();

        if (!$subsubcategory->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $subsubcategory]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getSubSubSubCategoryForAudit($warehouse_id, $id)
    {
        $sub_sub_ids = explode(",", $id);

        $subsubsubcategory = ProductSubMaster::whereIn('product_sub_masters.sub_sub_category_id', $sub_sub_ids)->get();
        $new = [];
        foreach ($subsubsubcategory as $data) {
            array_push($new, FinishedWarehouse::with('product_masters', 'color')->where('warehouse_id', $warehouse_id)->where('product_master_id', $data->product_master_id)->where('color_id', $data->color_id)->first());
        }

        if (!$subsubsubcategory->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $new]);
        } else {
            return response()->json(['status' => 400, 'data' => ""]);
        }
    }

    public function getDataBySearch(Request $request)
    {

        $product_ean_no = $request->product_ean;
        $ean_code = substr($product_ean_no, 0, 7);
        $ean_no = substr($product_ean_no, 7, 5);
        $last_digit = substr($product_ean_no, -1);

        $digits = substr($product_ean_no,0,12);
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
        $even_sum_three = $even_sum * 3;
        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        $total_sum = $even_sum_three + $odd_sum;
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;


      
        if($product_ean_no != $ean_code.$ean_no.$check_digit){
             return response()->json(['status' => 404, 'message'=>'Wrong Barcode' ,'data' => []]);
        }
        $product_with_ean = [];
       
        /**
         * SELECT * FROM `product_sub_masters` LEFT JOIN products ON products.product_sub_master_id= product_sub_masters.id  WHERE  product_sub_masters.ean_id in (SELECT id FROM eans where prefix="ABCDEFG") AND products.ean_code="00001"
         */
        $data['product'] = ProductSubMaster::leftJoin("products", "products.product_sub_master_id", "=", "product_sub_masters.id")
            ->whereRaw("product_sub_masters.ean_id in (SELECT id FROM eans where prefix=?)", [$ean_code])
            ->where("products.ean_code", $ean_no)
            ->with(["color", "parent", "child"])
            ->select("product_sub_masters.*", DB::raw("products.size as product_size_id"))
            ->first();

        $data['qty'] = Unfinished::rightJoin("unfinished_master", "unfinished_master.id", "=", "unfinished.unfinished_master_id")
            ->where("unfinished_master.product_master_id", $data['product']->product_master_id)
            ->where("unfinished_master.color_id", $data['product']->color_id)
            ->where("unfinished.size_id", $data['product']->product_size_id)
            ->with('size')
            ->select("unfinished.*")->first();
        //    $data = [$product,$qty];


        if ($data['product']->product_master_id != null) {

            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }

    public function getDataBySearchh(Request $request)
    {
       
        $product_ean_no = $request->product_ean;
        $ean_code = substr($product_ean_no, 0, 7);
        $ean_no = substr($product_ean_no, 7, 5);

        $last_digit = substr($product_ean_no, -1);

        $digits = substr($product_ean_no,0,12);
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
        $even_sum_three = $even_sum * 3;
        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        $total_sum = $even_sum_three + $odd_sum;
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;

        
      
        if($product_ean_no != $ean_code.$ean_no.$check_digit){
             return response()->json(['status' => 404, 'message'=>'Wrong Barcode' ,'data' => []]);
        }
        $product_with_ean = [];
     
        /**
         * SELECT * FROM `product_sub_masters` LEFT JOIN products ON products.product_sub_master_id= product_sub_masters.id  WHERE  product_sub_masters.ean_id in (SELECT id FROM eans where prefix="ABCDEFG") AND products.ean_code="00001"
         */
        $data['product'] = ProductSubMaster::leftJoin("products", "products.product_sub_master_id", "=", "product_sub_masters.id")
            ->whereRaw("product_sub_masters.ean_id in (SELECT id FROM eans where prefix=?)", [$ean_code])
            ->where("products.ean_code", $ean_no)
            ->with(["color", "parent", "child"])
            ->select("product_sub_masters.*", DB::raw("products.size as product_size_id"))
            ->first();

            if(isset($request->picklist_master_id)){
                $data['qty'] = Picklist::rightJoin("picklist_sub_masters", "picklist_sub_masters.id", "=", "picklists.picklist_sub_master_id")
                ->where("picklist_sub_masters.product_id", $data['product']->product_master_id)
                ->where("picklist_sub_masters.color_id", $data['product']->color_id)
                ->where("picklist_sub_masters.picklist_master_id", $request->picklist_master_id)
                ->where("picklists.size_id", $data['product']->product_size_id)
                ->with('size')
                ->select("picklists.*")->first();
            }
            else{
                $data['qty'] = FinishedWarehouseQty::rightJoin("finished_warehouses", "finished_warehouses.id", "=", "finished_warehouse_qtys.finished_warehouse_id")
                ->where("finished_warehouses.product_master_id", $data['product']->product_master_id)
                ->where("finished_warehouses.color_id", $data['product']->color_id)
                ->where("finished_warehouses.warehouse_id", $request->warehouse_id)
                ->where('finished_warehouses.check_audit', 0)
                ->where("finished_warehouse_qtys.size_id", $data['product']->product_size_id)
                ->with('size')
                ->select("finished_warehouse_qtys.*")->first();
            }

        if ($data['product']->product_master_id != null) {

            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }


    public function getDataBySearchhh(Request $request)
    {
       
        $product_ean_no = $request->product_ean;
        $ean_code = substr($product_ean_no, 0, 7);
        $ean_no = substr($product_ean_no, 7, 5);

        $last_digit = substr($product_ean_no, -1);

        $digits = substr($product_ean_no,0,12);
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
        $even_sum_three = $even_sum * 3;
        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        $total_sum = $even_sum_three + $odd_sum;
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;

        
      
        if($product_ean_no != $ean_code.$ean_no.$check_digit){
             return response()->json(['status' => 404, 'message'=>'Wrong Barcode' ,'data' => []]);
        }
        $product_with_ean = [];
       
        /**
         * SELECT * FROM `product_sub_masters` LEFT JOIN products ON products.product_sub_master_id= product_sub_masters.id  WHERE  product_sub_masters.ean_id in (SELECT id FROM eans where prefix="ABCDEFG") AND products.ean_code="00001"
         */
        $data['product'] = ProductSubMaster::leftJoin("products", "products.product_sub_master_id", "=", "product_sub_masters.id")
            ->whereRaw("product_sub_masters.ean_id in (SELECT id FROM eans where prefix=?)", [$ean_code])
            ->where("products.ean_code", $ean_no)
            ->with(["color", "parent", "child"])
            ->select("product_sub_masters.*", DB::raw("products.size as product_size_id"))
            ->first();

            if(isset($request->picklist_master_id)){
                $data['qty'] = Picklist::rightJoin("picklist_sub_masters", "picklist_sub_masters.id", "=", "picklists.picklist_sub_master_id")
                ->where("picklist_sub_masters.product_id", $data['product']->product_master_id)
                ->where("picklist_sub_masters.color_id", $data['product']->color_id)
                ->where("picklist_sub_masters.picklist_master_id", $request->picklist_master_id)
                ->where("picklists.size_id", $data['product']->product_size_id)
                ->with('size')
                ->select("picklists.*")->first();
            }
            else{
                $data['qty'] = FinishedWarehouseQty::rightJoin("finished_warehouses", "finished_warehouses.id", "=", "finished_warehouse_qtys.finished_warehouse_id")
                ->where("finished_warehouses.product_master_id", $data['product']->product_master_id)
                ->where("finished_warehouses.color_id", $data['product']->color_id)
                ->where("finished_warehouses.warehouse_id", $request->warehouse_id)
                ->where('finished_warehouses.check_audit', 0)
                ->where("finished_warehouse_qtys.size_id", $data['product']->product_size_id)
                ->with('size')
                ->select("finished_warehouse_qtys.*")->first();
            }

        if ($data['product']->product_master_id != null) {

            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }

    public function getQtyByRetailSearch(Request $request){
        $retail = Session::get('retail');
        $product_ean_no = $request->product_ean;
        $ean_code = substr($product_ean_no, 0, 7);
        $ean_no = substr($product_ean_no, 7, 5);

        $last_digit = substr($product_ean_no, -1);

        $digits = substr($product_ean_no,0,12);
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
        $even_sum_three = $even_sum * 3;
        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        $total_sum = $even_sum_three + $odd_sum;
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;

        
      
        if($product_ean_no != $ean_code.$ean_no.$check_digit){
             return response()->json(['status' => 404, 'message'=>'Wrong Barcode' ,'data' => []]);
        }

        $data['product'] = ProductSubMaster::leftJoin("products", "products.product_sub_master_id", "=", "product_sub_masters.id")
        ->whereRaw("product_sub_masters.ean_id in (SELECT id FROM eans where prefix=?)", [$ean_code])
        ->where("products.ean_code", $ean_no)
        ->with(["color", "parent", "child"])
        ->select("product_sub_masters.*", DB::raw("products.size as product_size_id"))
        ->first();

        $data['qty'] = RetailWarehouseQty::rightJoin("retail_warehouses", "retail_warehouses.id", "=", "retail_warehouse_qtys.retail_warehouse_id")
        ->where("retail_warehouses.product_id", $data['product']->product_master_id)
        ->where("retail_warehouses.color_id", $data['product']->color_id)
        ->where("retail_warehouses.check_audit", 0)
        ->where("retail_warehouses.client_id", $retail->id)
        ->where("retail_warehouse_qtys.size_id", $data['product']->product_size_id)
        ->with('size')
        ->select("retail_warehouse_qtys.*")->first();

    if ($data['product']->product_master_id != null) {
        return response()->json(['status' => 200, 'data' => $data]);
    } else {
        return response()->json(['status' => 400, 'data' => []]);
    }
    }


    public function getQtyByConsumerInvoiceSearch(Request $request){
        $invoice_id = $request->invoice_id;
        $retail = Session::get('retail');
        $product_ean_no = $request->product_ean;
        $ean_code = substr($product_ean_no, 0, 7);
        $ean_no = substr($product_ean_no, 7, 5);

        $last_digit = substr($product_ean_no, -1);

        $digits = substr($product_ean_no,0,12);
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
        $even_sum_three = $even_sum * 3;
        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        $total_sum = $even_sum_three + $odd_sum;
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;

        
      
        if($product_ean_no != $ean_code.$ean_no.$check_digit){
             return response()->json(['status' => 404, 'message'=>'Wrong Barcode' ,'data' => []]);
        }

        $data['product'] = ProductSubMaster::leftJoin("products", "products.product_sub_master_id", "=", "product_sub_masters.id")
        ->whereRaw("product_sub_masters.ean_id in (SELECT id FROM eans where prefix=?)", [$ean_code])
        ->where("products.ean_code", $ean_no)
        ->with(["color", "parent", "child"])
        ->select("product_sub_masters.*", DB::raw("products.size as product_size_id"))
        ->first();

        $data['qty'] = CustomerInvoice::rightJoin("customer_invoice_sub_masters", "customer_invoice_sub_masters.id", "=", "customer_invoices.customer_invoice_sub_master_id")
        ->where("customer_invoice_sub_masters.product_id", $data['product']->product_master_id)
        ->where("customer_invoice_sub_masters.color_id", $data['product']->color_id)
        ->where("customer_invoice_sub_masters.customer_invoice_master_id", $invoice_id)
        ->where("customer_invoices.size_id", $data['product']->product_size_id)
        ->with('size')
        ->select("customer_invoices.*")->first();


    if ($data['product']->product_master_id != null) {
        return response()->json(['status' => 200, 'data' => $data]);
    } else {
        return response()->json(['status' => 400, 'data' => []]);
    }
    }



    public function getQtyByRetailGrnSearch(Request $request){
       
        $retail = Session::get('retail');
        $product_ean_no = $request->product_ean;
        $ean_code = substr($product_ean_no, 0, 7);
        $ean_no = substr($product_ean_no, 7, 5);

        $last_digit = substr($product_ean_no, -1);

        $digits = substr($product_ean_no,0,12);
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
        $even_sum_three = $even_sum * 3;
        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        $total_sum = $even_sum_three + $odd_sum;
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;

        
      
        if($product_ean_no != $ean_code.$ean_no.$check_digit){
             return response()->json(['status' => 404, 'message'=>'Wrong Barcode' ,'data' => []]);
        }

        $data['product'] = ProductSubMaster::leftJoin("products", "products.product_sub_master_id", "=", "product_sub_masters.id")
        ->whereRaw("product_sub_masters.ean_id in (SELECT id FROM eans where prefix=?)", [$ean_code])
        ->where("products.ean_code", $ean_no)
        ->with(["color", "parent", "child"])
        ->select("product_sub_masters.*", DB::raw("products.size as product_size_id"))
        ->first();

        $data['qty'] = RetailWarehouseQty::rightJoin("retail_warehouses", "retail_warehouses.id", "=", "retail_warehouse_qtys.retail_warehouse_id")
        ->where("retail_warehouses.product_id", $data['product']->product_master_id)
        ->where("retail_warehouses.color_id", $data['product']->color_id)
        ->where("retail_warehouses.check_audit", 0)
        ->where("retail_warehouses.client_id", $retail->id)
        ->where("retail_warehouse_qtys.size_id", $data['product']->product_size_id)
        ->with('size')
        ->select("retail_warehouse_qtys.*")->first();



    if ($data['product']->product_master_id != null) {
        return response()->json(['status' => 200, 'data' => $data]);
    } else {
        return response()->json(['status' => 400, 'data' => []]);
    }
    }
    



    public function getDataByStockSearch(Request $request)
    {
        $product_ean_no = $request->product_ean;
        $ean_code = substr($product_ean_no, 0, 7);
        $ean_no = substr($product_ean_no, 7, 5);


        $last_digit = substr($product_ean_no, -1);

        $digits = substr($product_ean_no,0,12);
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
        $even_sum_three = $even_sum * 3;
        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        $total_sum = $even_sum_three + $odd_sum;
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;

        
      
        if($product_ean_no != $ean_code.$ean_no.$check_digit){
             return response()->json(['status' => 404, 'message'=>'Wrong Barcode' ,'data' => []]);
        }
        $product_with_ean = [];
        /**
         * SELECT * FROM `product_sub_masters` LEFT JOIN products ON products.product_sub_master_id= product_sub_masters.id  WHERE  product_sub_masters.ean_id in (SELECT id FROM eans where prefix="ABCDEFG") AND products.ean_code="00001"
         */
        $data['product'] = ProductSubMaster::leftJoin("products", "products.product_sub_master_id", "=", "product_sub_masters.id")
            ->whereRaw("product_sub_masters.ean_id in (SELECT id FROM eans where prefix=?)", [$ean_code])
            ->where("products.ean_code", $ean_no)
            ->with(["color", "parent", "child"])
            ->select("product_sub_masters.*", DB::raw("products.size as product_size_id"))
            ->first();

         
                $data['qty'] = FinishedWarehouseQty::rightJoin("finished_warehouses", "finished_warehouses.id", "=", "finished_warehouse_qtys.finished_warehouse_id")
                ->where("finished_warehouses.product_master_id", $data['product']->product_master_id)
                ->where("finished_warehouses.color_id", $data['product']->color_id)
                ->where("finished_warehouses.warehouse_id", $request->warehouse_id)
                ->where('finished_warehouses.check_audit', 1)
                ->where("finished_warehouse_qtys.size_id", $data['product']->product_size_id)
                ->with('size')
                ->select("finished_warehouse_qtys.*")->first();
            

        if ($data['product']->product_master_id != null) {

            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }



    public function getDataByRetailStockSearch(Request $request)
    {
        $retail = Session::get('retail');
        $product_ean_no = $request->product_ean;
        $ean_code = substr($product_ean_no, 0, 7);
        $ean_no = substr($product_ean_no, 7, 5);
        $last_digit = substr($product_ean_no, -1);

        $digits = substr($product_ean_no,0,12);
        $even_sum = $digits[1] + $digits[3] + $digits[5] + $digits[7] + $digits[9] + $digits[11];
        $even_sum_three = $even_sum * 3;
        $odd_sum = $digits[0] + $digits[2] + $digits[4] + $digits[6] + $digits[8] + $digits[10];
        $total_sum = $even_sum_three + $odd_sum;
        $next_ten = (ceil($total_sum/10))*10;
        $check_digit = $next_ten - $total_sum;

        
      
        if($product_ean_no != $ean_code.$ean_no.$check_digit){
             return response()->json(['status' => 404, 'message'=>'Wrong Barcode' ,'data' => []]);
        }
        $product_with_ean = [];
        /**
         * SELECT * FROM `product_sub_masters` LEFT JOIN products ON products.product_sub_master_id= product_sub_masters.id  WHERE  product_sub_masters.ean_id in (SELECT id FROM eans where prefix="ABCDEFG") AND products.ean_code="00001"
         */
        $data['product'] = ProductSubMaster::leftJoin("products", "products.product_sub_master_id", "=", "product_sub_masters.id")
            ->whereRaw("product_sub_masters.ean_id in (SELECT id FROM eans where prefix=?)", [$ean_code])
            ->where("products.ean_code", $ean_no)
            ->with(["color", "parent", "child"])
            ->select("product_sub_masters.*", DB::raw("products.size as product_size_id"))
            ->first();

         
                $data['qty'] = RetailWarehouseQty::rightJoin("retail_warehouses", "retail_warehouses.id", "=", "retail_warehouse_qtys.retail_warehouse_id")
                ->where("retail_warehouses.product_id", $data['product']->product_master_id)
                ->where("retail_warehouses.color_id", $data['product']->color_id)
                ->where("retail_warehouses.client_id", $retail->id)
                // ->where('retail_warehouses.check_audit', 1)
                ->where("retail_warehouse_qtys.size_id", $data['product']->product_size_id)
                ->with('size')
                ->select("retail_warehouse_qtys.*")->first();
            


        if ($data['product']->product_master_id != null) {

            return response()->json(['status' => 200, 'data' => $data]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }



    public function getWarehouseProduc($ware_id)
    {


        $products = ProductSubMaster::leftJoin("finished_warehouses", function ($join) {
            $join->on("finished_warehouses.product_master_id", "product_sub_masters.product_master_id")->where("finished_warehouses.color_id", "product_sub_masters.color_id")
                ->where("finished_warehouses.product_master_id", "product_sub_masters.product_master_id");
        })->with(["child", "parent"])->select("product_sub_masters.*")->get();

        return $products;

        // Log::alert("message", [ $products  ]);
    }

    // public function searchProduct($search){

    //     $product_master=ProductMaster::with(['subproduct'=>function($q){
    //             $q->with('color');
    //         }])->get();




    //     if(!$product_master->isEmpty())
    //     {
    //         return response()->json(['status'=>200,'data'=>$product_master]);
    //     }
    //     else
    //     {
    //         return response()->json(['status'=>400,'data'=>""]);
    //     }
    // }

    public function searchProduct($search)
    {
        $product_master = ProductMaster::where("product_code", 'Like', "%" . $search . "%")
            ->with(["subproduct" => function ($query) {
                $query->with("color");
            }])->get();
     

        if (!$product_master->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $product_master]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }


    public function getProductByGoods(Request $request){
        $product_master = ProductMaster::whereRaw('id in (select product_master_id from finished_warehouses where warehouse_id = ? and check_audit=?)',[$request->warehouse_id, 0])
        ->where("product_code", 'Like', "%" . $request->srch . "%")
        ->with(["subproduct" => function ($query) {
            $query->with("color");
        }])->get();

        if (!$product_master->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $product_master]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }


    public function getColorByGoods(Request $request){

      $data = FinishedWarehouse::with('color')->where('warehouse_id',$request->warehouse_id)->where('product_master_id', $request->p_id)->where('check_audit', 0)->get();
      if (!$data->isEmpty()) {
        return response()->json(['status' => 200, 'data' => $data]);
    } else {
        return response()->json(['status' => 400, 'data' => []]);
    }
    }

    public function getColorByRetailConsumer(Request $request){
       $retail = Session::get('retail');
        $data = RetailWarehouse::with('color')->where('client_id',$retail->id)->where('product_id', $request->p_id)->get();
        if (!$data->isEmpty()) {
          return response()->json(['status' => 200, 'data' => $data]);
      } else {
          return response()->json(['status' => 400, 'data' => []]);
      }
      }


      public function getColorByUnfinishedProduct(Request $request){
     
         $data = UnfinishedMaster::with('color')->where('product_master_id',$request->p_id)->get();
         if (!$data->isEmpty()) {
           return response()->json(['status' => 200, 'data' => $data]);
       } else {
           return response()->json(['status' => 400, 'data' => []]);
       }
       }

      public function getConsumerInvoiceProductColor(Request $request){
        $retail = Session::get('retail');
        $invoice_id = $request->invoice_id;
        $p_id = $request->p_id;
         $data = CustomerInvoiceSubMaster::with('color')->where('customer_invoice_master_id',$invoice_id)->where('product_id', $p_id)->get();
         if (!$data->isEmpty()) {
           return response()->json(['status' => 200, 'data' => $data]);
       } else {
           return response()->json(['status' => 400, 'data' => []]);
       }
       }
 

    
    public function getColorByAudit(Request $request){

        $data = FinishedWarehouse::with('color')->where('warehouse_id',$request->warehouse_id)->where('product_master_id', $request->p_id)->where('check_audit', 1)->get();
        if (!$data->isEmpty()) {
          return response()->json(['status' => 200, 'data' => $data]);
      } else {
          return response()->json(['status' => 400, 'data' => []]);
      }
      }

   public function getColorByRetailAudit(Request $request){


        $retail = Session::get('retail');
        $data = RetailWarehouse::with('color')->where('client_id',$retail->id)->where('product_id', $request->p_id)->get();
        if (!$data->isEmpty()) {
          return response()->json(['status' => 200, 'data' => $data]);
      } else {
          return response()->json(['status' => 400, 'data' => []]);
      }
      }

    public function searchAuditProduct(Request $request)
    {
      
        $product_master = ProductMaster::where("product_code", 'Like', "%" . $request->type_search . "%")
            ->with(["subproduct" => function ($query) {
                $query->with("color");
            }])->get();

        if($request->w_id){
            $product_master = ProductMaster::whereRaw('id in (select product_master_id from finished_warehouses where warehouse_id = ?)',[$request->w_id])
            ->where("product_code", 'Like', "%" . $request->type_search . "%")
            ->with(["subproduct" => function ($query) {
                $query->with("color");
            }])->get();
        }
        if($request->w_id && $request->main_cat_id && $request->sub_cat_ids){
           
            $main_cat_id=$request->main_cat_id;
            $sub_cat_id=$request->sub_cat_ids;

            $product_master = ProductMaster::whereRaw('id in (select product_master_id from finished_warehouses where warehouse_id = ? and check_audit = ?)',[$request->w_id, 1])
            ->where("product_code", 'Like', "%" . $request->type_search . "%")
            ->with(["subproduct" => function ($query) use($main_cat_id, $sub_cat_id){
                $query->where('main_category_id', $main_cat_id)->whereIn('category_id', $sub_cat_id)->with("color");
            }])->get();
       
        }
        if($request->w_id && $request->main_cat_id){
            
            $main_cat_id=$request->main_cat_id;
            $product_master = ProductMaster::whereRaw('id in (select product_master_id from finished_warehouses where warehouse_id = ? and check_audit = ?)',[$request->w_id, 1])
            ->where("product_code", 'Like', "%" . $request->type_search . "%")
            ->with(["subproduct" => function ($query) use($main_cat_id){
                $query->where('main_category_id', $main_cat_id)->with("color");
            }])->get();
       
        }
       
        if (!$product_master->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $product_master]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }

    public function searchRetailAuditProduct(Request $request){
       $retail = Session::get('retail');
    
        $product_master = ProductMaster::whereRaw('id in (select product_id from retail_warehouses where client_id = ?)',[$retail->id])
        ->where("product_code", 'Like', "%" . $request->type_search . "%")
        ->with(["subproduct"])->get();
        if (!$product_master->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $product_master]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }

    public function searchProductByseason($search, $season_id)
    {

        $product_master = ProductMaster::whereRaw("id in (select product_master_id from product_sub_masters where season_id = ?)", [$season_id])->where('product_code', 'like', '%' . $search . '%')->get();



        if (!$product_master->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $product_master]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }

    public function getSearchColortBySeasonProduct($product_id, $season_id)
    {

        $color_code = ProductSubMaster::with('color')->where('product_master_id', $product_id)->where('season_id', $season_id)->get();



        if (!$color_code->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $color_code]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }




    public function searchUnfinishedProduct($search)
    {

        $product_master = ProductMaster::whereRaw("id IN (select product_master_id from unfinished_master)")
            ->where("product_code", 'Like', "%" . $search . "%")
            ->with(["subproduct" => function ($query) {
                $query->whereRaw("color_id IN (select color_id from unfinished_master)")
                    ->with("color");
            }])
            ->get();

            
        if (!$product_master->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $product_master]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }




    public function checkQuantity(Request $request)
    {
   
        if ($request->invoice_product_id) {
            if($request->picklist_master_id > 0){
               
                $product_id=PicklistSubMaster::where('picklist_master_id',$request->picklist_master_id)->where('color_id',$request->color_id)->where('product_id',$request->invoice_product_id)->first()->id;        
                $product_qty = Picklist::where('picklist_sub_master_id', $product_id)->pluck('qty', 'size_id');

            }else{
                $product_id = FinishedWarehouse::where('warehouse_id', $request->warehouse_id)->where('product_master_id', $request->invoice_product_id)->where('color_id', $request->color_id)->first()->id;
                $product_qty = FinishedWarehouseQty::where('finished_warehouse_id', $product_id)->pluck('qty', 'size_id');
            }
           
        } 
      
             else {
            $product_id = UnfinishedMaster::where('product_master_id', $request->product_id)->where('color_id', $request->color_id)->first()->id;
            $product_qty = Unfinished::where('unfinished_master_id', $product_id)->pluck('qty', 'size_id');
        }

        return response()->json(['status' => 200, 'data' => $product_qty]);
    }

    public function auditCheckQuantity(Request $request)
    {
        
            $product_id = FinishedWarehouse::where('warehouse_id', $request->warehouse_id)->where('product_master_id', $request->product_id)->where('color_id', $request->color_id)->first()->id;
            $product_qty = FinishedWarehouseQty::where('finished_warehouse_id', $product_id)->pluck('qty', 'size_id');
        

        return response()->json(['status' => 200, 'data' => $product_qty]);
    }

    public function getProductColorPrice($p_id, $c_id)
    {
        $product_detail = ProductSubMaster::where('product_master_id', $p_id)->where('color_id', $c_id)->first();
        return response()->json(['status' => 200, 'data' => $product_detail]);
    }

    public function checkQty(Request $request){
        $psm_id=PicklistSubMaster::where('picklist_master_id',$request->pick_mas_id)->where('color_id',$request->col_id)->where('product_id',$request->prod_id)->first()->id;
        $data['qty']=Picklist::where('picklist_sub_master_id',  $psm_id)->where('size_id', $request->s_id)->first()->qty;
        $data['cqty']=$data['qty']-(int)$request->qy;
        return $data;
    }

    public function checkWarehouseQty(Request $request){
        if($request->warehouse_id == 0){
            $retail = Session::get('retail');
             $r_id = RetailWarehouse::where('client_id', $retail->id)->where('color_id',$request->col_id)->where('product_id',$request->prod_id)->first()->id;
             $data['qty']=RetailWarehouseQty::where('retail_warehouse_id',  $r_id)->where('size_id', $request->s_id)->first()->qty;        
             $data['cqty']=$data['qty']-(int)$request->qy;
            }else{
        $w_id=FinishedWarehouse::where('warehouse_id',$request->warehouse_id)->where('color_id',$request->col_id)->where('product_master_id',$request->prod_id)->first()->id;
        $data['qty']=FinishedWarehouseQty::where('finished_warehouse_id',  $w_id)->where('size_id', $request->s_id)->first()->qty;        
        $data['cqty']=$data['qty']-(int)$request->qy;
        }
        return $data;
    }

    
    public function  checkConsumerInvoiceQty(Request $request){
    
          
             $r_id = CustomerInvoiceSubMaster::where('customer_invoice_master_id', $request->invoice_id)->where('color_id',$request->col_id)->where('product_id',$request->prod_id)->first()->id;
           
             $data['qty']=CustomerInvoice::where('customer_invoice_sub_master_id',  $r_id)->where('size_id', $request->s_id)->first()->qty;        
             $data['cqty']=$data['qty']-(int)$request->qy;
            
        return $data;
    }

    public function  checkRetailWarehouseQty(Request $request){
        $retail = Session::get('retail');
          
        $r_id = RetailWarehouse::where('client_id', $retail->id)->where('color_id',$request->col_id)->where('product_id',$request->prod_id)->first()->id;
      
        $data['qty']=RetailWarehouseQty::where('retail_warehouse_id',  $r_id)->where('size_id', $request->s_id)->first()->qty;        
        $data['cqty']=$data['qty']-(int)$request->qy;
       
   return $data;
}

public function  checkUnfinishedWarehouseQty(Request $request){
      
    $r_id = UnfinishedMaster::where('color_id',$request->col_id)->where('product_master_id',$request->prod_id)->first()->id;
  
    $data['qty']=Unfinished::where('unfinished_master_id',  $r_id)->where('size_id', $request->s_id)->first()->qty;        
    $data['cqty']=$data['qty']-(int)$request->qy;
   
return $data;
}


    

   
   
    public function getRetailProduct(Request $request){
        $retail = Session::get('retail');
    
        $product_master = ProductMaster::whereRaw("id in (select product_id from retail_warehouses where client_id = ? and check_audit = ?)", [$retail->id, 0])
        ->where('product_code', 'like', '%' . $request->search . '%')->get();
   
        if (!$product_master->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $product_master]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }
    public function  getConsumerInvoiceProduct(Request $request){
        $retail = Session::get('retail');
        $invoice_id = $request->invoice_id;
       
        $product_master = ProductMaster::whereRaw("id in (select product_id from customer_invoice_sub_masters where customer_invoice_master_id = ?)", [$invoice_id])
        ->where('product_code', 'like', '%' . $request->search . '%')->get();
   
        if (!$product_master->isEmpty()) {
            return response()->json(['status' => 200, 'data' => $product_master]);
        } else {
            return response()->json(['status' => 400, 'data' => []]);
        }
    }

  
   

    public function getRetailProductColorMrp(Request $request){
        $data = ProductSubMaster::where('product_master_id', $request->p_id)->where('color_id', $request->c_id)->first()->mrp;
        return response()->json(['status' => 200, 'data' => $data]);
    }

    public function saveTempRetailAudit(Request $request){
        $retail =  Session::get('retail');
       
        $data = DB::table('temp_retail_audit')->where('retail_id', $retail->id)->first();
        if(isset($data)){
            DB::table('temp_retail_audit')->where('retail_id', $retail->id)->delete();
            RetailWarehouse::where('client_id', $retail->id)->update(['check_audit' => 0]);


        }else{
            DB::table('temp_retail_audit')->insert(['retail_id'=>$retail->id, 'is_show'=>1]);
            RetailWarehouse::where('client_id', $retail->id)->update(['check_audit' => 1]);
        }
    }
}

