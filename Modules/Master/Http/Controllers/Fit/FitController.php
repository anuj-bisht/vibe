<?php

namespace Modules\Master\Http\Controllers\Fit;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Fit;

class FitController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $fit['data']=Fit::all();
        return view('master::fit.index', $fit);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::fit.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:fits,name',
            'code'=>'required|unique:fits,code'

        ]);
        $fit=new Fit();
        $fit->name=$request->name;
        $fit->code=$request->fit_code;
        $fit->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.fit'));
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
        $data['fit']= Fit::find($id);
        return view('master::fit.edit',$data);
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
            'fit_code'=>'required'

        ]);
        $fit=Fit::find($id);
        $fit->name=$request->name;
        $fit->code=$request->fit_code;
        $fit->save();
        session()->flash('message', 'Detail Update Successfully.');
        return redirect(route('master.fit'));
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
