


@extends('layouts.app')

@section('content')
<div class="container">

        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Petty Head</h4>
                            <a href="{{route('master.pettyhead')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>

                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <form class="needs-validation" novalidate method="POST" action="{{route('master.pettyhead.store')}}">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12 col-12 mb-3">

                            <label for="validationTooltip01">Petty Head</label>
                            <input type="text" class="form-control" name="petty_head" placeholder="Petty Head"  required autofocus oninput="this.value = this.value.toUpperCase()"/>
                            @error('petty_head')
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
