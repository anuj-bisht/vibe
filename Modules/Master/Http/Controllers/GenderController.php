<?php

namespace Modules\Master\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Gender;
use Yajra\DataTables\Services\DataTable;

class GenderController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $gender['data'] = Gender::all();
      
        return view('master::index', $gender);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'gender'=>'required',

        ]);
        $gender=new Gender();
        $gender->name=$request->gender;
        $gender->short_form=$request->gender=='Gents'?'G':'L';
        $gender->save();
        return redirect(route('master.gender'));
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
        $data['gender']=Gender::find($id);
        return view('master::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $gender=Gender::find($id);
        $request->validate([
            'gender'=>'required',

        ]);
        $gender->name=$request->gender;
        $gender->short_form=$request->gender=='Gents'?'G':'L';
        $gender->save();
        return redirect(route('master.gender'));
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
