


@extends('layouts.app')
@include('styles.style')
@section('content')
<style>
select.form-control:not([multiple='multiple']){
    background-image: linear-gradient(45deg, transparent 50%, white 50%), linear-gradient(135deg, white 50%, transparent 50%), linear-gradient(to right, #32AD89, #32AD89);
    background-position: calc(100% - 20px) calc(1em + 2px), calc(100% - 15px) calc(1em + 2px), 100% 0;
    background-size: 5px 5px, 5px 5px, 2.8em 2.8em;
    background-repeat: no-repeat;
    -webkit-appearance: none;
}

</style>

<div class="container">

    <form class="form" method="POST" action={{route('corporate.store')}} id="inputform">
        @csrf
    <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" style=" ">Create Corporate Clients</h4>
                            <h4 class="card-title "  style="color: #009973; "><span id="product_gender_id"></span ><span id="product_fabric_id"></span><span id="product_style_id"></span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="product_color_id"></span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="product_size_id"></span></h4>
                            <span>
                                <a href="{{route('corporate.index')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>

                            </span>
                        </div>

                    </div>
                </div>
            </div>


        </section>

{{-- Client Details Section --}}
        <section id="multiple-column-form">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
                            <span style="display:flex; justify-content:space-between;">
                            <h4 class="card-title" style=" ">Client Details</h4>
                            <div>
                                <div class="demo-inline-spacing">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="is_retail" id="inlineRadio1" value="1" onclick="selectCorporate('retail');" />
                                        <label class="form-check-label" for="inlineRadio1">Retail</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" checked type="radio" name="is_retail" id="inlineRadio1" value="0" onclick="selectCorporate('corporate');"/>
                                        <label class="form-check-label" for="inlineRadio2">Corporate</label>
                                    </div>
                                   
                                </div>
                                @error('is_retail')
                                <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                            </div>
                            </span>

                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Name</label>
                                            <input type="text" id="name"  class="form-control" data-index="1" value="{{ old('name')}}" placeholder="Name"  name="name"  autofocus onkeydown="setNextField(event)"/>
                                            @error('name')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-12" style="display: none;" id="cashdays">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Days of cash transfer</label>
                                            <input type="number" id="days"  class="form-control" data-index="2" value="{{ old('cashdays')}}" placeholder="Days"  name="cashdays" onkeydown="setNextField(event)"/>
                                            @error('name')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    {{-- for 1 --}}
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Contact Person 1</label>
                                            <input type="text"  class="form-control" data-index="3" placeholder="Contact Person 1"  value="{{ old('contact_person_1')}}" name="contact_person_1" onkeydown="setNextField(event)"/>
                                            @error('contact_person_1')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Designation 1</label>
                                            <input type="text"  class="form-control" data-index="4" placeholder="Designation 1" value="{{ old('designation_1')}}"  name="designation_1" onkeydown="setNextField(event)"/>
                                            @error('designation_1')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Mobile Number 1</label>
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" maxlength="10"  class="form-control" data-index="5" placeholder="Mobile Number 1" value="{{ old('mobile_number_1')}}"  name="mobile_number_1" onkeydown="setNextField(event)"/>
                                            @error('mobile_number_1')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Email Id 1</label>
                                            <input type="email"  class="form-control" data-index="6"  placeholder="Email Id 1"   value="{{ old('email_id_1')}}" name="email_id_1" onkeydown="setNextField(event)"/>
                                            @error('email_id_1')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>

                                    {{-- for 2 --}}
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Contact Person 2</label>
                                            <input type="text"  class="form-control" data-index="7"  placeholder="Contact Person 2"   value="{{ old('contact_person_2')}}" name="contact_person_2" onkeydown="setNextField(event)"/>
                                            @error('contact_person_2')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Designation 2</label>
                                            <input type="text"  class="form-control" data-index="8"  placeholder="Designation 2"  value="{{ old('designation_2')}}"  name="designation_2" onkeydown="setNextField(event)"/>
                                            @error('designation_2')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Mobile Number 2</label>
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" maxlength="10"  class="form-control" data-index="9"  placeholder="Mobile Number 2"  value="{{ old('mobile_number_2')}}"  name="mobile_number_2" onkeydown="setNextField(event)"/>
                                            @error('mobile_number_2')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Email Id 2</label>
                                            <input type="email"  class="form-control" data-index="10"  placeholder="Email Id 2"  value="{{ old('email_id_2')}}"  name="email_id_2" onkeydown="setNextField(event)"/>
                                            @error('email_id_2')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    {{-- for 3 --}}
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Contact Person 3</label>
                                            <input type="text"  class="form-control" data-index="11"  placeholder="Contact Person 3"  value="{{ old('contact_person_3')}}"  name="contact_person_3" onkeydown="setNextField(event)"/>
                                            @error('contact_person_3')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Designation 3</label>
                                            <input type="text"  class="form-control" data-index="12"  placeholder="Designation 3"   value="{{ old('designation_3')}}" name="designation_3" onkeydown="setNextField(event)"/>
                                            @error('designation_3')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Mobile Number 3</label>
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" maxlength="10"  class="form-control" data-index="13"  placeholder="Mobile Number 3"  value="{{ old('mobile_number_3')}}"  name="mobile_number_3" onkeydown="setNextField(event)"/>
                                            @error('mobile_number_3')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Email Id 3</label>
                                            <input type="email"  class="form-control" data-index="14"  placeholder="Email Id 3"  value="{{ old('email_id_3')}}"  name="email_id_3" onkeydown="setNextField(event)"/>
                                            @error('email_id_3')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>

                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                @php
                {{ $state = Modules\Corporate\Entities\State::get(); }}
                {{ $city = Modules\Corporate\Entities\City::get(); }}
             

                @endphp
               
{{-- Billing Address --}}
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title" style=" ">Billing Address</h4>


                        <div class="row">
                            {{-- for 1 --}}
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="city-column" style=" ">Address</label>
                                    <input type="text"  class="form-control" data-index="15"  placeholder="Address"  value="{{ old('billing_address')}}"  name="billing_address"  onkeydown="setNextField(event)"/>
                                    @error('billing_address')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" style=" ">Country</label>
                                    <select class="form-control select2" data-index="16" id="billing_country" name="billing_country"     onchange="getBillingState()" onkeydown="setNextField(event)">
                                        <option disabled selected>Select Country</option>
                                       @foreach($country as $country)
                                       <option  value={{$country->id}} {{ old("billing_country") == $country->id ? "selected":"" }}>{{$country->name}}</option>
                                       @endforeach
                                    </select>
                                    @error('billing_country')
                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                   @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" style=" ">State</label>
                                    <select class="form-control select2" data-index="17" id="billing_state" name="billing_state"     onchange="getBillingCity()" onkeydown="setNextField(event)">
                                        <option disabled selected>Select State</option>
                                        @foreach($state as $State)
                                        <option value={{$State->id}} {{ old("billing_state") == $State->id ? "selected":"" }}>{{$State->name}}</option>
                                        @endforeach

                                    </select>
                                    @error('billing_state')
                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                   @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" style=" ">City</label>
                                    <select class="form-control select2" data-index="18" id="billing_city" name="billing_city"  onkeydown="setNextField(event)">
                                        <option disabled selected>Select City</option>
                                        @foreach($city as $City)
                                        <option value={{$City->id}} {{ old("billing_city") == $City->id ? "selected":"" }}>{{$City->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('billing_city')
                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                   @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" style=" ">Zip Code</label>
                                    <input type="text"  class="form-control" data-index="19"  placeholder="Zip Code"  value="{{ old('billing_zip_code')}}"  name="billing_zip_code" onkeydown="setNextField(event)"/>
                                    @error('billing_zip_code')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                @enderror
                                </div>
                            </div>


                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        {{-- Delivery Address --}}
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title" style=" ">Delivery Address</h4>


                        <div class="row">
                            {{-- for 1 --}}
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="city-column" style=" ">Address <sup style="class:red;">*</sup></label>
                                    <input type="text"  class="form-control"  data-index="20" placeholder="Address"  value="{{ old('delivery_address')}}"  name="delivery_address" onkeydown="setNextField(event)"/>
                                    @error('delivery_address')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                @enderror
                                </div>
                            </div>

                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" style=" ">Country</label>
                                    <select class="form-control" id="delivery_country" name="delivery_country"  data-index="21"    onchange="getDeliveryState()" onkeydown="setNextField(event)">
                                        <option disabled selected>Select Country</option>
                                       @foreach($dcountry as $country)
                                       <option  value={{$country->id}} {{ old("delivery_country") == $country->id ? "selected":"" }}>{{$country->name}}</option>
                                       @endforeach
                                    </select>
                                    @error('delivery_country')
                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                   @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" style=" ">State</label>
                                    <select class="form-control " id="delivery_state" name="delivery_state" data-index="22"    onchange="getDeliveryCity()" onkeydown="setNextField(event)">
                                        <option disabled selected>Select State</option>
                                        @foreach($state as $State)
                                        <option value={{$State->id}} {{ old("delivery_state") == $State->id ? "selected":"" }}>{{$State->name}}</option>
                                        @endforeach

                                    </select>
                                    @error('delivery_state')
                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                   @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" style=" ">City</label>
                                    <select class="form-control select2" id="delivery_city" data-index="23" name="delivery_city" onkeydown="setNextField(event)"  >
                                        <option disabled selected>Select City</option>
                                        @foreach($city as $City)
                                        <option value={{$City->id}} {{ old("delivery_city") == $City->id ? "selected":"" }}>{{$City->name}}</option>
                                        @endforeach

                                    </select>
                                    @error('delivery_city')
                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                   @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" style=" ">Zip Code</label>
                                    <input type="text"  class="form-control"  placeholder="Zip Code" data-index="24"  value="{{ old('delivery_zip_code')}}"  name="delivery_zip_code" onkeydown="setNextField(event)"/>
                                    @error('delivery_zip_code')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                @enderror
                                </div>
                            </div>


                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        {{-- Account Details --}}
        <section id="multiple-column-form">
            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="card-title" style=" ">Account Details</h4>

                                <div class="row">

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">GST Number</label> 
                                            <input type="text" id="city-column"  class="form-control" data-index="25"  placeholder="GST Number"   value="{{ old('gst_number')}}" name="gst_number" onkeydown="setNextField(event)"/>
                                            @error('gst_number')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column" style=" ">Credit Days</label>
                                            <input type="text" id="first-name-column" class="form-control" data-index="26"  placeholder="Credit Days"  value="{{ old('credit_days')}}" name="credit_days" value="{{old('credit_days')}}" onkeydown="setNextField(event)"/>
                                            @error('credit_days')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column" style=" ">Credit Limit</label>
                                            <input type="text" id="first-name-column" class="form-control" data-index="27" placeholder="Credit Limit"  value="{{ old('credit_limit')}}" name="credit_limit" value="{{old('credit_limit')}}" onkeydown="setNextField(event)"/>
                                            @error('credit_limit')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Cash Discount</label>
                                            <a style="float: right;" href="{{route('master.discount.create')}}" target="_blank" style="color:blue; ">Create</a>
                                            <select class="form-control select2" id="discount_id" name="discount_id" data-index="28"   onkeydown="setNextField(event)" >
                                                <option disabled selected>Select Discount</option>
                                               @foreach($discount as $discount)
                                               <option  value={{$discount->id}} {{ old("discount_id") == $discount->id ? "selected":"" }}>{{$discount->percent}}</option>
                                               @endforeach
                                            </select>
                                            @error('discount_id')
                                               <h5 class="alert alert-danger">{{$message}}</h5>
                                           @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column" style=" ">CRM</label>
                                            <a style="float: right;" href="{{route('master.crm.create')}}" target="_blank" style="color:blue; ">Create</a>
                                            <select class="form-control select2" id="crm_id" name="crm_id" data-index="29" onkeydown="setNextField(event)">
                                                <option disabled selected>Select CRM</option>
                                               @foreach($crm as $crm)
                                               <option  value={{$crm->id}}  {{ old("crm_id") == $crm->id ? "selected":"" }}>{{$crm->crm_name}}</option>
                                               @endforeach
                                            </select>
                                            @error('crm_id')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column" style=" ">Commission</label>
                                            <a style="float: right;" href="{{route('master.commission.create')}}" target="_blank" style="color:blue; ">Create</a>
                                            <select class="form-control select2" id="commission_id"   name="commission_id" data-index="30"  onkeydown="setNextField(event)">

                                            <option disabled selected>Select Commission</option>
                                               @foreach($commission as $commission)
                                               <option   value={{$commission->id}} {{ old("commission_id") == $commission->id ? "selected":"" }}>{{$commission->code}}</option>
                                               @endforeach
                                            </select>
                                            @error('commission_id')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Agent</label>
                                            <a style="float: right;"  href="{{route('master.agent.create')}}" target="_blank" style="color:blue; ">Create</a>
                                            <select class="form-control select2" id="agent_id" name="agent_id" data-index="31"  onkeydown="setNextField(event)" >
                                                <option disabled selected>Select Agent</option>
                                               @foreach($agent as $agent)
                                               <option value={{$agent->id}} {{ old("agent_id") == $agent->id ? "selected":"" }}>{{$agent->name}}</option>
                                               @endforeach
                                            </select>
                                            @error('agent_id')
                                               <h5 class="alert alert-danger">{{$message}}</h5>
                                           @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Transport</label>
                                            <a style="float: right;" href="{{route('master.transport.create')}}" target="_blank" style="color:blue; ">Create</a>
                                            <select class="form-control select2" id="transport" name="transport_id"  data-index="32"  onkeydown="setNextField(event)">
                                                <option disabled selected>Select Transport</option>
                                               @foreach($transport as $transport)
                                               <option  value={{$transport->id}} {{ old("transport_id") == $transport->id ? "selected":"" }}>{{$transport->name}}</option>
                                               @endforeach
                                            </select>
                                            @error('transport_id')
                                               <h5 class="alert alert-danger">{{$message}}</h5>
                                           @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-4">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">A</label>
                                            <input type="number"   class="form-control"    value="{{ old('marginA')}}" data-index="33" name="marginA" onkeydown="setNextField(event)"/>
                                    
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-4">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">B</label>
                                            <input type="number"   class="form-control"    value="{{ old('marginB')}}" data-index="34" name="marginB" onkeydown="setNextField(event)"/>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-4">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">C</label>
                                            <input type="number"   class="form-control"    value="{{ old('marginC')}}" data-index="35" name="marginC" onkeydown="setNextField(event)"/>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-4">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">D</label>
                                            <input type="number"   class="form-control"    value="{{ old('marginD')}}" data-index="36" name="marginD" onkeydown="setNextField(event)"/>
                                        </div>
                                    </div>


                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>



                 {{-- Other Details --}}
        <section id="multiple-column-form">
            <div class="row">
                <div class="col-12">
                    <div class="card">


                        <div class="card-body">
                            <h4 class="card-title" style=" ">Other Details</h4>

                                <div class="row">

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Communication</label>
                                            <div class="d-flex">
                                            <label class="pr-3">Email <input type="checkbox"  data-index="37" placeholder="" value="email" name="communication" onkeydown="setNextField(event)"></label>
                                            <label class="pr-3">Whatsapp <input type="checkbox" placeholder=""  data-index="38" value="whatsapp" name="communication" onkeydown="setNextField(event)"></label>
                                            <label class="pr-3">SMS <input type="checkbox" placeholder="" value="sms" data-index="39" name="communication" onkeydown="setNextField(event)"></label>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column" style=" ">Transporter Charges to Be borne by Client (Yes/NO) </label>
                                            <div class="d-flex">
                                                <label class="pr-3">Yes <input type="radio" placeholder="" data-index="40" value="yes" name="charge"></label>
                                                <label class="pr-3">No <input type="radio" placeholder="" value="no" data-index="41" name="charge"></label>
                                                </div>
                                        </div>
                                        @error('charge')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                    @enderror
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column" style=" ">Client Status (Active / Inactive) </label>
                                            <div class="d-flex">
                                                <label class="pr-3">Active <input type="radio" placeholder="" data-index="42" value="active" name="status"></label>
                                                <label class="pr-3">Inactive <input type="radio" placeholder="" data-index="43" value="inactive" name="status"></label>
                                                </div>
                                        </div>
                                        @error('status')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                    @enderror
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>




                                <button class="btn btn-sm global_btn_color" style="background-color: #009973; color:white; border-radius: 10px" type="submit">Submit</button>

                            </form>

                        </div>



@endsection
@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
<script>
        function setNextField(event){
    if(event.which ==  13){
        event.preventDefault();
        var $this = $(event.target);
        var index = parseFloat($this.attr('data-index'));
        $('[data-index="' + (index + 1).toString() + '"]').focus();
    };
  }

//   if($("input[name='is_retail']:checked").val() == 0){
//         alert('s');
//     var index = 2;
//     $('[data-index="' + (index + 1).toString() + '"]').focus();
// }
// if($("input[name='is_retail']:checked").val() == 1){
//    var  index = 1
//     $('[data-index="' + (index + 1).toString() + '"]').focus();

// }  

</script>
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


        function getDeliveryState()
        {

            var deliverycountryid = document.getElementById('delivery_country').value;
            $('#delivery_state').html("<option>Select State</option>");


            $.ajax({
                url:"{{ url('/getdeliverystate/') }}/"+deliverycountryid,
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
                        $('#delivery_state').html(html);
                    }
                    else
                    {
                        $('#delivery_state').html("<option>Record Not Found</option>");

                    }
                }
            });
        }

        function getDeliveryCity()
        {

            var deliverystateid = document.getElementById('delivery_state').value;
            $('#delivery_city').html("<option>Select City</option>");
            $.ajax({
                url:"{{ url('/getdeliverycity/') }}/"+deliverystateid,
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
                        $('#delivery_city').html(html);
                    }
                    else
                    {
                        $('#delivery_city').html("<option>Record Not Found</option>");

                    }
                }
            });
        }

       function  selectCorporate(name){
        if(name == 'retail'){
         $('#cashdays').show();
       }else{
        $('#cashdays').hide();
       }
    }

    $('#name').keydown(function(e){
        alert($("input[name='is_retail']:checked").val());
    if(e.which == 13){
        
        if($("input[name='is_retail']:checked").val() == 0){
          $('[data-index="3"]').focus();
        }
        if($("input[name='is_retail']:checked").val() == 1){
            $('[data-index="2"]').focus();

        }
    }
});


</script>


@endpush






