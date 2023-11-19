@extends('layouts.app')
@section('content')
<div class="container">
   <section id="basic-input">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">Update Details</h4>
                  <a href="{{route('role.listing')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>

               </div>
            </div>
         </div>
      </div>
      <div class="card-body">
         <form method="post" action="{{url('user/update/role',$role->id)}}" autocomplete="off" class="form-horizontal"
            enctype="multipart/form-data">
            @csrf
            <div class="card">
               <div class="card-body">
                  <div class="row">
                     <label class="col-sm-2 col-form-label">Role Name</label>
                     <div class="col-sm-7">
                        <div class="form-group bmd-form-group is-filled">
                           <input class="form-control" name="name" type="text" value="{{$role->name}}"
                              placeholder="role" value="" required="">
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
                     <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-info mr-50 align-middle">
                        <circle cx="12" cy="12" r="10"></circle>
                        <line x1="12" y1="16" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12.01" y2="8"></line>
                     </svg>
                     <span>{{Session::get('message')}}</span>
                  </div>
               </div>
            </div>
            @endif

         </div>
         <div class="row">
            <div class="col-md-12">
               <form method="post" action="{{route('admin.roles.permissions',$role->id)}}" autocomplete="off"
                  class="form-horizontal" enctype="multipart/form-data">
                  @csrf
            </div>
              <!-- User Permissions Starts -->
              {{-- <div class="col-md-12">
               @foreach($modules as $module)
               <!-- User Permissions -->
               <div class="card">
                       <table class="table table-striped table-borderless">
                           <tbody>
                               <tr>
                                   <td>{{ $module['module_name'] }}</td>
                                   @foreach (\Spatie\Permission\Models\Permission::where('module_name', $module['module_name'])->get() as $perm)
                                   <td>
                                       <div class="custom-control custom-checkbox">
                                          {{ $perm->lang_en }} <input type="checkbox" name="permission[]" value="{{ $perm->id }}" class="custom-control-input" id="admin-read{{ $perm->id }}" {{ $role->hasPermissionTo($perm->name) ? 'checked' : null }}/>
                                         <label class="custom-control-label" for="admin-read{{ $perm->id }}"></label>
                                       </div>
                                   </td>
                                   @endforeach
                               </tr>
                           </tbody>
                       </table>
                   
               </div>
               @endforeach
           </div> --}}






           <div class="col-md-12">
            @foreach($modules as $module)
            <!-- User Permissions -->
            <div class="card">
                    <table class="table table-striped table-borderless">
                        <tbody>
                            <tr>
                                
                                 <td style="text-align: center; background-image: linear-gradient(45deg,#3ea88d,green); color:white; font-weight:500;">{{ $module['module_name'] }}</td>
                                 <tr style="display:flex; flex-wrap:wrap;">
                                @foreach (\Spatie\Permission\Models\Permission::where('module_name', $module['module_name'])->get() as $perm)
                                <td>
                                    <div class="custom-control custom-checkbox">
                                       {{ $perm->lang_en }} <input type="checkbox" name="permission[]" value="{{ $perm->id }}" class="custom-control-input" id="admin-read{{ $perm->id }}" {{ $role->hasPermissionTo($perm->name) ? 'checked' : null }}/>
                                      <label class="custom-control-label" for="admin-read{{ $perm->id }}"></label>
                                    </div>
                                </td>
                                @endforeach
                              </tr>
                              
                            </tr>
                        </tbody>
                    </table>
                
            </div>
            @endforeach
        </div>

            <div class="col-md-12 offset-md-4">
               <button type="submit" class="btn btn-primary">
                  {{ __('Assign Permission') }}
               </button>
         </div>
         </form>
         </div>
      </div>
  
   </section>
</div>
@endsection