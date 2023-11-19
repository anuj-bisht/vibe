<?php

namespace Modules\Master\Http\Controllers\EAN;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Ean;

class EanController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $ean['data']=EAN::all();
        return view('master::ean.index', $ean);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        return view('master::ean.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'prefix'=>'required|unique:eans,prefix'

        ]);

        $ean=new Ean();
        $ean->prefix=$request->prefix;
        $ean->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.ean'));
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
        $data['ean']=Ean::find($id);
        return view('master::ean.edit', $data);
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
            'prefix'=>'required'

        ]);
        $ean=Ean::find($id);
        $ean->prefix=$request->prefix;
        $ean->save();
        session()->flash('message', 'Detail Update Successfully.');
        return redirect(route('master.ean'));

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
