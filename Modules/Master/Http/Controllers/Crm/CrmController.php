<?php

namespace Modules\Master\Http\Controllers\Crm;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Master\Entities\Crm;

class CrmController extends Controller
{
    public function index()
    {
        $crm['data']=Crm::all();
        return view('master::crm.index', $crm);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        return view('master::crm.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
      
        
        $request->validate([
            'crm_name'=>'required',
            'designation'=>'required',
            'address'=>'required',
            'mobile'=>'required',
            'email'=>'required|email',
            'photo'=>'required',
        ]);
        if ($files = $request->file('photo')) {
            $name = time() . rand(1, 100) . '.' . $files->getClientOriginalName();
            $files->move('crmImages', $name);
        }
        $crm=new Crm();
        $crm->crm_name=$request->crm_name;
        $crm->designation=$request->designation;
        $crm->address=$request->address;
        $crm->mobile=$request->mobile;
        $crm->email=$request->email;
        $crm->photo=$name;
        $crm->save();
        session()->flash('message', 'Details Add Successfully.');
        return redirect(route('master.crm'));
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
        $data['crm']=Crm::find($id);

        return view('master::crm.edit', $data);
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
            'crm_name'=>'required',
            'designation'=>'required',
            'address'=>'required',
            'mobile'=>'required',
            'email'=>'required|email',
        ]);
        if ($files = $request->file('photo')) {
          
            if(file_exists(public_path('crmImages'.'/'. $request->image1))){
               
                unlink(public_path('crmImages'.'/'.$request->image1));
            }
            
            $name = time() . rand(1, 100) . '.' . $files->getClientOriginalName();
            $files->move('crmImages', $name);
        }else{
           
                $name=$request->image1;
        }
      
        $crm=Crm::find($id);
        $crm->crm_name=$request->crm_name;
        $crm->designation=$request->designation;
        $crm->address=$request->address;
        $crm->mobile=$request->mobile;
        $crm->email=$request->email;
        $crm->photo=$name;
        $crm->save();
        session()->flash('message', 'Details Update Successfully.');
        return redirect(route('master.crm'));
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
