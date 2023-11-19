<?php

namespace Modules\Master\Http\Controllers\Margin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Margin;

class MarginController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $margin['data']=Margin::all();
        return view('master::margin.index', $margin);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::margin.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:margins,name',
            'code'=>'required|unique:margins,code'

        ]);
        $margin=new Margin();
        $margin->name=$request->name;
        $margin->code=$request->code;
        $margin->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.margin'));
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
        $data['margin'] = Margin::find($id);
        return view('master::margin.edit', $data);
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
            'margin_code'=>'required'

        ]);
        $margin=Margin::find($id);
        $margin->name=$request->name;
        $margin->code=$request->margin_code;
        $margin->save();
        session()->flash('message', 'Detail Update Successfully.');
        return redirect(route('master.margin'));
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
