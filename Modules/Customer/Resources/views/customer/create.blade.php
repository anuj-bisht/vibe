@extends('layouts.app')

@include('styles.style')
@section('content')
<style>
    /* select.form-control:not([multiple='multiple']){
    background-image: linear-gradient(45deg, transparent 50%, white 50%), linear-gradient(135deg, white 50%, transparent 50%), linear-gradient(to right, #32AD89, #32AD89);
    background-position: calc(100% - 20px) calc(1em + 2px), calc(100% - 15px) calc(1em + 2px), 100% 0;
    background-size: 5px 5px, 5px 5px, 2.8em 2.8em;
    background-repeat: no-repeat;
    -webkit-appearance: none;
} */
</style>
<div class="container">
    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Customer</h4>
                        <a href="{{route('customer.index')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @php
    {{ $state = Modules\Corporate\Entities\State::get(); }}
    {{ $city = Modules\Corporate\Entities\City::get(); }}
    @endphp

    <section id="multiple-column-form">
        <form method="POST" action="{{route('customer.store')}}">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Name</label>
                                        <input id="text" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" required autofocus>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Email Address</label>
                                        <input id="email" type="email"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" required>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Mobile</label>
                                        <input id="tel" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" maxlength="10"
                                            class="form-control @error('mobile') is-invalid @enderror" name="mobile"
                                            required>
                                        @error('mobile')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Alternate No.</label>
                                        <input id="tel" type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" maxlength="10"
                                            class="form-control @error('alter_no') is-invalid @enderror" name="alter_no"
                                            required>
                                        @error('alter_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Country</label>
                                        <select class="form-control " id="billing_country" name="country" data-index="3"
                                            onchange="getBillingState()">
                                            <option disabled selected>Select Country</option>
                                            @foreach($country as $country)
                                            <option
                                                value='{{$country->id}} {{ old("country") == $country->id ? "selected":"" }}'>
                                                {{$country->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('country')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>

                                {{-- for 2 --}}
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">State</label>
                                        <select class="form-control " id="billing_state" name="state" data-index="3"
                                            onkeydown="setNextField(event)" onchange="getBillingCity()">>
                                            <option disabled selected>Select State</option>
                                            @foreach($state as $State)
                                            <option value={{$State->id}} {{ old("state") == $State->id ? "selected":""
                                                }}>{{$State->name}}</option>
                                            @endforeach

                                        </select>
                                        @error('state')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">City</label>
                                        <select class="form-control " id="billing_city" name="city" data-index="3"
                                            onkeydown="setNextField(event)">
                                            <option disabled selected>Select City</option>
                                            @foreach($city as $City)
                                            <option value={{$City->id}} {{ old("city") == $City->id ? "selected":""
                                                }}>{{$City->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('city')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Age</label>
                                        <input id="text" type="number"
                                            class="form-control @error('age') is-invalid @enderror" name="age"
                                            value="{{ old('age') }}" required>
                                        @error('age')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Gender</label>
                                        <select class="form-control " id="gender" name="gender" data-index="3">
                                            <option disabled selected>Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                        @error('gender')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">DOB</label>
                                        <input type="text" id="fp-default" class="form-control flatpickr-basic"
                                            name="dob" placeholder="YYYY-MM-DD" />
                                        @error('dob')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Aniversary Date</label>
                                        <input type="text" id="fp-default" class="form-control flatpickr-basic"
                                            name="aniversary_date" placeholder="YYYY-MM-DD" />
                                        @error('aniversary_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-1">
                <button class="btn btn-sm global_btn_color"
                    style="background-color: #009973; color:white; border-radius: 10px" type="submit">Submit</button>

            </div>
        </form>
    </section>
</div>
@endsection
<script>
    function getBillingState()
        {

            var billingcountryid = document.getElementById('billing_country').value;
            $('#billing_state').html("<option>Select State</option>");


            $.ajax({
                url:"{{ url('/getbillingstate/') }}/"+billingcountryid,
                type:"GET",
                success:function(response)
                {
                    if(response.status == 200)
                    {
                        var html = "";
                        html = "<option>Select State</option>";
                        $.each(response.data,function(index,el){
                            html += "<option value='"+el.id+"'>"+el.name+"</option>";
                            // console.log(el.name);
                        });
                        $('#billing_state').html(html);
                    }
                    else
                    {
                        $('#billing_state').html("<option>Record Not Found</option>");

                    }
                }
            });
        }

        function getBillingCity()
        {
            var billingstateid = document.getElementById('billing_state').value;
            $('#billing_city').html("<option>Select City</option>");
            $.ajax({
                url:"{{ url('/getbillingcity/') }}/"+billingstateid,
                type:"GET",
                success:function(response)
                {
                    if(response.status == 200)
                    {
                        var html = "";
                        html = "<option>Select City</option>";
                        $.each(response.data,function(index,el){
                            html += "<option value='"+el.id+"'>"+el.name+"</option>";
                            // console.log(el.name);
                        });
                        $('#billing_city').html(html);
                    }
                    else
                    {
                        $('#billing_city').html("<option>Record Not Found</option>");

                    }
                }
            });
        }
</script>
