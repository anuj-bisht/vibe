<?php

namespace Modules\Master\Http\Controllers\Fabric;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Redirect;
use Modules\Master\Entities\Fabric;

class FabricController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $fabric['data']=Fabric::all();
        return view('master::fabric.index', $fabric);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        $permission = 'master.add';
        if(!$request->user()->can($permission)){
            return Redirect::back()->withErrors(['msg' => 'YOU HAVE NOT THE RIGHT PERMISSIONS TO ADD FABRIC.']);
        }
        return view('master::fabric.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:fabrics,name',
            'code'=>'required|unique:fabrics,code'

        ]);
        $fabric=new Fabric();
        $fabric->name=$request->name;
        $fabric->code=$request->code;
        $fabric->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.fabric'));
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
    public function edit($id, Request $request)
    {
        $permission = 'master.edit';
        if(!$request->user()->can($permission)){
            return Redirect::back()->withErrors(['msg' => 'YOU HAVE NOT THE RIGHT PERMISSIONS TO EDIT FABRIC.']);
        }
        $data['fabric']=Fabric::find($id);
        return view('master::fabric.edit', $data);
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
            'code'=>'required'

        ]);
        $fabric=Fabric::find($id);
        $fabric->name=$request->name;
        $fabric->code=$request->code;
        $fabric->save();
        session()->flash('message', 'Detail Update Successfully.');
        return redirect(route('master.fabric'));
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
