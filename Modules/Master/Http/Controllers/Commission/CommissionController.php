<?php

namespace Modules\Master\Http\Controllers\Commission;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Commission;

class CommissionController extends Controller
{
    public function index()
    {
        $commission['data']=Commission::all();
        return view('master::commission.index', $commission);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        return view('master::commission.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'code'=>'required|unique:commissions,code',
            'percent'=>'required',
        ]);

        $commission=new Commission();
        $commission->code=$request->code;
        $commission->percent=$request->percent;
        $commission->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.commission'));
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
        $data['commission']=Commission::find($id);

        return view('master::commission.edit', $data);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'code'=>'required',
            'percent'=>'required',


        ]);
        $commission=Commission::find($id);
        $commission->code=$request->code;
        $commission->percent=$request->percent;
        $commission->save();
        session()->flash('message', 'Detail Update Successfully.');
        return redirect(route('master.commission'));
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
