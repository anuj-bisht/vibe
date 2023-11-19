@extends('retail.layouts.app')
@section('retail_content')
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
@include('styles.style')
<style>
 
</style>
<div class="container" id='purchase_invoice'>




  <!-- Invoice -->
  <div class="col-xl-12 col-md-12 col-12">
    <div class="card invoice-preview-card">
      <div class="card-body invoice-padding pb-0">
        <div class="row">
          <div class="col-md-2" >
            <h4 class="invoice-title">
                Export
            </h4>
          </div>
          <div class="col-md-7" style="text-align:center;">
            <div class="logo-wrapper">
              <img style="max-width:140px;" src="https://vibecode.paramsoft.co.in/public/masters/img/logo.png" alt="">
            </div>
          </div>
          <div class="col-md-3">
            <p class="invoice-date-title">Good Return Date: {{ \Carbon\Carbon::parse($returnData['created_at'])->toDateString() }} </p>
            <p class="invoice-date-title">Client:  {{$returnData['customers']['name']}}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /Invoice -->
  

  <!-- Invoice -->
  <div class="col-xl-12 col-md-12 col-12">
    <div class="card invoice-preview-card">
      <!-- Invoice Description starts -->


      <section id="input-mask-wrapper" >
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="row" id="table-head">
                  <div class="col-12">
                    <div class="card">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="">
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
                              <td>Per QTY</td>
                              <td>Total Qty</td>
                              <td>Total Price</td>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($returnData->detail as $detail)
                            <tr>
                                <td style="text-align:center;">{{$detail->product->product_code}}</td>
                                <td style="text-align:center;">{{$detail->color->color_code}}({{$detail->color->name}})</td>
                                @foreach ($detail->child as $attribute)
                                <td style="text-align:center;">{{$attribute->qty}}</td>
                                @endforeach
                                </td>
                                <td style="text-align:center;">{{$detail->per_qty}}</td>
                                <td style="text-align:center;">{{$detail->total_qty}}</td>
                                <td style="text-align:center;">{{$detail->total_price}}</td>

                             
                            </tr>
                            @endforeach
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
@endsection


@push('scripts')

@endpush


