@extends('layouts.app') 
@include('styles.style')
 @section('content') 
 <link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
 @include('styles.style')
 <style>
     .table-bordered{
        border-color:black !important;
    }
    .tp{
        padding:0px !important;
    }
      .vs--searchable .vs__dropdown-toggle{
        height:38px;
      }
 </style>
  <div class="container" id="picklist">
        <section id="">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title" style="color:black; ">Pickist</h4>
            
              </div>
            </div>
          </div>
        </div>
      </section>
      <section  >
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4 col-12">
                    <div class="form-group">
                      <label for="city-column" style="color:black; ">State  </label>
                   
                         <select class="form-control" id="state" name="state" data-index="1" v-model="stateSelected" @@change="findClient"   v-select2>
                         <option disabled selected>Select State</option>
                         <option v-for="state in states"  :value="state.id">@{{state.name}}</option> 
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 col-12">
                    <div class="form-group">
                      <label for="city-column" style="color:black; ">Client</label>
                      <a style="float: right;" href="{{route('corporate.create')}}" target="_blank" style="color:blue; ">Create</a>
                      <input v-if="m !== null" type="text" class="form-control" v-model="clientSel" readonly>
                      <select v-if="m == null"  id="selected_client" class="form-control" v-model="clientSelected" @@change="findOrder"   name="corporate" data-index="2" v-select2>
                         <option disabled value="">Select Client</option>
                          <option v-for="client in clients" :value="client.id" selected>@{{ client.name}}</option>
                      </select>
                      
                    </div>
                  </div>
                  <div class="col-md-4 col-12">
                    <div class="form-group">
                      <label for="city-column" style="color:black; ">Order No</label>
                      <input v-if="m !== null" type="text" class="form-control" v-model="orderSel" readonly>
                      <select v-if="m == null" id="selected_order" class="form-control" name="order" v-model="orderSelected"  @@change="getOrderData" v-select2  >
                         <option disabled value="">Select Order</option>
                         <option v-for="order in orders" :value="order" > @{{order.ord_id}} </option>
                      </select>
                      
                    </div>
                  </div>
                  
                  

                  <div class="col-md-4 col-4">
                    <select id="warehouse" class="form-control" name="order" v-model="warehouse"  v-select2  >
                      <option disabled value="">Select Warehouse</option>
                      <option v-for="warehouse in warehouses" :value="warehouse"> @{{warehouse.name}} </option>
                   </select>
                  </div>
                  <div class="col-md-1 col-1"> <button class="btn global_btn_color" @@click="generatePicklist" >Get</button></div>

                  <div class="col-md-7 col-7 " style="text-align:last;"> <button class="btn global_btn_color" data-toggle="modal" data-target="#xlargeshowDetail">Order Detail</button></div>


                </div>
              </div>
            </div>
          </div>
        </div>
      </section>



        <div class="modal fade text-left" id="xlargeshowDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">View Order Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <table class="table" id="ordertable" width="100%" cellspacing="0">
                    <thead class="" >
                        <tr>
                            <th style='text-align:center;'>P Code</th>
                            <th style='text-align:center;'>C Code</th>
                            @foreach($sizes as $size)
                                        <th  style="text-align:center; text-align:center;">
                                           <?php
                                           $str=explode('/',$size->size);
                                           
                                           $a=$str[0]??'';
                                           $b=$str[1]??'';
                                           echo "$a<br>$b";
                                            ?>
                                        </th>
                                        @endforeach
                            <th style='text-align:center;'>Total</th>
                        </tr>
                    </thead>
                    
                     <tbody id="orderdata">

                      <tr id="" v-for="c in orderData" >
                         <td style='text-align:center;' class="tp" > @{{ c.product.product_code}} </td>
                        <td style='text-align:center;' class="tp"> @{{ c.color.color_code}}</td>
                        <td style='text-align:center;' v-for="ochild in c.child">@{{ochild.qty}}</td>
                        <td style='text-align:center;'>@{{c.total}}</td>
                      </tr>


                    </tbody>
                </table>
                 
                </div>
               
            </div>
        </div>
    </div>  



    


      <a href="javascript:void(0)" class="btn btn-sm" id="picklistButton" data-array="" style="background-color: #009973; color:white; display:none" onclick="getWarehouseProduct()">
        Generate Picklist
       </a>


        <section  class="pt-2" id="picklistsection">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
           


              <div class="table-responsive">
                <table class="table" id="picklisttable" width="100%" cellspacing="0">
                  <thead class="d-none" >
                    <tr>
                        <th style='text-align:center;'>Agent</th>
                        <th style='text-align:center;' v-if="clientSelected.corporate_profiles">@{{clientSelected.corporate_profiles.name}}</th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                      <th style='text-align:center;'>State</th>
                      <th style='text-align:center;'v-if="clientSelected.corporate_profiles">@{{clientSelected.corporate_profiles.billing_address}}</th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                      <th></th>
                  </tr>
                  <tr>
                    <th style='text-align:center;'>Order No.</th>
                    <th style='text-align:center;' id="pdforderno"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                  <thead class="" >
                        <tr>
                            <th style='text-align:center;'>P Code</th>
                            <th style='text-align:center;'>C Code</th>
                            @foreach($sizes as $size)
                            <th  style="text-align:center; text-align:center;">
                               <?php
                               $str=explode('/',$size->size);
                               
                               $a=$str[0]??'';
                               $b=$str[1]??'';
                               echo "$a<br>$b";
                                ?>
                            </th>
                            @endforeach
                            <th style='text-align:center;'>Total</th>
                        </tr>
                    </thead>
                    <tbody id="picklistdata">

                      <tr id="customerIDCell" v-for="(c,i) in warehouseData"  >
                        <td style='text-align:center;' class="tp" > @{{ c.product.product_code}} </td>
                       <td style='text-align:center;' class="tp"> @{{ c.color.color_code}}</td>
                       {{-- <td  style='text-align:center;' v-for="(s,j) in c.size" ><span style="display:none;">@{{warehouseData[i].size[j] }}</span><input  style="width:35px; border:none;" type="number" name="" id="" v-model="warehouseData[i].size[j]" ></td> --}}
                      <td  style='text-align:center;' v-for="(s,j) in c.size" ><span style="display:none;">@{{warehouseData[i].size[j] }}</span><input readonly  style="width:35px; border:none;" type="number" name="" id="" v-model="warehouseData[i].size[j]" ></td>

                       <td style='text-align:center;'>@{{total(warehouseData[i].size[1])}}</td>
                     </tr>


                     {{-- <tr id="customerIDCell" v-for="(c,i) in orderData"  >
                      <td style='text-align:center;' class="tp" > @{{ c.product.product_code}} </td>
                     <td style='text-align:center;' class="tp"> @{{ c.color.color_code}}</td>
                      <td  style='text-align:center;' v-for="(s,j) in sizes" >@{{ warehouseData[i].size[s]}} <input  style="width:35px; border:none;" type="number" name="" id="" v-model="warehouseData[i].size[s]" >  </td>
                     <td  style='text-align:center;' v-for="(s,j) in sizes" > <span style="display:none;">@{{ orderData[i].pickupList[s.id]}}</span> <input  style="width:35px; border:none;" type="number" name="" id="" v-model="orderData[i].pickupList[s.id]">  </td>
                     <td style='text-align:center;'>@{{total(orderData[i].pickupList)}}</td>
                   </tr> --}}

                    </tbody>
                </table>
            </div>
            </div>
          </div>
        </div>


        <form id="pickuplistform" method="post" action="{{ route('moveToPicklist') }}">
          @csrf
          <input type="hidden" id="formdata" name="data">

      </form>
      </section> 
      <div style="display:flex; justify-content:space-between;">
        <button class="btn global_btn_color"  @@click="sumbitData()" data-index="7">Save</button>
        {{-- <button class="btn global_btn_color" onclick="generatePDF()">Generate Pdf</button> --}}


      </div>

  </div>


   @endsection



@push('scripts')
  <script>

  Vue.directive('select2',{
      inserted(el){
          $(el).on('select2:select', ()=>{
              const event = new Event('change', {bubbles:true, cancelable:true});
              el.dispatchEvent(event);
          });

          $(el).on('select2:unselect', ()=>{
              const event = new Event('change', {bubbles:true, cancelable:true});
              el.dispatchEvent(event);
          });
      }
  });
  var app = new Vue({
              el: '#picklist',
              data: {
                m:@json($picklist_data),
                sizes:@json($sizes),
                states:@json($states),
                warehouses:@json($warehouses),
                warehouse:@json($default_warehouse),
                stateSelected: "{{$picklist_data == null ? "": $picklist_data->states->id}}",
                clients:[],
                clientSelected:"",
                orderSelected:{!! $picklist_data == null ? "{}": $picklist_data!!},
                orders:{!! $picklist_data == null ? "{}": $picklist_data!!},
                orderData: {!! $picklist_data == null ? "{}": $picklist_data->detail!!},
                warehouseData:"",
                formData: "",
                dataTransfer:"",
                pickuplistsizes:[],
                changerow:"",
                totalOrderQty:0,
                totalPicklistQty:0,
                remainingQty:0,
                autoGeneratePicklistNo:{{ $picklistNumber }},
                orderSel:"{{$picklist_data == null ? "": $picklist_data->ord_id}}",
                clientSel:"{{$picklist_data == null ? "": $picklist_data->corporate_profiles->name}}"

              },
              created() {
              //  this.clients[0]= {!! $picklist_data == null ? "{}": $picklist_data->corporate_profiles!!};
              //  this.clientSelected = {!! $picklist_data == null ? "{}": $picklist_data->corporate_profiles!!};

               
              },
            
              methods: {
                findClient:function(){
                  vm=this;
                  axios.get(`{{ route('getClient') }}?id=${vm.stateSelected}`).then(res=> {
                       vm.clients = res.data.data;
                       
                })
                },
                findOrder:function(){
                  vm=this;
                  axios.get(`{{ route('getOrder') }}?id=${vm.clientSelected}&state_id=${vm.stateSelected}`).then(res=> {
                       vm.orders = res.data.data;   
                })
                },
               
                total:function(item){
                  console.log(item);
                  var sum=0;
                  for(i in item){
                    var b=parseInt(item[i]);
                    if(!isNaN(b))
                    sum+= parseInt(item[i]);
                  }
                  return sum;
                },

                getOrderData:function(){
                    
                     axios.get(`{{ route('getClientOrderData') }}?state_id=${vm.stateSelected}&client_id=${vm.clientSelected}&order_id=${vm.orderSelected.ord_id}`).then(res=> {
                     vm.orderData=res.data.data[0].detail;
                    });
                },

                generatePicklist:function(){
                    vm=this;
                    if(vm.warehouse == ''){
                    return  toastr['success'](`Select Warehouse`, '', {
                                          closeButton: true,
                                          tapToDismiss: false,
                                          progressBar: true,
                                        });
                                      }
                    axios.get(`{{ route('getPicklistData') }}?warehouse_id=${vm.warehouse.id}&order_id=${vm.orderSelected.ord_id}`).then(res=> {
                      console.log(res.data.data);
                                vm.warehouseData=res.data.data;
                    });
                },
              getData:function(){
                var vm= this;
                axios.get(`{{ url('/getClientOrder') }}/${vm.orderSelected.id}`).then(res=> {
                        res.data.data.reduce((acc, ele) => {
                          return vm.totalOrderQty= acc + ele.total;
                        }, 0);
                        res.data.data.forEach(element => {
                          const values = Object.values(element.pickupList);                   
                        });
                          vm.orderData=res.data.data;
                          $.each(res.data.data,function(index,el){
                            vm.pickuplistsizes.push(el.pickupList);
                        });

                          return vm.totalOrderQty;
                          vm.remainingQty=parseInt(vm.totalOrderQty) - parseInt(vm.totalPicklistQty);
                })
             },
             sumbitData() {
                    var vm = this;
                    if(vm.warehouseData.length ==0){
                      return toastr['success']('Fill all fields', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                    }
                    var formData = {};
                    formData.autoGeneratePicklistNo=vm.autoGeneratePicklistNo;
                    formData.client_id=vm.orderSelected.client_id;
                    formData.state_id=vm.orderSelected.state_id;
                    formData.order_id=parseInt(vm.orderSelected.id);
                    formData.warehouse_id= vm.warehouse.id;
                    formData.totalData = vm.warehouseData;
                    vm.formData = JSON.stringify(formData);
                    document.getElementById("formdata").value = vm.formData;
                    document.getElementById("pickuplistform").submit();
                },
              },
              computed: {

              },
              watch: {
              
                dataTransfer:function(){
                  this.sumbitData();
                }

              }
          })

  </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.min.js"></script>
  <script src="https://unpkg.com/jspdf-autotable@3.5.22/dist/jspdf.plugin.autotable.js"></script>

<script>

  function generatePDF(){

var doc = new jsPDF();
doc.autoTable({ html: '#picklisttable' })
  doc.save('picklist.pdf')



  }
  $(document).ready(function() {
            $('#state').select2();
            $('#selected_order').select2();
            $('#selected_client').select2();
            $('#warehouse').select2();
        });
</script>

@endpush
