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
              Invoice No. @{{invoice_no }}
            </h4>
          </div>
          <div class="col-md-7" style="text-align:center;">
            <div class="logo-wrapper">
              <img style="max-width:140px;" src="https://vibecode.paramsoft.co.in/public/masters/img/logo.png" alt="">
            </div>
          </div>
          <div class="col-md-3">
            <p class="invoice-date-title">Date Issued: @{{ new Date(date).toLocaleDateString() }}</p>
            <p class="invoice-date-title">Warehouse: @{{warehouse_name }}</p>
            <p class="invoice-date-title">Client:  @{{retailer_name }}</p>

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
                              {{-- <td style="text-align:center;">Total Qty</td>
                              <td style="text-align:center;">Rate</td>
                              <td style="text-align:center;">amount</td> --}}
                            </tr>
                          </thead>
                          <tbody>
                            <tbody  style="text-align:center;" >
                                <tr v-for="(c, k) in child" :key="k">
                                    <td>@{{ c.product.product_code }} </td>
                                    <td>@{{ c.color.color_code }}</td>
                                
                                    <td style='text-align:center;' class="tp" v-for="(s,j) in c.cs"><input
                                        {{-- @@change="calData(child[k],k,c.product_id,c.color_id,child[k].cs[j],j,k,j)" --}}
                                        style="width:26px; border:none;" type="number" name="" id="" v-model="child[k].cs[j]">
                                    </td>
                                    {{-- <td>@{{ c.qty }}</td>
                                    <td>@{{ c.per_qty }}</td>
                                    <td>@{{ c.total }}</td> --}}
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

      {{-- <div class="card-body invoice-padding pb-0" style="position: relative; top:-50px;">
        <div class="row invoice-sales-total-wrapper">
          <div class="col-md-8 order-md-1 order-2 mt-md-0 mt-3">
            <p class="card-text mb-0">
            </p>
          </div>

        </div>
        <div class="row" style="align-items: center;">
          <div class="col-sm-10" style="text-align: end;">Sub Total:</div>
          <div class="col-sm-2" >@{{sub_total}}</div>

        </div>
        <div class="row pt-1" style="align-items:center;">
          <div class="col-sm-10" style="text-align: end;">Discount: @{{discount_percent }}%</div>
          <div class="col-sm-2" >@{{discount_total }}</div>
        </div>
        <div class="row pt-1" style="align-items:center;">
          <div class="col-sm-10" style="text-align:end;">Tax: @{{tax_percent}}%</div>
          <div class="col-sm-2" >@{{tax_price}}</div>
        </div>
        <hr style="border:0.5px solid; margin-left:70%;">

        <div class="row pt-1" style="align-items: center; font-weight:600">
          <div class="col-sm-10" style="text-align: end;">Grand Total:</div>
          <div class="col-sm-2">@{{grand_total}}</div>
        </div>
      </div> --}}
    

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
        el: '#purchase_invoice',
        data: {
            size:@json($sizes),
            invoice_no:"{{$invoice['invoice_no']}}",
            date:"{{ $invoice['date'] }}",
            warehouse_name:"{{$invoice['warehouse']['name']}}",
            warehouse_id:"{{$invoice['warehouse']['id']}}",
            retailer_name:"{{ $invoice['client']['name'] }}",
            retailer_id:"{{ $invoice['client']['id'] }}",
            sub_total:"{{ $invoice['grand_total']}}",
            grand_total:"{{ $invoice['sub_total']}}",
            tax_percent:"{{$invoice['tax']['percent']}}",
            tax_price:"{{ $invoice['tax_price'] }}",
            discount_percent:"{{$invoice['discount']}}",
            discount_total:"{{ $invoice['discount_price'] }}",
            child:@json($invoice['detail']),


            
        },
       
        methods: {
      
        
        
      
         
     
       
       
    
         
           
          
         
         
              

             
            
            deleteData(k) {
                    this.child.splice(k, 1)
                }
        },

    })

          

</script>
@endpush


