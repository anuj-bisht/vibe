@extends('retail.layouts.app')
@section('retail_content')
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

@include('styles.style')
<style>
    .table-bordered {
        border-color: black !important;
    }

    .tp {
        padding: 0px !important;
    }

    .vs--searchable .vs__dropdown-toggle {
        height: 38px;
    }

    .select2-container--open .select2-dropdown--below{
        z-index:1 !important; 
    }

    .coupon-card{
    background: linear-gradient(135deg, #58fee3, #9d4de6);
    color: #fff;
    text-align: center;
    /* padding: 40px 80px; */
    border-radius: 15px;
    box-shadow: 0 10px 10px 0 rgba(0,0,0,0.15);
    position: relative;

}
.logo{
    width: 80px;
    border-radius: 8px;
    margin-bottom: 20px;

}
.coupon-card h3{
    /* font-size: 28px; */
    font-weight: 400;
    /* line-height: 40px; */

}
.coupon-card p{
    font-size: 15px;

}



.circle1, .circle2{
    background: #f0fff3;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    position: absolute;
    top: 50%;
    transform: translateY(-50%);

}
.circle1{
    left: -25px;
}
.circle2{
    right: -25px;
}
</style>
@php
{{ $state = Modules\Corporate\Entities\State::get(); }}
{{ $city = Modules\Corporate\Entities\City::get(); }}
@endphp

<div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel33">Add Customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form  method="POST" action="{{route('customer.store', ['modal'=>1])}}">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="city-column" style=" ">Name</label>
                            <input id="text" type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label for="city-column" style=" ">Email Address</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <label for="city-column" style=" ">Mobile</label>
                            <input id="tel" type="tel" class="form-control @error('mobile') is-invalid @enderror"
                                name="mobile" required>
                            @error('mobile')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-6">

                            <label for="city-column" style=" ">Alternate No.</label>
                            <input id="tel" type="tel" class="form-control @error('alter_no') is-invalid @enderror"
                                name="alter_no" required>
                            @error('alter_no')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror

                        </div>
                    </div>



                    <div class="row">
                        <div class="col-6">
                            <label for="city-column" style=" ">Country</label>
                            <select class="form-control " id="billing_country" name="country" data-index="3"
                                onchange="getBillingState()">
                                <option disabled selected>Select Country</option>
                                @foreach($country as $country)
                                <option value='{{$country->id}} {{ old("country") == $country->id ? "selected":"" }}'>
                                    {{$country->name}}</option>
                                @endforeach
                            </select>
                            @error('country')
                            <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                        </div>
                        <div class="col-6">
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
                    <label for="city-column" style=" ">City</label>
                    <select class="form-control " id="billing_city" name="city" data-index="3"
                        onkeydown="setNextField(event)">
                        <option disabled selected>Select City</option>
                        @foreach($city as $City)
                        <option value={{$City->id}} {{ old("city") == $City->id ? "selected":"" }}>{{$City->name}}
                        </option>
                        @endforeach
                    </select>
                    @error('city')
                    <h5 class="alert alert-danger">{{$message}}</h5>
                    @enderror

                    <div class="row">
                        <div class="col-6">
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
                        <div class="col-6">

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


                    <div class="row">
                        <div class="col-6">
                            <label for="city-column" style=" ">DOB</label>
                            <input type="text" id="fp-default" class="form-control flatpickr-basic"
                                name="dob" placeholder="YYYY-MM-DD" />
                            @error('dob')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="col-6">

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
                <button class="btn btn-sm global_btn_color" style="background-color: #009973; color:white; border-radius: 10px" type="submit">Submit</button>

            </form>
        </div>
    </div>
</div>


<div class="container" id='customer_invoice'>
    @if($errors->any())
    @foreach ($errors->all() as $error)
    <p class="alert alert-warning alert-heading">{{$error}}</p>

@endforeach
@endif

    <!-- Invoice -->
    <div class="col-xl-12 col-md-12 col-12">
        <div class="card invoice-preview-card">
            <div class="card-body invoice-padding pb-0">
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="invoice-title">
                            Invoice No.
                            <span class="invoice-number">@{{invoicenumber}}</span>
                        </h4>
                    </div>
                    <div class="col-md-7" style="text-align:center;">
                        <div class="logo-wrapper">
                            <img style="max-width:140px;"
                                src="https://vibecode.paramsoft.co.in/public/masters/img/logo.png" alt="">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <p class="invoice-date-title">Date Issued: @{{ invoiceDate }}</p>

                    </div>
                </div>

            </div>

            <hr class="invoice-spacing" />

            <!-- Address and Contact starts -->
            <div class="card-body invoice-padding pt-0">
                <div class="row invoice-spacing">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="city-column" style="color:black; ">Search Customer No.</label>
                            <select class="form-control "  data-index="1" id="customer_id" name="customer_id" required
                                v-model="customer_no" @@change="checkOrderType()" v-select2>
                                <option disabled selected value="">Type Phone No.</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Address and Contact ends -->
        </div>
    </div>
    <!-- /Invoice -->


    <!-- Invoice -->
    <div class="col-xl-12 col-md-12 col-12">
        <div class="card invoice-preview-card">


            <div id="ean" class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <input class="form-control input" type="text" placeholder="Search Ean" data-search="search"
                                v-model="typeEan" id="ean_no" @@input="searchEAN(this)">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Description starts -->
            <section id="input-mask-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                        <table class="title-form horizontaltable">
                                            <tbody style="font-size:12px;">
                                                <tr style="text-align:center;">
                                                    <td>P Code</td>
                                                    <td>C Code</td>
                                                    @foreach($sizes as $size)
                                                    <td style="text-align:center;">
                                                        <?php
                                                   $str=explode('/',$size->size);
                                                   
                                                   $a=$str[0]??'';
                                                   $b=$str[1]??'';
                                                   echo "$a<br>$b";
                                                    ?>
                                                    </td>
                                                    @endforeach
                                                    <td>QTY</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td style="width:9rem;">
                                                        <v-select label="product_code" :options="products"
                                                            v-model="product_object" @@close="focusVSelect"  @@input="getColor"
                                                            @@search="searchProduct"   ref="productSelect"></v-select>
                                                    </td>
                                                    <td style="width:8rem;">
                                                        <input type="hidden" id="pro_code">
                                                        <select data-index="3" class="form-control" id="color"
                                                            v-model="color_object" name="color_id"  ref="colorSelect"  required
                                                            @@change="getMrp" v-select2>
                                                            <option selected disabled></option>
                                                            <option v-for="color in colors" :value="color"> @{{
                                                                color.color.color_code }}

                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td v-for="(size, k) in sizes" :key="k">
                                                        <input type="number" name="cutting_plans" v-model="size.value"
                                                            class="form-control input retailqty"
                                                            style="padding:0px !important;" @@change='changeTotal(k)'>
                                                    </td>

                                                    <td style="width:5rem;"><input readonly v-model="totalq"
                                                            type="number" name="sum" id="total"
                                                            class="form-control cuttingplantotal" data-index="5"> @{{
                                                        updateTotal() }}
                                                    </td>
                                                    <td>
                                                        <button class="btn global_btn_color " @@click="toBottom()"
                                                            data-index="6"><svg xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-arrow-down">
                                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                                <polyline points="19 12 12 19 5 12"></polyline>
                                                            </svg></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="input-mask-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" id="table-head">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%"
                                                    cellspacing="0" style="">
                                                    <thead class="thead-dark">
                                                        <tr style="background-color: #32AD89; color:white;">
                                                            <td style="text-align:center;">P Code</td>
                                                            <td style="text-align:center;">C Code</td>
                                                            @foreach($sizes as $size)
                                                            <td style="text-align:center;">
                                                                <?php
                                                         $str=explode('/',$size->size);
                                                         $a=$str[0]??'';
                                                         $b=$str[1]??'';
                                                         echo "$a<br>$b";
                                                          ?>
                                                            </td>
                                                            @endforeach
                                                            <td style="text-align:center;">Total Qty</td>
                                                            <td style="text-align:center;">Rate</td>
                                                            <td style="text-align:center;">amount</td>
                                                            <td style="text-align:center;">Action</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr id="" v-for="(c, k) in child" :key="k">
                                                            <td style="text-align:center;" class="tp"> @{{
                                                                c.product_name }} </td>
                                                            <td style="text-align:center;" class="tp"> @{{ c.color_name
                                                                }} </td>
                                                            <td style='text-align:center;' class="tp"
                                                                v-for="(s,j) in c.cs"><span
                                                                    v-if="child[k].cs[j].err != ''"
                                                                    style="color:red;">@{{child[k].cs[j].err}}</span>
                                                                    <input readonly
                                                                    @@change="calData(child[k],k,c.product_id,c.color_id,child[k].cs[j],j,k,j)"
                                                                    style="width:35px; border:none;" type="number"
                                                                    name="" id="" v-model="child[k].cs[j]">
                                                            </td>
                                                            <td style="text-align:center;" class="tp">@{{ c.totalq }}
                                                            </td>
                                                            <td style="text-align:center;" class="tp">@{{ c.per_qty }}
                                                            </td>
                                                            <td style="text-align:center;" class="tp">@{{ c.total_price
                                                                }}</td>
                                                            <td style="paddng:0.75px !important"><a
                                                                    class="btn btn-sm btn-danger"
                                                                    href="javascript:void(0)"
                                                                    @@click="deleteData(k)"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="feather feather-trash-2">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path
                                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                        </path>
                                                                        <line x1="10" y1="11" x2="10" y2="17">
                                                                        </line>
                                                                        <line x1="14" y1="11" x2="14" y2="17">
                                                                        </line>
                                                                    </svg></a></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="card-body invoice-padding pb-0" style="position: relative; top:-90px;">

                <div class="row invoice-sales-total-wrapper">

                    <div class="col-md-8 order-md-1 order-2 mt-md-0 mt-3">

                        <p class="card-text mb-0">

                        </p>

                    </div>



                </div>

                <div class="row" style="align-items: center;">
                    <div class="col-sm-4">
                        {{-- <select class="form-control " id="discount" 
                        name="discount" data-index="3" v-model="coupon_object" @@change="calGrandTotal" v-select2>

                        <option disabled selected value="">Select</option>

                        <option v-for="coupon in coupons" :value="coupon"><div class="btn btn-primary">@{{coupon.coupon_title}} - @{{coupon.coupon_code}} (@{{coupon.discount_amount}} off)</div>
                        </option>

                    </select> --}}
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#exampleModalScrollable">
                        Select Coupon
                    </button>
                    </div>
                    <div class="col-sm-5" style="text-align: end;">Sub Total:</div>
                    <div class="col-sm-3" v-if="child.length > 0">@{{parseFloat(subTotal).toFixed()}}</div>
                    </div>

                    <div class="row " style="align-items:center;">
                        <div class="col-sm-3 pt-1" >
                            <select class="form-control " data-index="1" id="mode" name="mode" required v-model="mode_object" onkeydown="jumpNextField(event)" v-select2>
                                <option disabled selected value="">Select Payment Mode</option>
                                <option value="Cash">Cash</option>
                                <option value="Online">Online</option>
                                <option  value="Check">Check</option>                        
                            </select>
                        </div>

                        <div class="col-sm-6" style="text-align:end;">Discount:</div>
                        <div class="col-sm-3" v-if="child.length > 0">@{{discount_amount}}</div>
                    </div>
                        <div class="row pt-1" style="align-items:center;">
                            <div class="col-sm-9" style="text-align:end;">Grant Total:</div>
                            <div class="col-sm-3" v-if="child.length > 0">@{{grandTotal}}</div>
                        </div>

          
            <div class="col-sm-2 pt-1">
                <button class="btn global_btn_color" @@click="sumbitData()" data-index="7">Save</button>
                <form id="consumerform" method="post" action="{{ route('moveToCustomerInvoice') }}">
                    @csrf
                    <input type="hidden" id="consumerdata" name="data">

                </form>
            </div>

            <!-- Invoice Description ends -->

            <hr class="invoice-spacing" />

            <!-- Invoice Note starts -->
            <div class="card-body invoice-padding pt-0">
                <div class="row">
                    <div class="col-12">
                        <span class="font-weight-bold">Note:</span>
                        <span>Vibe Team</span>
                    </div>
                </div>
            </div>
            <!-- Invoice Note ends -->
        </div>
    </div>
    <!-- /Invoice -->
</div>

<div class="modal fade mt-2" id="exampleModalScrollable" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true" style="padding-top:4rem;">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">All Coupons</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
 
            <div class="row">
            <div class="col-12" v-for="coupon in coupons" >

                <div :id="'cou'+coupon.id" class="coupon-card mb-1" >
                    <img src="https://vibecode.paramsoft.co.in/public/masters/img/logo-white.png" class="logo">
                    <h3>@{{coupon.coupon_title}}<br>@{{coupon.coupon_code}}</h3>
                    <p class="card-text" style="font-size:smaller;">Minimum Order @{{coupon.minimum_purchase}}&nbsp;(save  @{{coupon.discount_amount}}<span v-if="coupon.discount_type == 'Percent'">%  &nbsp; Maximum Discount : @{{coupon.maximum_discount}}</span>) </p>
                    <p v-if="subTotal < coupon.minimum_purchase" class="card-text" style="font-size:smaller; color:red;">Add items worth Rs@{{coupon.minimum_purchase - subTotal}} more to unlock</p>
                    <p>Valid Till: @{{new Date(coupon.expire_date).toISOString().slice(0, 10)}}</p>
                    <button data-dismiss="modal" aria-label="Close" class="btn" style="font-size:smaller; color:white;"  :disabled = "coupon.minimum_purchase > subTotal"  data-index="7" @@click="calGrandTotal(coupon)">Apply</button>

                    <div class="circle1"></div>
                    <div class="circle2"></div>
                </div>


            </div>
            </div>
            
            </div>
        
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
    Vue.directive('select2', {
        inserted(el) {
            $(el).on('select2:select', () => {
                const event = new Event('change', {
                    bubbles: true
                    , cancelable: true
                });
                el.dispatchEvent(event);
            });

            $(el).on('select2:unselect', () => {
                const event = new Event('change', {
                    bubbles: true
                    , cancelable: true
                });
                el.dispatchEvent(event);
            });
        }
    });
    Vue.component('v-select', VueSelect.VueSelect);
    var app = new Vue({
        el: '#customer_invoice',
         data: {
            invoicenumber : {{$invoiceNumber}},
            invoiceDate: new Date().toISOString().slice(0, 10)
            , customer_no: ""
            , sizes: @json($sizes),
             typeEan: ""
            , product_object: ""
            , color_object: ""
            , products: []
            , colors: []
            , product_mrp: ""
            , totalq: ""
            , child: []
            , subTotal: 0,
            formData:"",
            coupons:@json($coupons),
            cpn : @json($coupons),
            coupon_object:"",
            grandTotal:0,
            discount_amount:0,
            first_order : 0,
            mode_object:"",




        },

        methods: {
            focusVSelect:function(){
                vm=this;
                vm.$refs.colorSelect.focus();
            },

            calGrandTotal(coupon){
              vm = this;
              const data = JSON.stringify({
                    customer_id: vm.customer_no,
                    coupon_id : coupon.id,
                });
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                axios.post("{{ route('checkCouponLimit') }}", data, config).then(res => {
                       
                    if(coupon.limit_user == res.data.data){
                        return toastr['success'](`You use this coupon multiple times. Use Others Coupons`, '', {
                                closeButton: true
                                , tapToDismiss: false
                                , progressBar: true
                            , });
                    }else{
                        vm.coupon_object = coupon;
                        if(vm.coupon_object.discount_type == 'Amount'){
                            vm.grandTotal = 0;
                            vm.discount_amount = 0;
                            vm.grandTotal = vm.subTotal - vm.coupon_object.discount_amount;
                            vm.discount_amount =  vm.coupon_object.discount_amount;
                        }
                        else if(vm.coupon_object.discount_type == 'Percent'){
                            vm.grandTotal = 0;
                            vm.discount_amount = 0;
                            var check_discount = (vm.subTotal/100) * vm.coupon_object.discount_amount;
                            alert(check_discount);
                            if(vm.coupon_object.maximum_discount > check_discount){
                                vm.grandTotal = vm.subTotal -  check_discount;
                                vm.discount_amount = check_discount;
                            }else{
                                vm.grandTotal = vm.subTotal -  vm.coupon_object.maximum_discount;
                                vm.discount_amount = vm.coupon_object.maximum_discount;
                            }
                        }
                    }

                });


     
            },

            checkLimit(){
                vm = this;
                const data = JSON.stringify({
                    customer_id: vm.customer_no
                });
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                axios.post("{{ route('checkCouponLimit') }}", data, config).then(res => {

                });
            },
       
            checkOrderType(){
                vm=this;
                const data = JSON.stringify({
                    customer_id: vm.customer_no
                });
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                axios.post("{{ route('checkCouponType') }}", data, config).then(res => {
                     vm.first_order=res.data.data;
                    //  console.log(vm.coupons);
                    if(vm.first_order == 1){
                        vm.coupons = vm.coupons.filter((ele)=>{
                         return ele.coupon_type == 'Default'

                        });


                    //     vm.filterProducts= vm.mainProducts.filter(function (el){
                    // if(vm.main_category_id != '' && vm.sub_category_id.length == 0){
                    //  return el.main_category_id == vm.main_category_id;
                    // }
                    this.$refs.productSelect.searchEl.focus();
                    }
                    else{
                          vm.coupons = vm.cpn;
                          this.$refs.productSelect.searchEl.focus();
                    }
                })
            },
            searchProduct(search, loading) {
                vm = this;

                if (search.length < 1) {
                    return;
                }
                vm.colors = [];

                const data = JSON.stringify({
                    srch: search
                });
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                axios.post("{{ url('/getRetailProduct') }}", data, config).then(res => {
                    vm.products = res.data.data;
                })

            },

            calc_sub_total: function() {
                vm = this;
                subtotal = 0;
                for (i in vm.child) {
                    subtotal += vm.child[i].total_price;
                }
                vm.subTotal = subtotal;
            },

            getColor: function(event) {
                vm = this;
                const data = JSON.stringify({
                    p_id: vm.product_object.id
                });
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                axios.post("{{ url('/getRetailProductColor') }}", data, config).then(res => {
                    vm.colors = res.data.data;
                })
            },
            getMrp: function() {
                vm = this;

                const data = JSON.stringify({
                    p_id: vm.product_object.id
                    , c_id: vm.color_object.color.id
                , });
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                axios.post("{{ url('/getRetailProductColorMrp') }}", data, config).then(res => {
                    vm.product_mrp = parseInt(res.data.data);
                })
            },
            updateTotal() {
                vm = this;
                var total = 0;
                var list = vm.sizes;
                var values = [];
                for (var i = 0; i < list.length; ++i) {
                    if(list.value !== undefined || list.value !== '' || list.value !== 0){
                        values.push(list[i].value);
                    }

                }
                 vm.sub(values);

            }
            , sub(arr) {
                vm = this;
                var values = $.grep(arr, n => n == ' ' || n)
                var total = 0;
                for (var i in values) {
                    total += parseInt(values[i]);
                }
                vm.totalq = total;
                
            },
            searchEAN: function(e) {
                vm = this;
                if (vm.typeEan.length == 13) {
                    $('#searchErrorMessage').text("");
                    const data = JSON.stringify({
                        product_ean: vm.typeEan,
                    });
                    const config = {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }
                    
                    axios.post("{{ url('/getQtyByRetailSearch') }}", data, config).then(res => {
                        if (res.data.data.qty.qty == 0) {
                            return toastr['success'](`${res.data.data.qty.size.size} has 0 quantity`, '', {
                                closeButton: true
                                , tapToDismiss: false
                                , progressBar: true
                            , });
                        }
                        vm.color_id = res.data.data.product.color_id;
                        vm.product_object = {
                            id: res.data.data.product.product_master_id
                        };
                        var id = res.data.data.qty.size_id;
                        var cs = {};
                        for (k in vm.sizes) {
                            cs[vm.sizes[k].id] = vm.sizes[k].id == res.data.data.qty.size_id ? 1 : 0
                        }
                        if (vm.child.length > 0) {
                            var product = vm.child.filter(function(el) {
                                return el.color_id == vm.color_id && el.product_id == vm.product_object.id;
                            });

                            if (product.length > 0) {
                                let spl_key = []
                                for (const [key, val] of Object.entries(vm.child)) {
                                    if (val.product_name == product[0].product_name) {
                                        spl_key.push(key)
                                    }
                                }
                                if (parseInt(product[0].cs[res.data.data.qty.size_id]) < res.data.data.qty.qty) {
                                    vm.child[spl_key].cs[res.data.data.qty.size_id] = parseInt(product[0].cs[res.data.data.qty.size_id]) + 1;
                                    vm.child[spl_key].totalq = product[0].totalq + 1;
                                    vm.child[spl_key].total_price = vm.child[spl_key].totalq * product[0].per_qty;
                                } else {
                                    return toastr['success'](`No Quantity left`, '', {
                                        closeButton: true
                                        , tapToDismiss: false
                                        , progressBar: true
                                    , });
                                }
                                this.calc_sub_total();
                                vm.color_object = "";
                                vm.product_object = "";
                                vm.typeEan = "";
                            } else {

                                var p_rate = parseInt(res.data.data.product.mrp);
                                vm.child.push({
                                    "totalq": 1
                                    , 'product_id': res.data.data.product.product_master_id
                                    , 'product_name': res.data.data.product.parent.product_code
                                    , 'color_id': res.data.data.product.color_id
                                    , 'color_name': res.data.data.product.color.color_code
                                    , 'per_qty': p_rate
                                    , 'total_price': p_rate
                                    , cs
                                });
                                this.calc_sub_total();
                                vm.color_object = "";
                                vm.product_object = "";
                                vm.typeEan = "";

                            }
                        } else {


                            var p_rate = parseInt(res.data.data.product.mrp);
                            vm.child.push({
                                "totalq": 1
                                , 'product_id': res.data.data.product.product_master_id
                                , 'product_name': res.data.data.product.parent.product_code
                                , 'color_id': res.data.data.product.color_id
                                , 'color_name': res.data.data.product.color.color_code
                                , 'per_qty': p_rate
                                , 'total_price': p_rate
                                , cs
                            });
                            this.calc_sub_total();
                            vm.color_object = "";
                            vm.product_object = "";
                            vm.typeEan = "";

                        }
                    }).catch(error => {
                        toastr['success']('Product not found', '', {
                            closeButton: true
                            , tapToDismiss: false
                            , progressBar: true
                        , });
                        vm.color_object = "";
                        vm.product_object = "";
                        vm.typeEan = "";

                    });
                } else {
                    toastr['success']('EAN Should be 13 Digit', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });

                }

            },

            toBottom() {

                vm = this;
                if(vm.customer_no == ""){
                   return toastr['success'](`Select Customer`, '', {
                                                                            closeButton: true
                                                                            , tapToDismiss: false
                                                                            , progressBar: true
                                                                        , });
                                              
                }
            
                
                for( k in vm.sizes){
                    if(vm.sizes[k].isloading){
                        toastr['success'](` Loading `, '', {
                                                                            closeButton: true
                                                                            , tapToDismiss: false
                                                                            , progressBar: true
                                                                        , });
                                              
                        return;
                    }
                }
                if (vm.product_object.id != 0 && vm.color_object.color_id > 0) {
                    var cs = {};
                    var css = {};
                    for (k in vm.sizes) {
                        cs[vm.sizes[k].id] = vm.sizes[k].value ? parseInt(vm.sizes[k].value) : 0
                    }
                    
                    if (vm.child.length > 0) {

                        var product = vm.child.filter(function(el) {
                            return el.color_id == vm.color_object.color.id && el.product_id == vm.product_object.id;
                        });

                        if (product.length > 0) {

                            vm.error = [];
                            for (k in vm.sizes) {
                                css[vm.sizes[k].id] = vm.sizes[k].value ? parseInt(vm.sizes[k].value) : 0
                            }
                            let totalqty = {};
                            for (let csskeys in css) {
                                totalqty[csskeys] = css[csskeys] + product[0].cs[csskeys];
                            }

                            let spl_key = []
                            for (const [key, val] of Object.entries(vm.child)) {
                                if (val.product_name == product[0].product_name) {
                                    spl_key.push(key)
                                }
                            }
                            var totalQTY = parseInt(vm.totalq) + parseInt(product[0].totalq);
                            vm.child[spl_key].cs = totalqty;
                            vm.child[spl_key].totalq = totalQTY;
                            vm.child[spl_key].total_price = totalQTY * product[0].per_qty;

                            vm.totalq = 0;
                            for (k in vm.sizes) {
                                vm.sizes[k].value = 0;
                            }
                            vm.$refs.productSelect.searchEl.focus();

                            this.calc_sub_total();
                        } else {
                            vm.child.push({
                                "totalq": vm.totalq
                                , 'product_id': vm.product_object.id
                                , 'product_name': vm.product_object.product_code
                                , 'color_id': vm.color_object.color.id
                                , 'color_name': vm.color_object.color.color_code
                                , 'per_qty': vm.product_mrp
                                , 'total_price': vm.totalq * vm.product_mrp
                                , cs
                            , });

                            vm.totalq = 0;
                            for (k in vm.sizes) {
                                vm.sizes[k].value = 0;
                            }
                            vm.$refs.productSelect.searchEl.focus();

                            this.calc_sub_total();
                        }
                    } else {
                        vm.child.push({
                            "totalq": vm.totalq
                            , 'product_id': vm.product_object.id
                            , 'product_name': vm.product_object.product_code
                            , 'color_id': vm.color_object.color.id
                            , 'color_name': vm.color_object.color.color_code
                            , 'per_qty': vm.product_mrp
                            , 'total_price': vm.totalq * vm.product_mrp
                            , cs
                        , });
                        vm.totalq = 0;
                        for (k in vm.sizes) {
                            vm.sizes[k].value = 0;
                        }
                        vm.$refs.productSelect.searchEl.focus();

                        this.calc_sub_total();
                    }
                }
            },
            sumbitData() {
              var vm = this;
              if(vm.child.length == 0 && vm.customer_no == ""){
                 return toastr['success']('Fill all details', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                }
              var formData = {};
              formData.invoiceNumber = vm.invoicenumber;
              formData.customer_id = vm.customer_no;
              formData.invoiceDate = vm.invoiceDate;
              formData.sub_total=vm.subTotal;
              formData.grandTotal = vm.grandTotal;
              formData.coupon_id = vm.coupon_object.id;
              formData.discount_amount = vm.discount_amount;
              formData.payment_mode = vm.mode_object;
              formData.total_pcs = vm.itotalq;
              formData.detail = vm.picklistData;
              formData.child=vm.child;
              vm.formData = JSON.stringify(formData);
              document.getElementById("consumerdata").value = vm.formData;
              document.getElementById("consumerform").submit();

          },
            changeTotal(sizes_key) {
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                vm =this;
                vm.sizes[sizes_key].isloading= true;
                vm.sizes[sizes_key].value= parseInt(vm.sizes[sizes_key].value.replace(/^0+/, ''));
                const wareData = JSON.stringify({
                            prod_id: vm.product_object.id
                            , col_id: vm.color_object.color_id
                            , qy: vm.sizes[sizes_key].value
                            , s_id: vm.sizes[sizes_key].id
                            , warehouse_id: 0
                        });
                if (vm.child.length > 0) {
                    var product = vm.child.filter(function(el) {
                        return el.color_id == vm.color_object.color_id && el.product_id == vm.product_object.id;
                    });
                 
                    if (product.length > 0) {

                       var totalqty= product[0].cs[vm.sizes[sizes_key].id];

                        axios.post("{{ url('/checkwarehouseqty') }}", wareData, config).then(res => {
                            if((totalqty + vm.sizes[sizes_key].value) > res.data.qty ){
                                var cqty= res.data.qty-totalqty;
                                vm.sizes[sizes_key].value= cqty;
                                toastr['success'](`Only  ${cqty} Quantities available`, '', {
                                                                            closeButton: true
                                                                            , tapToDismiss: false
                                                                            , progressBar: true
                                                                        , });
                                                                        vm.$forceUpdate();

                            }
                            vm.sizes[sizes_key].isloading= false;
                        });
                        return ;
                    }
                }
                axios.post("{{ url('/checkwarehouseqty') }}", wareData, config).then(res => {
                        if (res.data.cqty < 0) {
                            toastr['success'](`Only  ${res.data.qty} Quantities available`, '', {
                                closeButton: true
                                , tapToDismiss: false
                                , progressBar: true
                            , });
                            vm.sizes[sizes_key].value = res.data.qty;
                            vm.$forceUpdate();
                        }
                        // vm.upsub();
                        vm.sizes[sizes_key].isloading= false;
                    });
                    
            },
            deleteData(k) {
                this.child.splice(k, 1)
            }
        },
        mounted(){
            $('#customer_id').select2({
            ajax: {
                url: "{{route('retail.customer.search')}}"
                , dataType: 'json'
                , delay: 250
                , data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                }
                , processResults: function(data, params) {
                    
                    params.page = params.page || 1;

                    return {
                        results: data.items
                        , pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                }
                , cache: true
            }
            , placeholder: 'Search for a repository'
            , minimumInputLength: 1
            , templateResult: formatRepo
            , templateSelection: formatRepoSelection
        });
            $('#customer_id').select2('open');
            function formatRepo(repo) {

if (repo.loading) {
    return repo;
}

if (repo.is_create !== undefined) {


    var $container = $(
        "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
        "<button type='button' class='select2-result-btn__name btn btn-outline-primary' data-toggle='modal' data-target='#inlineForm'>Add</button>"+
        "</div>" +
        "</div>"
    );

    $container.find(".select2-result-btn__name").append(repo.name);

} else {
    var $container = $(
        "<div class='select2-result-repository clearfix'>" +
        "<div class='select2-result-repository__meta'>" +
        "<div class='select2-result-repository__name'></div>" +
        "<div class='select2-result-repository__title'></div>" +
        "</div>" +
        "</div>"
    );

    $container.find(".select2-result-repository__name").append(repo.name);
    $container.find(".select2-result-repository__title").text(repo.country.name + ',' + repo.state.name + ',' + repo.city.name);
}
return $container;
}

function formatRepoSelection(repo) {
return repo.name
}

        },

    })



    $(document).ready(function() {
    

        


      

    });


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
@endpush