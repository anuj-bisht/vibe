@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
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
</style>
<div class="container" id='publish_picklist_invoice'>

  <!-- Invoice -->
  <div class="col-xl-12 col-md-12 col-12">
    <div class="card invoice-preview-card mb-1" >
      <div class="card-body invoice-padding pb-0">
        <div class="row">
          <div class="col-md-2" >
            <h4 class="invoice-title">
              Invoice No.
              <span class="invoice-number"> @{{ invoiceNumber }}</span>
            </h4>
          </div>
          <div class="col-md-7" style="text-align:center;">
            <div class="logo-wrapper">
              <img style="max-width:140px;" src="https://vibecode.paramsoft.co.in/public/masters/img/logo.png" alt="">
            </div>
          </div>
          <div class="col-md-3">
          
            <p class="invoice-date-title">Date Issued: @{{ invoiceDate }}</p>
            <select class="form-control " data-index="1" id="warehouse" name="warehouse" required
              v-model="warehouse_object" onkeydown="jumpNextField(event)" v-select2>
              <option disabled selected value="">Select Warehouse</option>
              <option v-for="warehouse in warehouses" :value="warehouse">@{{ warehouse.name }}</option>
            </select>
          </div>
        </div>

      </div>

      <hr class="invoice-spacing" />

      <!-- Address and Contact starts -->
      <div class="card-body invoice-padding pt-0" style="padding:0.5rem;">
        <div class="row invoice-spacing">
          <div class="col-md-4 col-12">
            <div class="form-group">
              <label for="city-column" style="color:black; ">Select State</label>
              <select class="form-control " data-index="1" id="state" name="state" required v-model="state_object"
                 @@change="getClient" v-select2 :disabled="client_name.length > 1">
                <option disabled selected value="">Select State</option>
                <option v-for="state in states" :value="state">@{{ state.name }}</option>
              </select>
            </div>
          </div>


          <div class="col-md-4 col-12">
            <div class="form-group">
              <label for="city-column" style="color:black; ">Clients</label>
              <a style="float: right;" href="{{route('corporate.create')}}" target="_blank" style="color:blue; ">Create</a>
              <select v-if="client_name.length < 1" class="form-control " id="client" name="client" data-index="3"
                v-model="client_object" ref="clientFocus" @@change="getThisClientDiscount" v-select2>
                <option disabled selected value="">Select Client</option>
                <option v-for="client in clients" :value="client"> @{{ client.name }}</option>
              </select>
              <input v-if="client_name.length > 1" type="text" class="form-control" v-model="client_name" disabled />
            </div>
          </div>

          <div class="col-md-4 col-12">
            <div class="form-group">
              <label for="city-column" style="color:black; ">Address</label>
              <textarea class="form-control" type="text" v-model="address" :disabled="true"></textarea>
            </div>
          </div>
        </div>
      </div>
      <!-- Address and Contact ends -->
    </div>
  </div>
  <!-- /Invoice -->


  <!-- Invoice -->
  <div class="col-md-12 d-flex justify-content-end">
    <abbr  data-toggle="tooltip" :data-original-title=scannerStatus><img style="width:30px; height:30px; object-fit:contain; margin-left:10px; cursor: pointer;"  @@click="changeStatus()"  src={{asset('device.jpeg')}} alt="Image"/></abbr>
  </div>

  <div class="col-xl-12 col-md-12 col-12">
    <div class="card invoice-preview-card">


      <div id="ean" class="row"
        :style="[search != 1 ? {'justify-content': 'center'} : {'padding-bottom':'50px'}]">
        <div  class="col-md-9">
          <div class="card">
            <div class="card-header">
              <input v-if="isActive" class="form-control input" type="text" placeholder="Search Ean" data-search="search"
                v-model="typeEan" id="ean_no" @@input="searchEAN(this)" :disabled="search == 1">
                
            </div>
          </div>
        </div>
        <div class="col-md-2" :style="[client_name.length < 1 ? {'display': 'none'} : {'padding-top':'20px'}]">
          <button class="btn btn-sm global_btn_color" @@click="directChild" data-index="7">Get All</button>
        </div>
   
      </div>

      <!-- Invoice Description starts -->
      <section  v-if="search != 1"  id="input-mask-wrapper" style="position: relative; top:-20px;">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="row" v-if="!isActive">
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
                            <v-select label="product_code" :options="products" v-model="product_object" ref="productSelect"
                              @@input="getColor"  @@close="focusVSelect" @@search="searchProduct"></v-select>
                          </td>
                          <td style="width:8rem;">
                            <input type="hidden" id="pro_code">
                            <select data-index="3" class="form-control" ref="colorSelect" id="color" v-model="color_object"
                              name="color_id" required @@change="getColorObject($event)" v-select2>
                              <option selected disabled></option>
                              <option v-for="color in colors" :value="color"> @{{ color.color.color_code }}

                              </option>
                            </select>
                          </td>
                          <td v-for="(size, k) in sizes" :key="k">
                            <input type="number" name="cutting_plans" v-model="size.value"
                              class="form-control input cutting_plans" style="padding:0px !important;"
                              @@change='updateTotal(warehouse_object.id,product_object.id, color_object.color_id,size.id,size.value, k)' @@change='checkInputQty' @@keydown.enter="goToNextField(k)">
                          </td>
                          {{-- @@change="calData(child[k],k,c.product_id,c.color_id,child[k].cs[j],j,k,j)" --}}

                          <td style="width:5rem;"><input readonly v-model="totalq" type="number" name="sum" id="total"
                              class="form-control cuttingplantotal" data-index="5" onkeydown="jumpNextField(event)">
                          </td>
                          <td>
                            <button class="btn global_btn_color" ref="totalfocus" @@click="toBottom()" data-index="6"
                              onclick="jumpNextField(event)"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <polyline points="19 12 12 19 5 12"></polyline>
                              </svg></button>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <div id="errorMessage" style="color:red;" v-for="err in error">@{{ err }}</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      <section id="input-mask-wrapper" style="position: relative; top:-70px;">
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
                              <td style="text-align:center;">Action</td>
                            </tr>
                          </thead>
                          <tbody>
                            <tr id="" v-for="(c, k) in child" :key="k">
                              <td style="text-align:center;" class="tp"> @{{ c.product_name }} </td>
                              <td style="text-align:center;" class="tp"> @{{ c.color_name }} </td>
                              <td style='text-align:center;' class="tp" v-for="(s,j) in c.cs"><span
                                  v-if="child[k].cs[j].err != ''"
                                  style="color:red;">@{{child[k].cs[j].err}}</span><input
                                  @@change="calData(child[k],k,c.product_id,c.color_id,child[k].cs[j],j,k,j)"
                                  style="width:35px; border:none;" type="number" name="" id="" v-model="child[k].cs[j]">
                              </td>
                              <td style="text-align:center;" class="tp">@{{ c.totalq }}</td>
                              <td style="text-align:center;" class="tp">@{{ c.per_qty }}</td>
                              <td style="text-align:center;" class="tp">@{{ c.total_price }}</td>
                              <td style="paddng:0.75px !important"><a class="btn btn-sm btn-danger"
                                  href="javascript:void(0)" @@click="deleteData(k)"><svg
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-trash-2">
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

          <div class="col-sm-9" style="text-align: end;">Sub Total:</div>

          <div class="col-sm-2"></div>

          <div class="col-sm-1" v-if="child.length > 0">@{{parseFloat(grantTotal).toFixed()}}</div>

        </div>

        <div class="row pt-1" style="align-items:center;">

          <div class="col-sm-9" style="text-align: end;">Discount:</div>

          <div class="col-sm-2"><select class="form-control " id="discount" @@change="calculatediscount" name="discount"

              data-index="3" v-model="discount" v-select2>

              <option disabled selected value="">Discount</option>

              <option v-for="discount in discounts" :value="discount.percent">@{{discount.percent}}</option>

            </select> </div>

          <div class="col-sm-1" v-if="child.length > 0">@{{parseFloat(amtafterdiscount).toFixed(2)}}</div>

        </div>

        <div class="row pt-1" style="align-items:center;">

          <div class="col-sm-9" style="text-align:end;">Tax:</div>

          <div class="col-sm-2"><select class="form-control " id="tax" name="tax" data-index="3" v-model="tax_object"

              v-select2 @@change="calculateAmount">

              <option disabled selected value="">Select Tax</option>

              <option v-for="tax in taxes" :value="tax"> @{{ tax.name }} - @{{ tax.percent }}</option>

            </select></div>

          <div class="col-sm-1" v-if="child.length > 0">@{{parseFloat(tax_amt).toFixed(2)}}</div>

        </div>

        <hr style="border:0.5px solid; margin-left:65%;">



        <div class="row pt-1" style="align-items: center; font-weight:600">

          <div class="col-sm-9" style="text-align: end;">Grant Total:</div>

          <div class="col-sm-2"></div>

          <div class="col-sm-1" v-if="child.length > 0">@{{parseFloat(afterWholeCalc).toFixed(2)}}</div>

        </div>

      </div>

    



      <div class="col-sm-2">
        <button class="btn global_btn_color" @@click="sumbitData()" data-index="7">Save</button>
        <form id="invoiceform" method="post" action="{{ route('moveToInvoice') }}">
          @csrf
          <input type="hidden" id="invoicedata" name="data">

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
        el: '#publish_picklist_invoice',
        data: {
            typeEan: "",
            sizes: @json($sizes),
            invoiceNumber: {{$invoiceNumber}},
            invoiceDate:new Date().toISOString().slice(0, 10),
            states:@json($states),
            clients: [],
            warehouses: @json($warehouses),
            taxes: @json($tax),
            discounts: @json($discount),
            tax_object:null,
            discount_object:null,
            client_name:{!! $invoice_data == null ? "''": json_encode($invoice_data->corporate_profiles->name) !!},
            client_object: {!! $invoice_data == null ? "null": json_encode($invoice_data->corporate_profiles) !!},
            warehouse_object: @json($default_warehouse),
            product_object :"",
            state_object:{!! $invoice_data == null ? "''": json_encode($invoice_data->corporate_profiles->billing_states) !!},
            products:[],
            colors:[],
            color_object:"",
            child: [],
            dummychild:{!! $invoice_data == null ? "[]": json_encode($child) !!},
            pc_price:"",
            totalq:"",
            error:[],
            discount:{!! $invoice_data == null ? "''": json_encode((int)$invoice_data->corporate_profiles->discounts->percent) !!},
            itotalq:0,
            grantTotal:{!! $invoice_data == null ? "0": json_encode($grant_total) !!},
            percent:0,
            afterWholeCalc:0,
            amtafterdiscount:{!! $invoice_data == null ? "0": json_encode($amtAfterDiscount) !!},
            amtaftertax:0,
            address:"{{$invoice_data == null ? "": $invoice_data->corporate_profiles->billing_address}}",
            tax_amt:0,
            amtafterdiscountt:{!! $invoice_data == null ? "0": json_encode($amtAfterDiscountt) !!},
            picklist_master_id:{!! $invoice_data == null ? "''": json_encode($picklist_master_id) !!},
            search:0,
            plucksize:@json($plucksize),
            margin_percent:0,
            scannerStatus:"Disable Scanner",
            isActive:true,
        },
       
        methods: {
          goToNextField(index) {
                vm=this;
                if(index == 11){
                  vm.$refs.totalfocus.focus();
                }
              else{
                const nextField = document.getElementsByName("cutting_plans")[index + 1];
                nextField.focus();
              }
              },
          changeStatus(){
            vm =this;
                 if(vm.isActive == true){
                 vm.isActive =  false;
                 vm.scannerStatus = "Enabled Scanner";
                 }
                 else{
                  vm.isActive =  true;
                 vm.scannerStatus = "Disabled Scanner";
                 }
          },
          focusVSelect:function(){
                vm=this;
                vm.$refs.colorSelect.focus();
            },
          directChild:function(){
            vm=this;
            vm.search= vm.search==0 ? 1 :0;
            vm.child=vm.search == 0 ? [] : vm.dummychild;

          },
          calData:function(data,k,product_id,color_id,qty, size_id,data_index,child_index){
            vm=this;
       
           if(vm.picklist_master_id.length > 0){
            const d = JSON.stringify({ 
                        prod_id:product_id,
                        col_id : color_id,
                        pick_mas_id: vm.picklist_master_id,
                        qy:qty,
                        s_id:size_id
                });
                const config = {
                    headers: {'Content-Type': 'application/json'}
                }
                axios.post("{{ url('/checkqty') }}", d,config).then(res => {
                    console.log(res.data);
                    if(res.data.cqty < 0){
                      vm.child[data_index].cs[child_index] = res.data.qty;
                      return   toastr['success'](`Only  ${res.data.qty} Quantities available`, '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                  total=0;
            for (i in vm.child[k].cs) {
                    total+=parseInt(vm.child[k].cs[i]);
              }
            
              vm.child[k].totalq=total;
              vm.child[k].total_price=total*vm.child[k].per_qty;
              this.calc_grant_total();
                    }else{
                        console.log(vm.child[data_index].cs[child_index]);
                        vm.child[data_index].cs[child_index]=res.data.qty-res.data.cqty;
                        total=0;
            for (i in vm.child[k].cs) {
                    total+=parseInt(vm.child[k].cs[i]);
              }
            
              vm.child[k].totalq=total;
              vm.child[k].total_price=total*vm.child[k].per_qty;
              this.calc_grant_total();
                    }
                });
              }else{
                const wareData = JSON.stringify({ 
                        prod_id:product_id,
                        col_id : color_id,
                        qy:qty,
                        s_id:size_id,
                        warehouse_id:vm.warehouse_object.id
                });
                const config = {
                    headers: {'Content-Type': 'application/json'}
                }
                axios.post("{{ url('/checkwarehouseqty') }}", wareData,config).then(res => {
                    console.log(res.data);
                    if(res.data.cqty < 0){
                      vm.child[data_index].cs[child_index] = res.data.qty;
                      return   toastr['success'](`Only  ${res.data.qty} Quantities available`, '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                  total=0;
            for (i in vm.child[k].cs) {
                    total+=parseInt(vm.child[k].cs[i]);
              }
  
              vm.child[k].totalq=total;
              vm.child[k].total_price=total*vm.child[k].per_qty;
              this.calc_grant_total();
                    }else{
                        console.log(vm.child[data_index].cs[child_index]);
                        vm.child[data_index].cs[child_index]=res.data.qty-res.data.cqty;
                        total=0;
            for (i in vm.child[k].cs) {
                    total+=parseInt(vm.child[k].cs[i]);
              }
              vm.child[k].totalq=total;
              vm.child[k].total_price=total*vm.child[k].per_qty;
              this.calc_grant_total();
                    }
                });
              }
          },
          calc_grant_total:function(){
            vm=this;
            sum=0;
            gtotal=0;
            for (i in vm.child) {
                    sum+= vm.child[i].totalq;
                    gtotal+= vm.child[i].total_price;             
              }
              vm.itotalq=sum;
              vm.grantTotal=gtotal;

              var cal_amt =0;
              var dis_sub_amt=0;
              var amount_after_discount=0;
              var dis_sub_amt =(vm.grantTotal * vm.discount)/100;
              var amount_after_discount=vm.grantTotal-dis_sub_amt ;
              vm.amtafterdiscountt=amount_after_discount;
              vm.amtafterdiscount=dis_sub_amt;
              vm.tax_object=null;
              vm.tax_amt=0;
              vm.afterWholeCalc=0;
          },
          calculate:function(){
            vm=this;
              var tax_sub_amount=0;
              var amount_after_tax=0;
              var tax_sub_amount=(vm.amtafterdiscountt * parseInt(vm.tax_object.percent))/100;
              var amount_after_tax=vm.amtafterdiscountt-tax_sub_amount;
              vm.tax_amt=tax_sub_amount;
              vm.afterWholeCalc =  amount_after_tax;
          },
          calculatediscount:function(){
            vm=this;
              var sub_discount =0;
              var tax_amount=0;
              sub_discount=(vm.grantTotal*vm.discount)/100;
              vm.amtafterdiscount=vm.grantTotal-sub_discount;
              this.calculate();
          },
          searchProduct(search, loading){
            vm=this;
           
            if (search.length < 1) {
                return ;
            }
            vm.colors = [];
            if(vm.picklist_master_id.length > 0){
              axios.get(`{{ url('/getProductSearch')}}/${search}`).then(res => {
                vm.products= res.data.data;
              })
            }
            else{
              const data = JSON.stringify({
                        warehouse_id: vm.warehouse_object.id,
                        srch:search
                    });
                    const config = {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }
                    axios.post("{{ url('/getProductByGoods') }}", data, config).then(res => {
                    vm.products = res.data.data;
                })
            }
          },
          getColor:function(event){
            vm=this;
            if(vm.picklist_master_id.length > 0){
              vm.colors=vm.product_object.subproduct;
            }else{
      const data = JSON.stringify({
                        warehouse_id: vm.warehouse_object.id,
                        p_id:vm.product_object.id
                    });
                    const config = {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }
                    axios.post("{{ url('/getColorByGoods') }}", data, config).then(res => {
                    vm.colors = res.data.data;
                })
            }
          },
          total: function(item) {
              var sum = 0;
              for (i in item) {
                  var b = parseInt(item[i]);
                  if (!isNaN(b))
                      sum += parseInt(item[i]);
              }
              return sum;
          },
          totalamt: function(item ,total_amt) {
              var sum = 0;
              for (i in item) {
                  var b = parseInt(item[i]);
                  if (!isNaN(b))
                      sum += parseInt(item[i]);
              }
              return sum*total_amt
          },
          getClient:function(){
            vm=this;
            vm.$refs.clientFocus.focus();
            vm.clients=[];
            axios.get(`{{ url('/getClient')}}/${vm.state_object.id}`).then(res => {
              vm.clients=res.data.data;
            });
          },

          calculateAmount:function(){
            vm=this;
            vm.percent=vm.tax_object.percent;
            this.calculate();
          },
          getThisClientDiscount:function(){
            vm=this;
            vm.$refs.productSelect.searchEl.focus();
            vm.address=vm.client_object.billing_address;
            vm.discount=parseInt(vm.client_object.discounts.percent);
            vm.commission=parseInt(vm.client_object.commissions.percent);
          },
          searchEAN:function(e){
                vm=this;
               
                if(vm.warehouse_object == null){
                 return toastr['success']('Select Warehouse', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                }
                if(vm.client_object == null){
                 return toastr['success']('Select Client', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                }
                if(vm.typeEan.length  == 13){
                    $('#searchErrorMessage').text("");
                    const data = JSON.stringify({ 
                      warehouse_id:vm.warehouse_object.id,
                      product_ean : vm.typeEan,
                      picklist_master_id:vm.picklist_master_id});
                const config = {
                    headers: {'Content-Type': 'application/json'}
                }

                axios.post("{{ url('/getDataBySearchhh') }}", data,config).then(res => {
                  if(res.data.data.qty.qty == 0 ){
                  return   toastr['success'](`${res.data.data.qty.size.size} has 0 quantity`, '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                  }
                vm.color_id=res.data.data.product.color_id;
                vm.product_object={id : res.data.data.product.product_master_id};
                  var id = res.data.data.qty.size_id;
                  var cs = {};
                  for (k in vm.sizes) {
                            cs[vm.sizes[k].id] = vm.sizes[k].id == res.data.data.qty.size_id ? 1 : 0 
                        }
                  if(vm.child.length > 0){
                        var product =  vm.child.filter(function(el) {
                          return el.color_id == vm.color_id && el.product_id == vm.product_object.id;
                        }); 

                        if(product.length > 0){
                          let spl_key = []
                                        for(const [key,val] of Object.entries(vm.child)){
                                               if(val.product_name == product[0].product_name){
                                                spl_key.push(key)
                                               }
                                        } 
                                     if(parseInt(product[0].cs[res.data.data.qty.size_id]) <  res.data.data.qty.qty){
                                      vm.child[spl_key].cs[res.data.data.qty.size_id] = parseInt(product[0].cs[res.data.data.qty.size_id]) + 1;
                                      vm.child[spl_key].totalq = product[0].totalq + 1;
                                      vm.child[spl_key].total_price=vm.child[spl_key].totalq*product[0].per_qty;
                                     }
                                     else{
                                      return  toastr['success'](`No Quantity left`, '', {
                                          closeButton: true,
                                          tapToDismiss: false,
                                          progressBar: true,
                                        });
                                     }
                          this.calc_grant_total(); 
                          vm.color_object="";
                          vm.product_object="";       
                          vm.typeEan = "";
                 
                        }else{
                          var search_margin = res.data.data.product.margin;
                        switch (search_margin) {
                          case 'A': vm.margin_percent = parseInt(vm.client_object.A);
                          break;
                        
                          case 'B':  vm.margin_percent = parseInt(vm.client_object.B);
                          break;
                        
                          case 'C':  vm.margin_percent = parseInt(vm.client_object.C);
                          break;
                        
                          case 'D':  vm.margin_percent = parseInt(vm.client_object.D);
                          break;
                        
                      
                        }
                          var product_commission=(parseInt(res.data.data.product.mrp)*vm.margin_percent)/100;
                          var p_rate=parseInt(res.data.data.product.mrp)-product_commission;
                          vm.child.push({
                                      "totalq": 1,
                                      'product_id':res.data.data.product.product_master_id,
                                      'product_name':res.data.data.product.parent.product_code,
                                      'color_id':res.data.data.product.color_id,
                                      'color_name':res.data.data.product.color.color_code,
                                      'per_qty':p_rate,
                                      'total_price':p_rate,
                                      cs
                                      });
                                      this.calc_grant_total();
                                      vm.color_object="";
                                      vm.product_object="";
                                      vm.typeEan = "";

                        }
                      }else{
                        var search_margin = res.data.data.product.margin;
                        switch (search_margin) {
                          case 'A': vm.margin_percent = parseInt(vm.client_object.A);
                          break;
                        
                          case 'B':  vm.margin_percent = parseInt(vm.client_object.B);
                          break;
                        
                          case 'C':  vm.margin_percent = parseInt(vm.client_object.C);
                          break;
                        
                          case 'D':  vm.margin_percent = parseInt(vm.client_object.D);
                          break;
                        
                      
                        }
                      
                        var product_commission=(parseInt(res.data.data.product.mrp)*vm.margin_percent)/100;
                        var p_rate=parseInt(res.data.data.product.mrp)-product_commission;
                        vm.child.push({
                                      "totalq": 1,
                                      'product_id':res.data.data.product.product_master_id,
                                      'product_name':res.data.data.product.parent.product_code,
                                      'color_id':res.data.data.product.color_id,
                                      'color_name':res.data.data.product.color.color_code,
                                      'per_qty':p_rate,
                                      'total_price':p_rate,
                                      cs
                                      });
                                      this.calc_grant_total();
                                      vm.color_object="";
                                      vm.product_object="";
                                      vm.typeEan = "";


                      } 
                }).catch(error => {
                  toastr['success']('Product not found', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                  vm.color_object="";
                vm.product_object=""; 
                vm.typeEan = "";
                          });
                }else{
                    $('#searchErrorMessage').text("EAN Should be 13 Digit");

                }
               
             },
           
            getColorObject:function(){
            vm=this;
            axios.get(`{{ url('/getProductColorPrice')}}/${vm.product_object.id}/${vm.color_object.color.id}}`).then(res => {
              vm.pc_price=parseInt(res.data.data.mrp);
              var margin = res.data.data.margin;
              
            switch (margin) {
               case 'A': vm.margin_percent = parseInt(vm.client_object.A);
               break;
            
               case 'B':  vm.margin_percent = parseInt(vm.client_object.B);
               break;
            
               case 'C':  vm.margin_percent = parseInt(vm.client_object.C);
               break;
            
               case 'D':  vm.margin_percent = parseInt(vm.client_object.D);
               break;
            
           
            }
               const nextField = document.getElementsByName("cutting_plans")[0];
                  nextField.focus();
              });
          },
            getPicklistNo() {
                vm = this;

            },
            updateTotal(w_id,p_id, c_id,size_id,size_val,sizes_key) {
              if(vm.picklist_master_id.length > 0){
                const d = JSON.stringify({ 
                prod_id:p_id,
                col_id : c_id,
                pick_mas_id: vm.picklist_master_id,
                qy:size_val,
                s_id:size_id
              });
              const config = {
                  headers: {'Content-Type': 'application/json'}
              }
              axios.post("{{ url('/checkqty') }}", d,config).then(res => {
                console.log(res.data);
                if(res.data.cqty < 0){
                
                toastr['success'](`Only  ${res.data.qty} Quantities available`, '', {
                closeButton: true,
                tapToDismiss: false,
                progressBar: true,
              });
              vm.sizes[sizes_key].value=res.data.qty;
                }else{
                  vm.sizes[sizes_key].value=size_val;
                }
                vm.sub();

              });
              }
              else{
              const wareData = JSON.stringify({ 
                prod_id:p_id,
                col_id : c_id,
                qy:size_val,
                s_id:size_id,
                warehouse_id:w_id
                });
              const config = {
                  headers: {'Content-Type': 'application/json'}
              }
              axios.post("{{ url('/checkwarehouseqty') }}", wareData,config).then(res => {
                if(res.data.cqty < 0){
                  toastr['success'](`Only  ${res.data.qty} Quantities available`, '', {
                  closeButton: true,
                  tapToDismiss: false,
                  progressBar: true,
                });
                vm.sizes[sizes_key].value=res.data.qty;
                }else{
                  vm.sizes[sizes_key].value=size_val;
                }
               vm.sub();
              });
            }



               
                },
                sub(){
                  vm=this;
                var total = 0;
                for (var i in vm.sizes) {
                total += parseInt(vm.sizes[i].value) ? parseInt(vm.sizes[i].value) : 0;
                }
                  vm.totalq=total;
                },
                toBottom() {
                  vm=this;
                  if(vm.warehouse_object == null){
                 return toastr['success']('Select Warehouse', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                }
                if(vm.client_object == null){
                 return toastr['success']('Select Client', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                }
                  if (vm.product_object.id != 0  && vm.color_object.color_id > 0 ) {
                  var cs = {};
                  var css = {};
                        for (k in vm.sizes) {
                            cs[vm.sizes[k].id] = vm.sizes[k].value ? parseInt(vm.sizes[k].value) : 0
                        }
                           const obj = {warehouse_id:vm.warehouse_object.id, invoice_product_id: vm.product_object.id, color_id:vm.color_object.color.id,picklist_master_id:vm.picklist_master_id}
                            const options = {
                            headers: {'X-Custom-Header': 'value'}
                          };
                            axios.post(`{{ url('/checkquantity')}}`,obj)
                          .then(response => {
                            if(vm.child.length > 0){

                              var product=  vm.child.filter(function(el) {
                                return el.color_id== vm.color_object.color.id && el.product_id== vm.product_object.id;
                              });
                              
                            if(product.length > 0){
                              
                              vm.error=[];
                              for (k in vm.sizes) {
                                css[vm.sizes[k].id] = vm.sizes[k].value ? parseInt(vm.sizes[k].value) : 0
                                }
                                let totalqty={};
                                 for(let csskeys in css){
                                     totalqty[csskeys]= css[csskeys] + product[0].cs[csskeys];
                                 }


                                 let difference={};
                                    for(let key in response.data.data){
                                      difference[key]=response.data.data[key] - totalqty[key]
                                    }
                                 let hasNegativeValue=false;
                                    for(const val of Object.values(difference)){
                                      if(val < 0){
                                        hasNegativeValue=true;
                                        break;
                                      }
                                    }
                                    if(hasNegativeValue){
                                      let qt = {};
                                        for(let key in product[0].cs){
                                        qt[key]=response.data.data[key] - product[0].cs[key]
                                        }
                                        let negativeKeys=[];
                                        for(const [key , value] of Object.entries(difference)){
                                          if(value < 0){
                                            negativeKeys.push(key);
                                          }
                                        }
                                        for(const val of negativeKeys){
                                          vm.error.push(`${vm.plucksize[val]} has ${qt[val]} Qty`);

                                        }   
                                    }else{
                                      let spl_key = []
                                        for(const [key,val] of Object.entries(vm.child)){
                                               if(val.product_name == product[0].product_name){
                                                spl_key.push(key)
                                               }
                                        }
                                        var totalQTY=parseInt(vm.totalq) + parseInt(product[0].totalq);
                                        vm.child[spl_key].cs = totalqty;  
                                        vm.child[spl_key].totalq=totalQTY;
                                        vm.child[spl_key].total_price=totalQTY*product[0].per_qty;
                                        vm.totalq = 0;
                                      for (k in vm.sizes) {
                                          vm.sizes[k].value = 0;
                                      }
                                      vm.color_object="";
                                     vm.product_object="";      
                                     vm.colors=[],
 
                                      vm.$refs.productSelect.searchEl.focus();
                                      this.calc_grant_total();
                                     
                                    }

                            }else{
                              vm.error=[];
                                    let difference={};
                                    for(let key in response.data.data){
                                      difference[key]=response.data.data[key] - cs[key]
                                    }
                                    let hasNegativeValue=false;
                                    for(const val of Object.values(difference)){
                                      if(val < 0){
                                        hasNegativeValue=true;
                                        break;
                                      }
                                    }
                                    if(hasNegativeValue){
                                        let negativeKeys=[];
                                        for(const [key , value] of Object.entries(difference)){
                                          if(value < 0){
                                            negativeKeys.push(key);
                                          }
                                        }
                                        return console.log(negativeKeys);
                                        for(const val of negativeKeys){
                                          vm.error.push(`${vm.plucksize[val]} has ${response.data.data[val]} Qty`);

                                        }
                                    }else{
                                      var product_commission=(vm.pc_price*vm.margin_percent)/100;
                                      var p_rate=vm.pc_price-product_commission;
                                  
                                      vm.child.push({
                                      "totalq": vm.totalq,
                                      'product_id':vm.product_object.id,
                                      'product_name':vm.product_object.product_code,
                                      'color_id':vm.color_object.color.id,
                                      'color_name':vm.color_object.color.color_code,
                                      'per_qty':p_rate,
                                      'total_price':vm.totalq*p_rate,
                                      cs,
                                      });
                                      vm.totalq = 0;
                                      for (k in vm.sizes) {
                                          vm.sizes[k].value = 0;
                                      }
                                      vm.color_object="";
                                      vm.product_object="";    
                                      vm.colors=[],   
                                      vm.$refs.productSelect.searchEl.focus();
                                      this.calc_grant_total();
                                        }
                            }
                            }
                              else{
                                    vm.error=[];
                                    let difference={};
                                    for(let key in response.data.data){
                                      difference[key]=response.data.data[key] - cs[key]
                                    }
                                  
                                    let hasNegativeValue=false;
                                    for(const val of Object.values(difference)){
                                      if(val < 0){
                                        hasNegativeValue=true;
                                        break;
                                      }
                                    }
                                    if(hasNegativeValue){
                                        let negativeKeys=[];
                                        for(const [key , value] of Object.entries(difference)){
                                          if(value < 0){
                                            negativeKeys.push(key);
                                          }
                                        }
                                        for(const val of negativeKeys){
                                            vm.error.push(`${vm.plucksize[val]} has ${response.data.data[val]} Qty`);
                                         
                                        }
                                        console.log(vm.error);
                                        return toastr['success'](`${vm.error}`, '', {
                                                    closeButton: true,
                                                    tapToDismiss: false,
                                                    progressBar: true,
                                                  });
                                    }else{
                                      var product_commission=(vm.pc_price*vm.margin_percent)/100;
                                      var p_rate=vm.pc_price-product_commission;
                                      vm.child.push({
                                      "totalq": vm.totalq,
                                      'product_id':vm.product_object.id,
                                      'product_name':vm.product_object.product_code,
                                      'color_id':vm.color_object.color.id,
                                      'color_name':vm.color_object.color.color_code,
                                      'per_qty':p_rate,
                                      'total_price': vm.totalq*p_rate,
                                      cs,
                                      });
                                      vm.totalq = 0;
                                      for (k in vm.sizes) {
                                          vm.sizes[k].value = 0;
                                      }
                                      vm.color_object="";
                                      vm.product_object=""; 
                                      vm.colors=[],      
                                      vm.$refs.productSelect.searchEl.focus();
                                      this.calc_grant_total();
                                        }
                                  }       
                          })
                          .catch(error => {
                            vm.$refs.productSelect.searchEl.focus();
                            vm.totalq = 0;
                            for (k in vm.sizes) {
                                vm.sizes[k].value = 0;
                            }
                            vm.color_object="";
                            vm.product_object="";  
                            vm.colors=[];    
                            return toastr['success']('Product Not Found In Warehouse', '', {
                              closeButton: true,
                              tapToDismiss: false,
                              progressBar: true,
                            });
                                   

                          }); 
                        }
                },

                sumbitData() {
              var vm = this;
              if(vm.child.length == 0){
                 return toastr['success']('Fill all details', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                }
              var formData = {};
              formData.invoiceNumber = vm.invoiceNumber;
              formData.regular = 0;
              formData.invoiceDate = vm.invoiceDate;
              formData.client_id=vm.client_object.id;
              formData.tax_id=vm.tax_object.id;
              formData.total_pcs = vm.itotalq;
              formData.discount=vm.discount;
              formData.discount_price=vm.amtafterdiscount;
              formData.tax_price=vm.tax_amt;
              formData.sub_total=vm.grantTotal;
              formData.grant_total=vm.afterWholeCalc;
              formData.warehouse_id = vm.warehouse_object.id; 
              formData.detail = vm.picklistData;
              formData.picklist_master_id=parseInt(vm.picklist_master_id);
              formData.child=vm.child;
              vm.formData = JSON.stringify(formData);
              document.getElementById("invoicedata").value = vm.formData;
              document.getElementById("invoiceform").submit();

          },
            clickCheckbox: function() {
                var vm = this;
                checkBox = document.getElementById('checkbox');
                if (checkBox.checked) {
                    $('.unchecksection').hide();
                    vm.regular = 1;
                } else {
                    $('.unchecksection').show();
                    vm.regular = 0;
                }
            },
            deleteData(k) {
                    this.child.splice(k, 1)
                }
        },
        mounted(){
        $('#warehouse').select2();
        $('#client').select2();
        $('#state').select2();
        $('#state').select2('open');

        }

    })

          

          function jumpNextField(event){
        if(event.which ==  13){
            event.preventDefault();
            var $this = $(event.target);
            var index = parseFloat($this.attr('data-index'));
            $('[data-index="' + (index + 1).toString() + '"]').focus();
        }
            else if(event.which ==  9){
                $('[data-index="7"]').focus();
            }
        } 
    $(document).ready(function() {
        
    });
</script>
@endpush