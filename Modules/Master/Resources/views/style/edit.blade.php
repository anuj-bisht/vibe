


@extends('layouts.app')

@section('content')
<div class="container">

        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Style</h4>
                            <a href="{{route('master.style')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <form class="needs-validation" novalidate method="POST" action="{{route('master.style.update',['id'=>$style->id])}}">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12 col-12 mb-3">

                            <label for="validationTooltip01">Style Code</label>
                            <input type="text" class="form-control" name="code" placeholder="Style Code" value="{{$style->code}}"  required autofocus oninput="this.value = this.value.toUpperCase()"/>
                            @error('code')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                        </div>

                        <div class="col-md-12 col-12 mb-3">

                            <label for="validationTooltip01">Style Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Style Name" value="{{$style->name}}"  required oninput="this.value = this.value.toUpperCase()"/>
                            @error('name')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                        </div>



                    </div>
                    <button class="btn global_btn_color" type="submit">Submit</button>
                </form>
            </div>
        </div>
        </section>

</div>
@endsection
