<?php

namespace Modules\User\Http\Controllers\User;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
    
        return view('user::users.listing');
    }

    public function ajaxListing(Request $request){
        if ($request->ajax()) {
            $data = User::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a class="btn btn-sm global_btn_color"  href="' . route('user.view',['id'=>$row->id]). '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>';
                    $actionBtn =  $actionBtn.'<a class="btn btn-sm global_btn_color"  href="' . route('user.edit',['id'=>$row->id]). '"  type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg></a>';

                    return $actionBtn;
                })
                ->rawColumns(['view', 'action'])
                ->make(true);
        }
    }
  
    public function create()
    {
        $data['roles'] = Role::get();
        return view('user::users.create', $data);
    }

    
    public function store(Request $request)
    {
       
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user =new User();
        $user->name =  $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $user->assignRole($request->role_id);
        session()->flash('message', 'User Add Successfully.');
       return redirect(route('user.listing'));
    }

    public function show(Request $request)
    {
        $data['detail']=User::where('id',$request->id)->first();
        return view('user::users.show', $data);
    }

    public function edit(Request $request)
    {
       
        $data['roles'] = Role::get();
        $data['detail']=User::where('id',$request->id)->first();

        return view('user::users.edit', $data);
    }

    public function update(Request $request){
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        $user =User::find($request->id);
        $user->name =  $request->name;
        $user->email = $request->email;
        $user->save();
        $user->syncRoles([$request->role_id]);
        session()->flash('message', 'Detail Update Successfully.');
        return redirect(route('user.listing'));   
    }
}
