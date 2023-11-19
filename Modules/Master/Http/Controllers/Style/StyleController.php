<?php

namespace Modules\Master\Http\Controllers\Style;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Style;

class StyleController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $style['data']=Style::all();
        return view('master::style.index',$style);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        return view('master::style.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required|unique:styles,code',
            'name'=>'required|unique:styles,name'

        ]);
        $style=new Style();
        $style->code=$request->code;
        $style->name=$request->name;
        $style->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.style'));
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
        $data['style']=Style::find($id);
        return view('master::style.edit', $data);
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
            'name'=>'required'

        ]);
        $style=Style::find($id);
        $style->code=$request->code;
        $style->name=$request->name;
        $style->save();
        session()->flash('message', 'Detail Update Successfully.');
        return redirect(route('master.style'));
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
