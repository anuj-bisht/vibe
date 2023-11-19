<?php

namespace Modules\Master\Http\Controllers\Tax;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Tax;

class TaxController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $tax['data']=Tax::all();
        return view('master::tax.index', $tax);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::tax.create');

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:taxes,name',
            'percent'=>'required'

        ]);
        $tax=new Tax();
        $tax->name=$request->name;
        $tax->percent=$request->percent;
        $tax->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.tax'));
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
        $data['tax']=Tax::find($id);
        return view('master::tax.edit', $data);
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
            'percent'=>'required'

        ]);

        $tax=Tax::find($id);
        $tax->name=$request->name;
        $tax->percent=$request->percent;
        $tax->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.tax'));
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
