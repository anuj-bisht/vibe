<?php

namespace Modules\Master\Http\Controllers\Season;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Season;

class SeasonController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $season['data']=Season::all();

        return view('master::season.index', $season);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::season.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:seasons,name',
            'code'=>'required|unique:seasons,code'

        ]);
        $season=new Season();
        $season->name=$request->name;
        $season->code=$request->code;
        $season->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.season'));
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
        $data['season']=Season::find($id);
        return view('master::season.edit', $data);
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
        $season=Season::find($id);
        $season->name=$request->name;
        $season->code=$request->code;
        $season->save();
        session()->flash('message', 'Detail Update Successfully.');
        return redirect(route('master.season'));
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
