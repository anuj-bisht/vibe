@extends('layouts.app')

@include('styles.style')
@section('content')
<style>


</style>
<div class="container">
    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Petty Cash</h4>
                        <a href="{{route('petty.index')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>

                    </div>
                </div>
            </div>
        </div>
    </section>



    <section id="multiple-column-form">

     

        <div class="row" style="justify-content: end;">
            <div class="col-md-3 col-12" style="display: flex; justify-content: end; padding:0 10px 10px;">
                <a href="{{ route('admin.transaction.history',['retail_id'=>$pettycash->retail_id]) }}" type="button" class="btn btn-sm btn-primary">
                    All Transactions
                </a>
            </div>
        </div>
    
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="row" style="justify-content: space-between;">
                            <div class="col-md-3 col-12">
                                Reatiler Name : {{$last_detail->retail->name}}
                            </div>

                      
                            <div class="col-md-3 col-12">
                                Current Balance <i class="fa-solid fa-wallet"></i>: {{$last_detail->wallet}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

    </section>
    <section id="multiple-column-form">
        @if($errors->any())
        <h6 class="alert alert-danger">{{$errors->first()}}</h6>
        @endif
        <form method="post" action="{{route('petty.cash.update', ['id'=>$pettycash->id])}}"  enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="display: flex; justify-content:end;">
                                        <input type="radio" id="checkorder" name="status" @if($pettycash->type ==
                                        "Credited") checked @endif value="Credited">Credited
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Retailers</label>
                                        <input type="text" id="" class="form-control "
                                            value="{{ $pettycash->corporate_profile->name }}" readonly />
                                        <input type="hidden" name="retail_id" value="{{ $pettycash->retail_id }}" />


                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Date</label>
                                        <input type="text" id="fp-default" class="form-control flatpickr-basic"
                                            value="{{ $pettycash->date }}" name="date" placeholder="YYYY-MM-DD" />
                                        @error('date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Amount</label>
                                        <input id="tel" type="number"
                                            class="form-control @error('amount') is-invalid @enderror" name="amount"
                                            value="0">
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Note</label>
                                       <textarea class="form-control" name="note"> {{ $pettycash->note}}</textarea>
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style=" ">Image Or PDF</label>
                                        <input type="file" id=""  class="form-control" data-index="6"   name="pettydoc" />

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

@push('scripts')
{{-- <script>
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
</script> --}}
@endpush