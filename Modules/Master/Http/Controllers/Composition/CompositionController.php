<?php

namespace Modules\Master\Http\Controllers\Composition;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Composition;

class CompositionController extends Controller
{
    public function index()
    {
        $composition['data']=Composition::all();
        return view('master::composition.index', $composition);
    }

    

    public function create(Request $request)
    {
        return view('master::composition.create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'text'=>'required',
        ]);
        $composition=new Composition();
        $composition->text=$request->text;
        $composition->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.composition'));
    }

   
    // public function show($id)
    // {
    //     return view('master::show');
    // }

  
    public function edit($id)
    {
        $data['composition']=Composition::find($id);
        return view('master::composition.edit', $data);
    }

  
    public function update(Request $request, $id)
    {
        $request->validate([
            'text'=>'required',
        ]);
        $composition=Composition::find($id);
        $composition->text=$request->text;
        $composition->save();
        session()->flash('message', 'Detail Update Successfully.');
        return redirect(route('master.composition'));
    }

    
    }

