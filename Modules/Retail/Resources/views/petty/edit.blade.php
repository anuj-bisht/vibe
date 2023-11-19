@extends('retail.layouts.app')
@section('retail_content')
<style>


</style>
<div class="container">
    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Debit Petty Cash</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>



@isset($last_detail->retail_id)

    <section id="multiple-column-form">
       
        <div class="row" style="justify-content: end;">
            <div class="col-md-3 col-12" style="display: flex; justify-content: end; padding:0 10px 10px;">
                <a href="{{ route('retail.transaction.history',['retail_id'=> $last_detail->retail_id]) }}" type="button" class="btn btn-sm btn-primary">
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
                                Retailer Name : {{$last_detail->retail->name}}
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
        <form method="post" action="{{route('retailpetty.cash.update', ['id'=>$pettycash->id])}}"  enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group" style="display: flex; justify-content:end;">
                                      
                                            <input id="status" type="radio" name="status" checked value="Debited">Debited
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
                                        <label for="city-column" style="">Petty Head</label>
                                       <select class="form-control" name="petty_heads_id"> 
                                        <option disabled selected>Select Petty Head</option>
                                        @foreach($petty_head as $petty_head)
                                        <option value="{{$petty_head->id}}">{{$petty_head->petty_heads}}</option>
                                        @endforeach
                                       </select>


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
@else
No data found
    @endisset
</div>
@endsection

@push('scripts')

@endpush