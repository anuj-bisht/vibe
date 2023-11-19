<?php

namespace Modules\Master\Http\Controllers\Discount;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Discount;
use Illuminate\Contracts\Support\Renderable;

class DiscountController extends Controller
{
    public function index()
    {
        $discount['data']=Discount::all();
        return view('master::discount.index', $discount);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        return view('master::discount.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required|unique:discounts,code',
            'percent'=>'required',


        ]);
        $discount=new Discount();
        $discount->code=$request->code;
        $discount->percent=$request->percent;
        $discount->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.discount'));
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
        $data['discount']=Discount::find($id);

        return view('master::discount.edit', $data);
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
            'code'=>'required',
            'percent'=>'required',
        ]);
        $discount=Discount::find($id);
        $discount->code=$request->code;
        $discount->percent=$request->percent;
        $discount->save();
        session()->flash('message', 'Detail Update Successfully.');

        return redirect(route('master.discount'));
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
