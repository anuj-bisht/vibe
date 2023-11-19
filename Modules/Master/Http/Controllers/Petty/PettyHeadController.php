<?php

namespace Modules\Master\Http\Controllers\Petty;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\PettyHead;

class PettyHeadController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $petty['data'] = PettyHead::all();
        return view('master::pettyhead.index', $petty);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('master::pettyhead.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'petty_head'=>'required',
        ]);
 
        $head=new PettyHead();
        $head->petty_heads=$request->petty_head;
        $head->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.pettyhead'));
    }
    
    public function edit(PettyHead $head){
       $data['petty'] = $head;
       return view('master::pettyhead.edit', $data);

    }

    public function update(Request $request)
    {
        $request->validate([
            'petty_head'=>'required',
        ]);

        $head=PettyHead::find($request->id);
        $head->petty_heads=$request->petty_head;
        $head->save();
        session()->flash('message', 'Detail Update Successfully.');
        return redirect(route('master.pettyhead'));
    }

}
