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
                        <h4 class="card-title">Add Coupon</h4>
                        <a href="{{route('coupon.list')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <section id="multiple-column-form">
        <form method="post" action="{{route('coupon.store')}}">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Coupon Type</label>
                                        <select class="form-control"  id="coupon_type" name="coupon_type" required onchange="CouponType()" autofocus>
                                            <option selected disabled>Coupon type</option>
                                            <option value="Default">Default</option>
                                            <option value="First Order">First Order</option>
                                        </select>
                                        @error('coupon_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Coupon Title</label>

                                        <input id="text" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required>
                                        @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <span style="display:flex; justify-content:space-between;">
                                        <label for="city-column" style=" ">Coupon Code</label>
                                        <label for="city-column" style="color:blue; cursor: pointer;" onclick="generateCode()">Generate</label>
                                        </span>

                                        <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code" required>
                                        @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12" id="limit_user" >
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Limit For Same User</label>
                                        <input id="tel" type="number" class="form-control @error('limit') is-invalid @enderror" name="limit" required>
                                        @error('limit')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Discount Type</label>
                                        <select class="form-control" id="discount_type" name="discount_type"  onchange="DiscountType()">
                                            <option value="Percent">Percent</option>
                                            <option value="Amount">Amount</option>
                                        </select>
                                        @error('discount_type')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>


                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Discount Amount</label>
                                        <input id="tel" type="number" class="form-control @error('discount_amount') is-invalid @enderror" name="discount_amount" required>
                                        @error('discount_amount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Minimum Purchase</label>
                                        <input id="tel" type="number" class="form-control @error('minimum_purchase') is-invalid @enderror" name="minimum_purchase" required>
                                        @error('minimum_purchase')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-12" id="max_dis_sec" >
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Maximum Discount</label>
                                        <input id="tel" type="number" class="form-control @error('maximum_discount') is-invalid @enderror" name="maximum_discount" >
                                        @error('maximum_discount')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Start Date</label>
                                        <input type="text" id="fp-default" class="form-control flatpickr-basic" name="start_date" placeholder="YYYY-MM-DD" />
                                        @error('start_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Expire Date</label>
                                        <input type="text" id="fp-default" class="form-control flatpickr-basic" name="expire_date" placeholder="YYYY-MM-DD" />
                                        @error('expire_date')
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
                <button class="btn btn-sm global_btn_color" style="background-color: #009973; color:white; border-radius: 10px" type="submit">Submit</button>

            </div>
        </form>
    </section>
</div>
@endsection

@push('scripts')
<script>
 function DiscountType(){
    var type= $('#discount_type').find(':selected').val();
    type == 'Amount' ? $('#max_dis_sec').hide() : $('#max_dis_sec').show();
 }


 function CouponType(){
    var ctype= $('#coupon_type').find(':selected').val();
    ctype == 'Default' ? $('#limit_user').show() : $('#limit_user').hide();
 }

 function generateCode(){
    let result = '';
    const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < 8) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
      counter += 1;
    }

    $('#code').text(result);
    $('#code').val(result);

 }
 </script>


@endpush






