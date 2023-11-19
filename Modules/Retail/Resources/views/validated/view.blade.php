@extends('retail.layouts.app')
@section('retail_content')
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
@include('styles.style')
<style>
 
</style>
<div class="container" id='purchase_invoice'>

  <div class="col-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">View Validated MRN</h4>
            <a href="{{route('purchase.validated.listing')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>

        </div>
    </div>
</div>


  <!-- Invoice -->
  <div class="col-xl-12 col-md-12 col-12">
    <div class="card invoice-preview-card">
      <div class="card-body invoice-padding pb-0">
        <div class="row">
          <div class="col-md-3" >
            <h4 class="invoice-title">
                Validated MRN
            </h4>
          </div>
          <div class="col-md-6" style="text-align:center;">
            <div class="logo-wrapper">
              <img style="max-width:140px;" src="https://vibecode.paramsoft.co.in/public/masters/img/logo.png" alt="">
            </div>
          </div>
          <div class="col-md-3">
            <p class="invoice-date-title">Validation Date: @{{ new Date(date).toLocaleDateString() }}</p>
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
                              <td>Qty</td>
                              <td>Total</td>
                           
                            </tr>
                          </thead>
                          <tbody>
                            <tbody  style="text-align:center;" >
                                <tr v-for="(c, k) in child" :key="k">
                                    <td>@{{ c.product.product_code }} </td>
                                    <td>@{{ c.color.color_code }}</td>
                                    <td style='text-align:center;' class="tp" v-for="(s,j) in c.cs"><input readonly
                                        style="width:26px; border:none;" type="number" name="" id="" v-model="child[k].cs[j]"></td>
                                    <td>@{{c.qty}}</td>
                                    <td>@{{c.total}}</td>

                                </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12" style="display: flex; justify-content: end">
                  <b>Total Qty : @{{totalQTY}}</b>
                </div>
              </div>
            
            </div>
          </div>
         
        </div>
      </section>
        {{-- <div class="col-sm-1">
      <button v-if="is_export == 0" class="btn global_btn_color" @@click="sumbitData()" data-index="7">Export</button>
      <form id="mainformm" method="post" action="{{ route('moveToClientExport') }}">
         @csrf
         <input type="hidden" id="formdataa" name="data">
      </form>
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
            id:"{{$eproducts['id']}}",
            is_export:"{{$eproducts['is_export']}}",
            invoice_no:"{{$eproducts['invoice_no']}}",
            date:"{{$eproducts['date'] }}",
            warehouse_name:"{{$eproducts['warehouse']['name']}}",
            warehouse_id:"{{$eproducts['warehouse']['id']}}",
            retailer_name:"{{$eproducts['client']['name'] }}",
            total_pcs:"{{$eproducts['total_pcs']}}",
            retailer_id:"{{$eproducts['client']['id'] }}",
            sub_total:"{{$eproducts['grand_total']}}",
            grand_total:"{{$eproducts['sub_total']}}",
            tax_percent:"{{$eproducts['tax']['percent']}}",
            tax_id:"{{$eproducts['tax']['id']}}",
            tax_price:"{{$eproducts['tax_price'] }}",
            discount_percent:"{{$eproducts['discount']}}",
            discount_total:"{{$eproducts['discount_price'] }}",
            child:@json($eproducts['detail']),
            formData:"",
            total:0,


            
        },
       
        methods: {
            sumbitData() {
                var vm = this;
       
                var formData = {};
                // formData.invoice_id = parseInt(vm.invoice_id);
                // formData.warehouse_id = parseInt(vm.warehouse_id);
                formData.id = parseInt(vm.id);
                formData.invoice_no = parseInt(vm.invoice_no);
                formData.regular = 0;
                formData.data = vm.date;
                formData.client_id = parseInt(vm.retailer_id);
                formData.tax_id=parseInt(vm.tax_id);
                formData.tax_price=parseInt(vm.tax_price);
                formData.total_pcs = parseInt(vm.total_pcs);
                formData.discount = parseInt(vm.discount_percent);
                formData.discount_price = parseInt(vm.discount_total);
                formData.sub_total = parseInt(vm.sub_total);
                formData.grand_total = parseInt(vm.grand_total);
                formData.child = vm.child;
                vm.formData = JSON.stringify(formData);
                document.getElementById("formdataa").value = vm.formData;
                document.getElementById("mainformm").submit();
            },
          //   callTotal(){
          //     vm = this;
          //  for(i=0; i < vm.child.length; i++){
          //        vm.total += vm.child[i].qty;
          //   }
          //   return vm.total;
          //   }
        },
        computed:{
          totalQTY(){
            vm = this;
            qty = 0;
           for(i=0; i < vm.child.length; i++){
                  qty += vm.child[i].qty;
            }
            return qty;
          }
        }

    })

          

</script>
@endpush


