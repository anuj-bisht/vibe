<?php

namespace Modules\Master\Http\Controllers\Transport;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Transport;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    public function index()
    {
        $transport['data']=Transport::all();
        return view('master::transport.index', $transport);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        return view('master::transport.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required|unique:transports,email',
            'contact'=>'required',
            'address'=>'required',

        ]);
        $transport=new Transport();
        $transport->name=$request->name;
        $transport->email=$request->email;
        $transport->contact=$request->contact;
        $transport->address=$request->address;
        $transport->save();
        session()->flash('message', 'Detail Add Successfully.');
        return redirect(route('master.transport'));
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
        $data['transport']=Transport::find($id);

        return view('master::transport.edit', $data);
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
            'email'=>'required',
            'contact'=>'required',
            'address'=>'required',

        ]);
        $transport=Transport::find($id);
        $transport->name=$request->name;
        $transport->email=$request->email;
        $transport->contact=$request->contact;
        $transport->address=$request->address;
        $transport->save();
        session()->flash('message', 'Detail Update Successfully.');
        return redirect(route('master.transport'));
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
