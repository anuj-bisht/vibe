@extends('layouts.app')
@section('content')
<div class="container">
   <section id="basic-input">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">Update Details</h4>
                  <a class="btn btn-sm global_btn_color" href="{{ url()->previous() }}" type="submit">
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left">
                        <polyline points="11 17 6 12 11 7"></polyline>
                        <polyline points="18 17 13 12 18 7"></polyline>
                     </svg>
                  </a>
               </div>
            </div>
         </div>
      </div>
      <div class="card-body">
         <form method="post" action="{{url('user/update/permission',$permission->id)}}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            <div class="card">
               <div class="card-body ">
                  <div class="row">
                     <label class="col-sm-2 col-form-label">Permission Name</label>
                     <div class="col-sm-7">
                        <div class="form-group bmd-form-group is-filled">
                           <input class="form-control" name="name" type="text" value="{{$permission->name}}" placeholder="permission" value="" required="">
                           @error('name')
                           {{$message}}
                           @enderror
                        </div>
                     </div>
                  </div>
                  <div class="row mb-0">
                     <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                        {{ __('Update') }}
                        </button>
                     </div>
                  </div>
               </div>
            </div>
         </form>
         <div class="row">
            @if(Session::has('message'))
            <div class="demo-spacing-0">
               <div class="alert alert-success mt-1 alert-validation-msg" role="alert">
                  <div class="alert-body">
                     <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-info mr-50 align-middle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                     </svg>
                     <span>{{Session::get('message')}}</span>
                  </div>
               </div>
            </div>
            @endif
            <div class="row">
               <div class="col-md-12" style='display:flex;'>
                  <span style="color:red;"> <b>Note</b><sup>*</sup>:&nbsp;&nbsp;You can delete these Roles by
                  clicking on particular icon.</span>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12" style='display:flex;'>
                  @if($permission->roles)
                  @foreach ($permission->roles as $permission_role)
                  <form method="post" action="{{url('user/admin/permissions',[$permission->id, $permission_role->id])}}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                     @csrf
                     <span><button type="submit" class="btn btn-info">{{$permission_role->name}}</button></span>
                  </form>
                  @endforeach
                  @endif
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <form method="post" action="{{route('admin.permissions.roles',$permission->id)}}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">
                  @csrf
                  <div class="card">
                     <div class="card-body ">
                        <div class="row">
                           <label class="col-sm-2 col-form-label">Roles</label>
                           <div class="col-sm-7">
                              <div class="form-group bmd-form-group is-filled">
                                 <select name="role" class='form-control' id="role">
                                    <option disabled selected>Select Role</option>
                                    @foreach($roles as $role)
                                    <option value="{{$role->name}}">{{$role->name}}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                        {{ __('Assign Role') }}
                        </button>
                     </div>
                  </div>
            </div>
            </form>
         </div>
      </div>
</div>
</section>
</div>
@endsection