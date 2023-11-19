


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

    <form class="form" method="POST" action={{route('corporate.update',['id'=>$corporate->id])}} id="inputform">
        @csrf
    <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" >Edit Corporate Clients</h4>
                            <h4 class="card-title "  style="color: #009973; font-weight:bold;"><span id="product_gender_id"></span ><span id="product_fabric_id"></span><span id="product_style_id"></span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="product_color_id"></span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="product_size_id"></span></h4>
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
                                            <input class="form-check-input"  @if($corporate->is_retail==1) checked @endif  type="radio" name="is_retail" id="inlineRadio1" value="1" onclick="selectCorporate('retail');"/>
                                            <label class="form-check-label" for="inlineRadio1">Retail</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" @if($corporate->is_retail==0) checked @endif name="is_retail" id="inlineRadio2" value="0" onclick="selectCorporate('corporate');"/>
                                            <label class="form-check-label" for="inlineRadio2">Corporate</label>
                                        </div>
                                       
                                    </div>
                                    @error('is_retail')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                @enderror
                                </div>
                                </span>
                            @if($errors->any())
                            <h6 class="alert alert-danger">{{$errors->first()}}</h6>
                            @endif
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Name</label>
                                            <input type="text"  class="form-control" id="name" data-index="1" placeholder="Name" value="{{$corporate->name}}"  name="name" autofocus onkeydown="setNextField(event)"/>
                                            @error('name')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-12" style="display: @if($corporate->is_retail != 1) none @endif" id="cashdays">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">Days of cash transfer</label>
                                            <input type="number" id="days"  class="form-control" data-index="2" value="{{$corporate->cash_deliver}}" placeholder="Days"   name="cashdays" onkeydown="setNextField(event)"/>
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
                                            <label for="city-column" >Contact Person 1</label>
                                            <input type="text"  class="form-control" data-index="3" placeholder="Contact Person 1" value="{{$corporate->contact_person_1}}"  name="contact_person_1" onkeydown="setNextField(event)"/>
                                            @error('contact_person_1')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Designation 1</label>
                                            <input type="text"  class="form-control" data-index="4" placeholder="Designation 1" value="{{$corporate->designation_1}}"  name="designation_1" onkeydown="setNextField(event)"/>
                                            @error('designation_1')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Mobile Number 1</label>
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" maxlength="10"  class="form-control" data-index="5" placeholder="Mobile Number 1" value="{{$corporate->mobile_no_1}}"  name="mobile_number_1" onkeydown="setNextField(event)"/>
                                            @error('mobile_number_1')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Email Id 1</label>
                                            <input type="email"  class="form-control" data-index="6" placeholder="Email Id 1" value="{{$corporate->email_id_1}}"  name="email_id_1" onkeydown="setNextField(event)"/>
                                            @error('email_id_1')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>

                                    {{-- for 2 --}}
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Contact Person 2</label>
                                            <input type="text"  class="form-control" data-index="7" placeholder="Contact Person 2" value="{{$corporate->contact_person_2}}"  name="contact_person_2" onkeydown="setNextField(event)" />
                                            @error('contact_person_2')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Designation 2</label>
                                            <input type="text"  class="form-control" data-index="8" placeholder="Designation 2"  value="{{$corporate->designation_1}}"  name="designation_2" onkeydown="setNextField(event)"/>
                                            @error('designation_2')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Mobile Number 2</label>
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" maxlength="10"  class="form-control" data-index="9" placeholder="Mobile Number 2" value="{{$corporate->mobile_no_2}}"  name="mobile_number_2" onkeydown="setNextField(event)"/>
                                            @error('mobile_number_2')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Email Id 2</label>
                                            <input type="email"  class="form-control" data-index="10" placeholder="Email Id 2"  value="{{$corporate->email_id_2}}"   name="email_id_2" onkeydown="setNextField(event)"/>
                                            @error('email_id_2')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    {{-- for 3 --}}
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Contact Person 3</label>
                                            <input type="text"  class="form-control" data-index="11" placeholder="Contact Person 3" value="{{$corporate->contact_person_3}}"  name="contact_person_3" onkeydown="setNextField(event)"/>
                                            @error('contact_person_3')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Designation 3</label>
                                            <input type="text"  class="form-control" data-index="12" placeholder="Designation 3"  value="{{$corporate->designation_1}}"  name="designation_3" onkeydown="setNextField(event)"/>
                                            @error('designation_3')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Mobile Number 3</label>
                                            <input type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');" maxlength="10"  class="form-control" data-index="13" placeholder="Mobile Number 3" value="{{$corporate->mobile_no_3}}"  name="mobile_number_3" onkeydown="setNextField(event)"/>
                                            @error('mobile_number_3')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Email Id 3</label>
                                            <input type="email"  class="form-control" data-index="14" placeholder="Email Id 3"  value="{{$corporate->email_id_3}}"   name="email_id_3" onkeydown="setNextField(event)"/>
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

           
{{-- Billing Address --}}
<section id="multiple-column-form">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <h4 class="card-title" >Billing Address</h4>


                        <div class="row">
                            {{-- for 1 --}}
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="city-column" >Address</label>
                                    <input type="text"  class="form-control" data-index="15" placeholder="Address"  value="{{$corporate->billing_address}}"  name="billing_address" onkeydown="setNextField(event)"/>
                                    @error('billing_address')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" >Country</label>


                                    <select class="form-control select2" id="billing_country" name="billing_country" data-index="16"    onchange="getBillingState()" onkeydown="setNextField(event)">
                                        <option disabled selected>Select Country</option>
                                        @foreach($dcountry as $country)

                                        @if($country->id == $corporate->bcountry_id)
                                        <option selected value={{$country->id}}>
                                        @else
                                        <option  value={{$country->id}}>
                                        @endif
                                            {{$country->name}}</option>
                                        @endforeach
                                    </select>

                                    @error('billing_country')
                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                   @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" >State</label>
                                    <select class="form-control select2" id="billing_state" name="billing_state" data-index="17" onchange="getBillingCity()" onkeydown="setNextField(event)">
                                        <option value="{{$corporate->billing_states->id}}">{{$corporate->billing_states->name}}</option>


                                    </select>
                                    @error('billing_state')
                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                   @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" >City</label>
                                    <select class="form-control select2" id="billing_city" name="billing_city" data-index="18"  onkeydown="setNextField(event)" >
                                        <option value="{{$corporate->billing_citys->id}}">{{$corporate->billing_citys->name}}</option>

                                    </select>
                                    @error('billing_city')
                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                   @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" >Zip Code</label>
                                    <input type="text"  class="form-control" data-index="19" placeholder="Zip Code" value="{{$corporate->billing_zip_code}}"  name="billing_zip_code" onkeydown="setNextField(event)"/>
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
                    <h4 class="card-title" >Delivery Address</h4>


                        <div class="row">
                            {{-- for 1 --}}
                            <div class="col-md-12 col-12">
                                <div class="form-group">
                                    <label for="city-column" >Address</label>
                                    <input type="text"  class="form-control" data-index="20" placeholder="Address"  value="{{$corporate->delivery_address}}"  name="delivery_address" onkeydown="setNextField(event)"/>
                                    @error('delivery_address')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" >Country</label>



                                    <select class="form-control select2" id="delivery_country" name="delivery_country" data-index="21"   onchange="getDeliveryState()" onkeydown="setNextField(event)">
                                        <option disabled selected>Select Country</option>
                                        @foreach($dcountry as $country)

                                        @if($country->id == $corporate->dcountry_id)
                                        <option selected value={{$country->id}}>
                                        @else
                                        <option  value={{$country->id}}>
                                        @endif
                                            {{$country->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('delivery_country')
                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                   @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" >State</label>
                                    <select class="form-control select2" id="delivery_state" name="delivery_state" data-index="22"    onchange="getDeliveryCity()" onkeydown="setNextField(event)">
                                        <option value="{{$corporate->delivery_states->id}}">{{$corporate->delivery_states->name}}</option>


                                    </select>
                                    @error('delivery_state')
                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                   @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" >City</label>
                                    <select class="form-control select2" id="delivery_city" name="delivery_city" data-index="23"  onkeydown="setNextField(event)" >
                                        <option value="{{$corporate->delivery_citys->id}}">{{$corporate->delivery_citys->name}}</option>


                                    </select>
                                    @error('delivery_city')
                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                   @enderror
                                </div>
                            </div>
                            <div class="col-md-3 col-12">
                                <div class="form-group">
                                    <label for="city-column" >Zip Code</label>
                                    <input type="text"  class="form-control" data-index="24" placeholder="Zip Code"  value="{{$corporate->delivery_zip_code}}"  name="delivery_zip_code" onkeydown="setNextField(event)"/>
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
                            <h4 class="card-title" >Account Details</h4>

                                <div class="row">

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >GST Number</label>
                                            <input type="text" id="city-column"  class="form-control" data-index="25"  value="{{$corporate->gst_no}}" placeholder="GST Number"  name="gst_number" onkeydown="setNextField(event)"/>
                                            @error('gst_number')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>

                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column" >Credit Days</label>
                                            <input type="text" id="first-name-column" class="form-control " data-index="26"   value="{{$corporate->credit_days}}" placeholder="Credit Days" name="credit_days" value="{{old('credit_days')}}" onkeydown="setNextField(event)"/>
                                            @error('credit_days')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column" >Credit Limit</label>
                                            <input type="text" id="first-name-column" class="form-control " data-index="27"  value="{{$corporate->credit_limit}}" placeholder="Credit Limit" name="credit_limit" value="{{old('credit_limit')}}" onkeydown="setNextField(event)"/>
                                            @error('credit_limit')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Cash Discount</label>
                                            <select class="form-control select2" id="discount_id" name="discount_id" data-index="28"  onkeydown="setNextField(event)">
                                                <option disabled selected>Select Discount</option>

                                                @foreach($discount as $discount)
                                                @if($discount->id == $corporate->discount_id)
                                                <option selected value={{$discount->id}}>
                                                @else
                                                <option  value={{$discount->id}}>
                                                @endif
                                                    {{$discount->percent}}</option>
                                                @endforeach
                                            </select>

                                            @error('discount_id')
                                               <h5 class="alert alert-danger">{{$message}}</h5>
                                           @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column" >CRM</label>
                                            <select class="form-control select2" id="crm_id" name="crm_id" data-index="29" onkeydown="setNextField(event)" >
                                                <option disabled selected>Select CRM</option>
                                                @foreach($crm as $crm)
                                                @if($crm->id == $corporate->crm_id)
                                                <option selected value={{$crm->id}}>
                                                @else
                                                <option  value={{$crm->id}}>
                                                @endif
                                                    {{$crm->crm_name}}</option>
                                                @endforeach
                                            </select>
                                            @error('crm_id')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column" >Commission</label>
                                            <select class="form-control select2" id="commission_id" data-index="30"  name="commission_id" onkeydown="setNextField(event)">
                                                <option disabled selected>Select Commission</option>
                                                @foreach($commission as $commission)
                                                @if($commission->id == $corporate->commission_id)
                                                <option selected value={{$commission->id}}>
                                                @else
                                                <option  value={{$commission->id}}>
                                                @endif
                                                    {{$commission->code}}</option>
                                                @endforeach
                                            </select>


                                            @error('commission_id')
                                            <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Agent</label>
                                            <select class="form-control select2" id="agent_id" name="agent_id" data-index="31"  onkeydown="setNextField(event)">
                                                <option disabled selected>Select Agent</option>
                                                @foreach($agent as $agent)
                                                @if($agent->id == $corporate->agent_id)
                                                <option selected value={{$agent->id}}>
                                                @else
                                                <option  value={{$agent->id}}>
                                                @endif
                                                    {{$agent->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('agent_id')
                                               <h5 class="alert alert-danger">{{$message}}</h5>
                                           @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Transport</label>
                                            <select class="form-control select2" id="transport" name="transport_id" data-index="32"  onkeydown="setNextField(event)">
                                                <option disabled selected>Select Transport</option>
                                                @foreach($transport as $transport)
                                                @if($transport->id == $corporate->transport_id)
                                                <option selected value={{$transport->id}}>
                                                @else
                                                <option  value={{$transport->id}}>
                                                @endif
                                                    {{$transport->name}}</option>
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
                                            <input type="number"   class="form-control" data-index="33"   value="{{ $corporate->A}}" name="marginA" onkeydown="setNextField(event)" />
                                    
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-4">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">B</label>
                                            <input type="number"   class="form-control"  data-index="34"  value="{{ $corporate->B}}" name="marginB" onkeydown="setNextField(event)"/>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-4">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">C</label>
                                            <input type="number"   class="form-control" data-index="35"    value="{{ $corporate->C}}" name="marginC" onkeydown="setNextField(event)"/>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-4">
                                        <div class="form-group">
                                            <label for="city-column" style=" ">D</label>
                                            <input type="number"   class="form-control" data-index="36"   value="{{$corporate->D}}" name="marginD" onkeydown="setNextField(event)"/>
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
                            <h4 class="card-title" >Other Details</h4>

                                <div class="row">

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column" >Communication</label>
                                            <div class="d-flex">
                                            <label class="pr-3">Email <input @if($corporate->communication_via=='email') checked @endif type="checkbox" placeholder="" data-index="37" value="email" name="communication" onkeydown="setNextField(event)"></label>
                                            <label class="pr-3">Whatsapp <input @if($corporate->communication_via=='whatsapp') checked @endif type="checkbox" placeholder="" data-index="38" value="whatsapp" name="communication" onkeydown="setNextField(event)"></label>
                                            <label class="pr-3">SMS <input @if($corporate->communication_via=='sms') checked @endif type="checkbox" placeholder="" value="sms" data-index="39" name="communication" onkeydown="setNextField(event)"></label>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column" >Transporter Charges to Be borne by Client (Yes/NO) </label>
                                            <div class="d-flex">
                                                <label class="pr-3">Yes <input @if($corporate->client_charge=='yes') checked @endif type="radio" data-index="40" placeholder="" value="yes" name="charge" onkeydown="setNextField(event)"></label>
                                                <label class="pr-3">No <input @if($corporate->client_charge=='no') checked @endif type="radio" data-index="41" placeholder="" value="no" name="charge" onkeydown="setNextField(event)"></label>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column" >Client Status (Active / Inactive) </label>
                                            <div class="d-flex">
                                                <label class="pr-3">Active <input @if($corporate->status=='active') checked @endif type="radio" placeholder="" data-index="42" value="active" name="status" onkeydown="setNextField(event)"></label>
                                                <label class="pr-3">Inactive <input @if($corporate->status=='inactive') checked @endif type="radio" placeholder="" data-index="43" value="inactive" name="status" onkeydown="setNextField(event)"></label>
                                                </div>
                                        </div>
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
        // $('[data-index="' + (index + 1).toString() + '"]').css("background-color","Yellow");
        // $('[data-index="' + (index).toString() + '"]').css("background-color","white");
        // $('[data-index="' + (index - 1).toString() + '"]').css("background-color","white");


    };

  }

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
    if(e.which == 13){
        if($("input[name='is_retail']:checked").val() == 0){
          $('[data-index="3"]').focus();
        }
    }
});

</script>

   

@endpush






