@extends('layouts.app')
@section('content')
<div class="container">
    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Permission</h4>
                        <a class="btn btn-sm global_btn_color" href="{{ url()->previous() }}" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevrons-left">
                                <polyline points="11 17 6 12 11 7"></polyline>
                                <polyline points="18 17 13 12 18 7"></polyline>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('permission.store')}}" autocomplete="off" class="form-horizontal" enctype="multipart/form-data">

                @csrf

               <div class="card">
                  <div class="card-body ">
                     <div class="row">
                        <label class="col-sm-2 col-form-label">Permissison Name</label>
                        <div class="col-sm-7">
                           <div class="form-group bmd-form-group is-filled">
                              <input class="form-control" name="name"  type="text" placeholder="permission" value="" required="">
                              @error('name')
                                  {{$message}}
                              @enderror
                           </div>
                        </div>   
                     </div>
                     <div class="row">
                        <label class="col-sm-2 col-form-label">Module Name</label>
                        <div class="col-sm-7">
                           <div class="form-group bmd-form-group is-filled">
                              <input class="form-control" name="module_name"  type="text" placeholder="module name" value="" required="">
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