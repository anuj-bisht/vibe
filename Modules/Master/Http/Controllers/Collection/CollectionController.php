<?php

namespace Modules\Master\Http\Controllers\Collection;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Collection;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $collection['data'] = Collection::all();
        return view('master::collection.index', $collection);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::collection.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required'
        ]);

        $collection = new Collection();
        $collection->name = $request->name;
        $collection->code = $request->code;
        $collection->save();
        $request->session()->flash('message', 'Detail Added Successfully');
        return redirect(route('master.collection'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
       
        $data['collection'] = Collection::where('id', $id)->first();
        return view('master::collection.edit', $data);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'code' => 'required'
        ]);
        $collection = Collection::where('id', $id)->update([
            'name' => $request->name,
            'code' => $request->code
        ]);
        $request->session()->flash('message', 'Detail Updated Successfully');
        return redirect(route('master.collection'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */


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
