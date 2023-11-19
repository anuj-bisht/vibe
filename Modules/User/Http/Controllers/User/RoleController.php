<?php

namespace Modules\User\Http\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;



class RoleController extends Controller
{
    public function index(){
       
     
        $roles['data']=Role::all();
        return view('user::roles.index',$roles);

    }
    public function create(){

        return view('user::roles.create');
    }
    public function store(Request $request){
        $validated=$request->validate([
            'name'=>'required|min:3'
        ]);
       Role::Create($validated);
       $request->session()->flash('message', 'New Role Added');
        return redirect(route('role.listing'));
    }
    public function edit(Role $id){

        $data['modules']=Permission::select('module_name')->distinct()->orderBy('module_name')->get()->toArray();
  
        $data['role']=$id;
        $data['rolePermissions'] = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id->id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
        return view('user::roles.edit', $data);

    }

    public function update(Request $request, $id){
        $request->validate([
            'name'=>'required|min:3'
        ]);
        $role=Role::find($id);
        $role->name=$request->name;
        $role->save();
        $request->session()->flash('message', 'Role Update Successfully');
        return redirect(route('role.listing'));

}

    public function givePermission(Request $request, Role $role)
    {
       
    //   if($role->hasPermissionTo($request->permission)){
    //      return redirect()->back()->with('message', 'Permission already exist');
    //   }else{
    //     $role->givePermissionTo($request->permission);
    //     return redirect()->back()->with('message', 'Permission assigned Succesfully');

    //   }
 
       $role->syncPermissions($request->input('permission'));
       return redirect()->back()->with('message', 'Permission assigned Succesfully');


    }

    public function revokePermission( Role $role , Permission $permission)
    {
      if($role->hasPermissionTo($permission)){
        $role->revokePermissionTo($permission);
         return redirect()->back()->with('message', 'Remove permission');
      }
        return redirect()->back()->with('message', 'Permission not exist');
    }
}
