<?php

namespace Modules\Master\Http\Controllers\Coupon;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Coupon;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $coupons['data']= Coupon::all();
        return view('master::coupon.index', $coupons);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
       $coupon = new Coupon();
       $coupon->coupon_type = $request->coupon_type;
       $coupon->coupon_title = $request->title;
       $coupon->coupon_code = $request->code;
       $coupon->limit_user = $request->coupon_type == 'Default' ? $request->limit  : 1;
       $coupon->discount_type = $request->discount_type;
       $coupon->discount_amount = $request->discount_amount;
       $coupon->minimum_purchase = $request->minimum_purchase;
       $coupon->maximum_discount = $request->discount_type == "Percent" ? $request->maximum_discount : null ;
       $coupon->start_date = $request->start_date;
       $coupon->expire_date = $request->expire_date;
       $coupon->save();
       return redirect(route('coupon.list'));
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
    public function edit(Coupon  $id)
    {
       $data['coupon'] = $id;
        return view('master::coupon.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
      $coupon = Coupon::find($request->id);
      $coupon->coupon_type = $request->coupon_type;
      $coupon->coupon_title = $request->title;
      $coupon->coupon_code = $request->code;
      $coupon->limit_user = $request->coupon_type == 'Default' ? $request->limit  : 1;
      $coupon->discount_type = $request->discount_type;
      $coupon->discount_amount = $request->discount_amount;
      $coupon->minimum_purchase = $request->minimum_purchase;
      $coupon->maximum_discount = $request->discount_type == "Percent" ? $request->maximum_discount : null ;
      $coupon->start_date = $request->start_date;
      $coupon->expire_date = $request->expire_date;
      $coupon->save();
      return redirect(route('coupon.list'));
      
    }

public function updateStatus(Request $request){
    if($request->id == true){
          Coupon::where('id', $request->c_id)->update(['status'=>1]);
    }else{
        Coupon::where('id', $request->c_id)->update(['status'=>0]);
    }
    
}
}
