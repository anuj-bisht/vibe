@extends('layouts.app')
@section('content')
<div class="container">
    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Role</h4>
                        <a href="{{route('role.listing')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('role.store')}}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">

                @csrf

               <div class="card">
                  <div class="card-body ">
                     <div class="row">
                        <label class="col-sm-2 col-form-label">Role Name</label>
                        <div class="col-sm-7">
                           <div class="form-group bmd-form-group is-filled">
                              <input class="form-control" name="name"  type="text" placeholder="role" value="" required="">
                              @error('name')
                                  {{$message}}
                              @enderror
                           </div>
                        </div>   
                     </div>
                     <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Submit') }}
                            </button>
                        </div>
                  </div>
              
               </div>
             
            </div>
            </form>
        </div>
</div>
</section>
</div>
@endsection