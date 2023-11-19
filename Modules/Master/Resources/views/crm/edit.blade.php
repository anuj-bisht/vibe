


@extends('layouts.app')

@section('content')
<div class="container">
        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit CRM</h4>
                            <a class="btn btn-sm global_btn_color" href="{{ url()->previous() }}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg></a>

                        </div>

                    </div>
                </div>
            </div>
                <div class="row">
                    <div class="col-md-12">
                        <form class="needs-validation" novalidate method="POST" action="{{route('master.crm.update',['id'=>$crm->id])}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                      
                        <div class="col-md-3 col-3 mb-3">
                            <label for="validationTooltip01">CRM Name</label>
                            <input type="text" class="form-control" name="crm_name" value="{{$crm->crm_name}}" placeholder="CRM Name" required autofocus />
                            @error('crm_name')
                            <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                        </div>
                        <div class="col-md-3 col-3 mb-3">
                            <label for="validationTooltip01">Designation</label>
                            <input type="text" class="form-control" name="designation" value="{{$crm->designation}}" placeholder="Designation" required autofocus />
                            @error('designation')
                            <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                        </div>
                        <div class="col-md-3 col-3 mb-3">
                            <label for="validationTooltip01">Address</label>
                            <input type="text" class="form-control" name="address" value="{{$crm->address}}" placeholder="Address" required autofocus />
                            @error('address')
                            <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                        </div>
                        <div class="col-md-3 col-3 mb-3">
                            <label for="validationTooltip01">Mobile</label>
                            <input type="number" class="form-control" name="mobile" value="{{$crm->mobile}}" placeholder="Mobile" required autofocus />
                            @error('mobile')
                            <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                        </div>
                        <div class="col-md-3 col-3 mb-3">
                            <label for="validationTooltip01">Email</label>
                            <input type="email" class="form-control" name="email" value="{{$crm->email}}" placeholder="Email" required autofocus />
                            @error('email')
                            <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                        </div>
                        <div class="col-md-3 col-3 mb-3">
                            <label for="validationTooltip01">Photo</label>
                            <input type="file" class="form-control" name="photo" placeholder="Photo" required autofocus />
                            @isset($crm->photo)
                            <a href="{{asset('crmImages/'.$crm->photo)}}" target="_blank">

                            <img style="width:120px; height:120px; border-radius:50%; object-fit:contain;"  src={{asset('crmImages/'.$crm->photo)}} alt="Image"/>
                            </a>
                            @endisset
                            @error('photo')
                            <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                        </div>
                    


                    </div>
                    <input type="hidden"  value="{{$crm->photo}}"  name="image1" />

                    <button class="btn global_btn_color" type="submit">Submit</button>
                </form>
            </div>
        </div>
            </div>
        </section>

</div>
@endsection
