<?php

namespace Modules\Master\Http\Controllers\Agent;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Modules\Master\Entities\Agent;

class AgentController extends Controller
{
    public function index()
    {
        $agent['data']=Agent::all();
        return view('master::agent.index', $agent);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create(Request $request)
    {
        return view('master::agent.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        
       
    //     if(file_exists(public_path('ProductImage'.'/'.'167661797012.cloth6.jpg'))){
          
    //         unlink(public_path('ProductImage'.'/'.'167661797012.cloth6.jpg'));
    //     }
    //     die;
    //     if ($files = $request->file('photo')) {
        
    //         $name = time() . rand(1, 100) . '.' . $files->getClientOriginalName();
         
    //         $path = $files->move('ProductImage', $name);
        
    //     }
    // die;
        $request->validate([
            'name'=>'required',
            'address'=>'required',
            'mobile'=>'required',
            'email'=>'required|unique:agents,email',
            'photo'=>'required'

        ]);
        if ($files = $request->file('photo')) {
            $name = time() . rand(1, 100) . '.' . $files->getClientOriginalName();
            $files->move('AgentImage', $name);
        }
     
        $agent=new Agent();
        $agent->name=$request->name;
        $agent->address=$request->address;
        $agent->mobile = $request->mobile;
        $agent->email = $request->email;
        $agent->photo = $name;

        $agent->save();
        $request->session()->flash('message','Agent Added Successfully');
        return redirect(route('master.agent'));
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
        $data['agent']=Agent::find($id);

        return view('master::agent.edit', $data);
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
            'address'=>'required',
            'mobile'=>'required',
            'email'=>'required',
        ]);
        if ($files = $request->file('photo')) {
            if(file_exists(public_path('AgentImage'.'/'. $request->image1))){
               
                unlink(public_path('AgentImage'.'/'.$request->image1));
            }
            $name = time() . rand(1, 100) . '.' . $files->getClientOriginalName();
            $files->move('AgentImage', $name);
        }else{
            
                $name=$request->image1;
        
        }
        $agent=Agent::find($id);
        $agent->name=$request->name;
        $agent->address=$request->address;
        $agent->mobile = $request->mobile;
        $agent->email = $request->email;
        $agent->photo = $name;
        $agent->save();
        $request->session()->flash('message','Detail Updated Successfully');

        return redirect(route('master.agent'));
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
