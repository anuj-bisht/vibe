@extends('layouts.app')

@section('content')
<div class="container">
    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Agent</h4>
                        <a class="btn btn-sm global_btn_color" href="{{ url()->previous() }}" type="submit"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevrons-left">
                                <polyline points="11 17 6 12 11 7"></polyline>
                                <polyline points="18 17 13 12 18 7"></polyline>
                            </svg></a>

                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form class="needs-validation" novalidate method="POST"
                    action="{{route('master.agent.update',['id'=>$agent->id])}}"  enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-3 col-3 mb-3">

                            <label for="validationTooltip01">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="name"
                                value="{{$agent->name}}" required autofocus />
                            @error('name')
                            <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                        </div>
                        <div class="col-md-3 col-3 mb-3">

                            <label for="validationTooltip01">Address</label>
                            <input type="text" class="form-control" name="address"  value="{{$agent->address}}" placeholder="Address" required />
                            @error('address')
                            <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                        </div>
                        <div class="col-md-3 col-3 mb-3">

                            <label for="validationTooltip01">Mob</label>
                            <input type="number" class="form-control" name="mobile"  value="{{$agent->mobile}}" placeholder="Mobile" required />
                            @error('mobile')
                            <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                        </div>
                        <div class="col-md-3 col-3 mb-3">

                            <label for="validationTooltip01">Email</label>
                            <input type="email" class="form-control" name="email"  value="{{$agent->email}}" placeholder="Name" required />
                            @error('email')
                            <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                        </div>
                        <div class="col-md-3 col-3 mb-3">

                            <label for="validationTooltip01">Photo</label>
                            <input type="file" class="form-control" name="photo" placeholder="Upload" required />
                            @error('photo')
                            <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                            
                            @isset($agent->photo)
                            <a href="{{asset('AgentImage/'.$agent->photo)}}" target="_blank">

                            <img style="width:120px; height:120px; border-radius:50%; object-fit:contain;"  src={{asset('AgentImage/'.$agent->photo)}} alt="Image"/>
                            </a>
                            @endisset
                        </div>


                    </div>
                    <input type="hidden"  value="{{$agent->photo}}"  name="image1" />

                    <button class="btn global_btn_color" type="submit">Submit</button>
                </form>
            </div>
        </div>
</div>
</section>

</div>
@endsection