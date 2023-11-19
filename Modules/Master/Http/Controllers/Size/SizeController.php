<?php

namespace Modules\Master\Http\Controllers\Size;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Size;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $size['data']=Size::all();
        return view('master::size.index', $size);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::size.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'size'=>'required',
            'type'=>'required'

        ]);

        $size=new Size();
        $size->size=$request->size;
        $size->type=$request->type;

        $size->save();
        return redirect(route('master.size'));
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

        $data['size']= Size::find($id);
        return view('master::size.edit', $data);
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
            'size'=>'required',
            'type'=>'required'

        ]);
        $size=Size::find($id);
        $size->size=$request->size;
        $size->type=$request->type;

        $size->save();
        return redirect(route('master.size'));
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
