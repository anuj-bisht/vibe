@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
@include('styles.style')
<style>
 
</style>
<div class="container" id='purchase_invoice'>
  <div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Validate Grn</h4>
            <span>
            <a href="{{route('corporate.all.grn')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
            </span>
        </div>

    </div>
</div>
  
    <div class="col-xl-12 col-md-12 col-12">
      <div class="card invoice-preview-card">
        <div class="card-body invoice-padding pb-0">
          <div class="row">
            <div class="col-md-2" >
              <h4 class="invoice-title">
                GRN No. @{{grn_no }}
              </h4>
            </div>
            <div class="col-md-7" style="text-align:center;">
              <div class="logo-wrapper">
                <img style="max-width:140px;" src="https://vibecode.paramsoft.co.in/public/masters/img/logo.png" alt="">
              </div>
            </div>
            <div class="col-md-3">
              <p class="invoice-date-title">Invoice Date: @{{ new Date(date).toLocaleDateString() }}</p>
              <select class="form-control " data-index="1" id="warehouse" name="warehouse" required v-model="warehouse_object" onkeydown="jumpNextField(event)" v-select2>
                <option disabled selected value="">Select Warehouse</option>
                <option v-for="warehouse in warehouses" :value="warehouse">@{{ warehouse.name }}</option>
            </select>
              {{-- <p class="invoice-date-title">Warehouse: @{{warehouse_name }}</p> --}}
              {{-- <p class="invoice-date-title">Client:  @{{retailer_name }}</p> --}}
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
                                <td v-if="is_export == 0">Action</td>
                              </tr>
                            </thead>
                            <tbody>
                              <tbody  style="text-align:center;" >
                                  <tr v-for="(c, k) in child" :key="k" >
                                      <td >@{{ c.product.product_code }} </td>
                                      <td >@{{ c.color.color_code }}</td>
                                      <td style='text-align:center;' class="tp" v-for="(s,j) in c.cs">@{{child[k].cs[j]}}
                                        {{-- <input
                                          style="width:26px; border:none;" type="number" name="" id="" v-model="child[k].cs[j]"> --}}
                                      </td>
                                      <td ><input type="checkbox" class="form-control" v-model="child[k].defective" style="width:15px;"></td>
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
          <div class="col-sm-1">
        <button  v-if="is_export == 0"  class="btn global_btn_color" @@click="sumbitData()" data-index="7">Validate</button>
        <form id="grnformm" method="post" action="{{ route('moveToGrnSection') }}">
           @csrf
           <input type="hidden" id="grndataa" name="data">
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
              id:"{{$grn['id']}}", // grn_master_id
              retail_id:"{{$grn['retailer_id']}}", //retailer_id
              warehouses: @json($warehouses),
              size:@json($sizes),
              is_export:"{{$grn['is_export']}}",
              grn_no:"{{$grn['grn_no']}}",
              date: new Date(),
              child:@json($grn['detail']),
              warehouse_object:"",
   
  
  
              
          },
         
          methods: {
              sumbitData() {
                  var vm = this;

                  if (vm.warehouse_object == "") {
                    return toastr['success']('Select Warehouse', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                }
            
                  var formData = {};
                  formData.grn_master_id = parseInt(vm.id);
                  formData.grn_no = parseInt(vm.grn_no);
                  formData.retail_id = parseInt(vm.retail_id);
                  formData.warehouse_object = vm.warehouse_object;
                  formData.child = vm.child;
                  vm.formData = JSON.stringify(formData);
                  document.getElementById("grndataa").value = vm.formData;
                  document.getElementById("grnformm").submit();
              },
          },
  
      })
  
      $(document).ready(function() {
        $('#warehouse').select2();
       
    });
  
  </script>
  @endpush