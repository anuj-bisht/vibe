<?php

namespace Modules\Master\Http\Controllers\HSN;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Hsn;

class HsnController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $hsn['data']=HSN::all();
        return view('master::hsn.index', $hsn);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        return view('master::hsn.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required|unique:hsns,code',
            'hsn_value'=>'required'

        ]);
        $hsn=new Hsn();
        $hsn->code=$request->code;
        $hsn->value=$request->hsn_value;

        $hsn->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.hsn'));
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
        $data['hsn']=Hsn::find($id);
        return view('master::hsn.edit',$data);
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
            'hsn_code'=>'required'

        ]);
        $hsn= Hsn::find($id);
        $hsn->code=$request->hsn_code;
        $hsn->save();
        session()->flash('message', 'Detail Update Successfully.');
        return redirect(route('master.hsn'));
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
