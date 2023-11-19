<?php

namespace Modules\User\Http\Controllers\User;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function index(){

        $permission['data']=Permission::all();
        return view('user::permissions.index', $permission);
    }

    public function create(){
        return view('user::permissions.create');
    }

    public function store(Request $request){
        $validated=$request->validate([
            'name'=>'required|min:3',
            'module_name'=>'required'
        ]);
       Permission::Create($validated);
       $request->session()->flash('message','New Permission Added');
       return redirect(route('permission.listing'));

    }
    public function edit(Permission $id){
        $data['roles']=Role::all();
        $data['permission']=$id;
        return view('user::permissions.edit', $data);

    }
    public function update(Request $request, $id){
      
        $request->validate([
            'name'=>'required|min:3'
        ]);
        $permission=Permission::find($id);
        $permission->name=$request->name;
        $permission->save();
        $request->session()->flash('message', 'Permission Update Successfully');
        return redirect(route('permission.listing'));

}

public function giveRole(Request $request, Permission $permission)
{
  if($permission->hasRole($request->role)){
     return redirect()->back()->with('message', 'Role already exist');
  }else{
    $permission->assignRole($request->role);
    return redirect()->back()->with('message', 'Role assigned Succesfully');

  }
}

public function revokeRole(Permission $permission, Role $role)
{

  if($permission->hasRole($role)){
    $permission->removeRole($role);
     return redirect()->back()->with('message', 'Remove Role');
  }
    return redirect()->back()->with('message', 'Role not exist');


}

}
