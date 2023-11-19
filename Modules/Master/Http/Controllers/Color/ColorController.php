<?php

namespace Modules\Master\Http\Controllers\Color;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Session;
use Modules\Master\Entities\Color;
use Yajra\DataTables\Services\DataTable;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $color['data']=Color::all();
        return view('master::color.index', $color);
    }



    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        return view('master::color.create');

    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'color_code'=>'required|unique:colors,color_code',
            'name'=>'required|unique:colors,name'
        ]);
        $color=new Color();
        $color->color_code=$request->color_code;
        $color->name=$request->name;
        $color->save();
        session()->flash('message', 'Color Add Successfully.');
        return redirect(route('master.color'));
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
        $data['color']=Color::find($id);
        return view('master::color.edit',$data);
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
            'color_code'=>'required',
            'color_name'=>'required'
        ]);
        $color=Color::find($id);
        $color->color_code=$request->color_code;
        $color->name=$request->color_name;
        $color->save();
        Session::flash('message', 'Color Update Successfully'); 

        return redirect(route('master.color'));

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
