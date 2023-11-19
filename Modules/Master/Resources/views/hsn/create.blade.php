


@extends('layouts.app')

@section('content')
<div class="container">

        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add HSN</h4>
                            <a class="btn btn-sm global_btn_color" href="{{ url()->previous() }}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg></a>

                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <form class="needs-validation" novalidate method="POST" action="{{route('master.hsn.store')}}">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12 col-12 mb-3">

                            <label for="validationTooltip01">HSN</label>
                            <input type="text" class="form-control" name="code" placeholder="HSN"  required autofocus oninput="this.value = this.value.toUpperCase()"/>
                            @error('code')
                            <h5 class="alert alert-danger">{{$message}}</h5>
                        @enderror
                        </div>
                        <div class="col-md-12 col-12 mb-3">

                            <label for="validationTooltip01">Value</label>
                            <input type="text" class="form-control" name="hsn_value" placeholder="Value"  required oninput="this.value = this.value.toUpperCase()"/>
                            @error('hsn_value')
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
