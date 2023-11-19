@extends('retail.layouts.app')
@section('retail_content')
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
@include('styles.style')
<style>
 
</style>
<div class="container" id='publish_picklist_invoice'>
  <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title" >Customer Invoice Detail</h4>
            <h4 class="card-title "  style="color: #009973; "><span id="product_gender_id"></span ><span id="product_fabric_id"></span><span id="product_style_id"></span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="product_color_id"></span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="product_size_id"></span></h4>
            <span>
            <a href="{{route('retailcustomer.invoiceList')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
            </span>
        </div>
    </div>
</div>
  <!-- Invoice -->
  <div class="col-xl-12 col-md-12 col-12">
    <div class="card invoice-preview-card">
      <div class="card-body invoice-padding pb-0">
        <div class="row">
          <div class="col-md-2" >
            <h4 class="invoice-title">
              Invoice No. {{$customer_invoice['invoice_no'] }}
            </h4>
          </div>
          <div class="col-md-7" style="text-align:center;">
            <div class="logo-wrapper">
              <img style="max-width:140px;" src="https://vibecode.paramsoft.co.in/public/masters/img/logo.png" alt="">
            </div>
          </div>
          <div class="col-md-3">
            <p class="invoice-date-title">Date Issued: {{ \Carbon\Carbon::parse($customer_invoice['created_at'])->format('d-M-Y')}}</p>
            <p class="invoice-date-title">Customer: {{$customer_invoice['customer']['name'] }}</p>

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
                              <td style="text-align:center;">Total Qty</td>
                              <td style="text-align:center;">Rate</td>
                              <td style="text-align:center;">amount</td>
                            </tr>
                          </thead>
                          <tbody>
                            <tbody  style="text-align:center;" >
                                @foreach($customer_invoice->detail as $detail)
                                <tr>
                                    <td>{{$detail->product->product_code}}</td>
                                    <td>{{$detail->color->color_code}}({{$detail->color->name}})</td>
                                    @foreach ($detail->child as $attribute)
                                    <td>{{$attribute->qty}}</td>
                                    @endforeach
                                    </td>
                                    <td>{{$detail->qty}}</td>
                                    <td>{{$detail->per_qty}}</td>
                                    <td>{{$detail->total}}</td>
                                </tr>
                                @endforeach
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

      <div class="card-body invoice-padding pb-0" style="position: relative; top:-50px;">
        <div class="row invoice-sales-total-wrapper">
          <div class="col-md-8 order-md-1 order-2 mt-md-0 mt-3">
            <p class="card-text mb-0">
            </p>
          </div>

        </div>
        <div class="row" style="align-items: center;">
          <div class="col-sm-10" style="text-align: end;">Sub Total:</div>
          <div class="col-sm-2" >{{$customer_invoice['sub_total'] }}</div>

        </div>
        <div class="row pt-1" style="align-items:center;">
          <div class="col-sm-10" style="text-align: end;">Discount:</div>
          <div class="col-sm-2" >{{$customer_invoice['discount'] }}</div>
        </div>
       
        <hr style="border:0.5px solid; margin-left:70%;">

        <div class="row pt-1" style="align-items: center; font-weight:600">
          <div class="col-sm-10" style="text-align: end;">Grand Total:</div>
          <div class="col-sm-2">{{$customer_invoice['grant_total'] }}</div>
        </div>
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
@endsection


