


@extends('layouts.app')
@include('styles.style')
@section('content')
<div class="container">

        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Gender</h4>
                            <a class="btn btn-sm global_btn_color" href="{{ url()->previous() }}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg></a>

                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <form class="" novalidate method="POST" action="{{route('master.gender.store')}}">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12 col-12 mb-3">

                            <div class="form-group">
                                <label for="basicSelect">Select Gender</label>
                                <select class="form-control select2" id="gender" name="gender">
                                    <option disabled selected>Select Gender</option>
                                    <option value="Gents">Gents</option>
                                    <option value="Ladies">Ladies</option>

                                </select>
                                @error('gender')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                            </div>
                        </div>



                    </div>
                    <button class="btn global_btn_color" type="submit">Submit</button>
                </form>
            </div>





                </div>
            </div>
        </section>

</div>
@endsection
@section('scripts')
    <!-- BEGIN: Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{asset('app-assets/js/core/app-menu.js')}}"></script>
    <script src="{{asset('app-assets/js/core/app.js')}}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{asset('app-assets/js/scripts/forms/form-select2.js')}}"></script>

@endsection
