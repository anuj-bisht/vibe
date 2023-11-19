@extends('layouts.app')
@include('styles.style')
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
<div class="container-fluid" id="basic-inputt">
   <section id="">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title" style="color:black; ">Order</h4>
                  <span>
                     <a href="{{route('order.index')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>

                  </span>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section id="multiple-column-form">
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-body">
                  <div class="h6" style="color:black;  display:flex; justify-content:space-between;">
                     <span>Order Number <span id="season_order_no"></span></span>
                     <input type="hidden" name="season_order_no" id="s_order_no">
                     <span><span><input type="radio" id="checkorder" name="checkorder" value="initial_order">Initial
                           Order</span>&nbsp;&nbsp;&nbsp;<span><input id="checkorder" type="radio" name="checkorder"
                              value="repeat_order">Repeat Order</span></span>
                  </div>
                  <div class="row">
                     <div class="col-md-4 col-12">
                        <div class="form-group">
                           <label for="city-column" style="color:black; ">State</label>
                           <select class="form-control" id="state" name="state" data-index="1"
                            @@change="getClient()" v-select2>
                              <option disabled selected>Select State</option>
                              @foreach($states as $state)
                              <option data-client="{{$state->corporate_profiles}}" value="{{$state->id}}">
                                 {{$state->name}}</option>
                              @endforeach
                           </select>
                           @error('state')
                           <h5 class="alert alert-danger">{{$message}}</h5>
                           @enderror
                        </div>
                     </div>
                     <div class="col-md-4 col-12">
                        <div class="form-group">
                           <label for="city-column" style="color:black; ">Client</label>
                           <a style="float: right;" href="{{route('corporate.create')}}" target="_blank" style="color:blue; ">Create</a>
                           <select  ref="clientFocus" class="form-control"  id="client" name="client" data-index="2" @@change="focusToSeason" v-select2>
                              <option disabled selected>Select Client</option>
                           </select>
                           @error('client')
                           <h5 class="alert alert-danger">{{$message}}</h5>
                           @enderror
                        </div>
                     </div>
                     <div class="col-md-4 col-12">
                        <div class="form-group">
                           <label for="city-column" style="color:black; ">Season Code</label>
                           <a style="float: right;" href="{{route('master.season.create')}}" target="_blank" style="color:blue; ">Create</a>
                           <select class="form-control" ref="seasonFocus" id="season_code" name="season_code" v-model="season_id"
                              data-index="3" @@change="getProductCode"  v-select2>
                              <option disabled selected>Select Code</option>
                              <option v-for="season_code in season_codes" :value="season_code">@{{season_code.code}}
                              </option>

                           </select>

                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <div class="row">
      <div class="form-group">
         <input type="hidden" id="product_mrp" />
      </div>
   </div>

   <section>
      <div class="row">
         <div class="col-12">
            <div class="table-responsive">
               <section id="input-mask-wrapper">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card">
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                    <table class="title-form horizontaltable">
                                       <tbody style="font-size:12px;">
                                          <tr>
                                             <td style="text-align:center">P Code</td>
                                             <td style="text-align:center">C Code</td>
                                             @foreach($sizes as $size)
                                             <td style="padding:0.75rem !important;">
                                                <?php
                                                $str=explode('/',$size->size);
                                                $a=$str[0]??'';
                                                $b=$str[1]??'';
                                                echo "$a<br>$b";
                                                 ?>
                                             </td>
                                             @endforeach
                                             <td style="text-align:center"> Total</td>
                                          </tr>
                                          <tr>
                                             <td style="width:10rem;">
                                                <v-select label="product_code" :options="products"
                                                   v-model="product_object" @@input="getColor" ref="productSelect"  @@close="focusVSelect"
                                                   @@search="searchProducts"></v-select>
                                             </td>
                                             <td style="width:10rem;">
                                                <select class="form-control " id="color_code" name="color_code"
                                                   v-model="color_id" ref="colorSelect">
                                                   <option v-for="color in colors" :value="color">
                                                      @{{color.color.color_code}}</option>
                                                </select>
                                                @error('color_code')
                                                <h5 class="alert alert-danger">{{$message}}</h5>
                                                @enderror
                                             </td>
                                             <td v-for="size in sizes">
                                                <input type="number" name="cutting_plans" v-model="size.value"
                                                   class="form-control input orderqty" style="padding:0px !important; "
                                                   @@change='updateTotal'>
                                             </td>
                                             <td>
                                                <input type="text" class="form-control " v-model="totalq"
                                                    />
                                             </td>
                                             <td>
                                                <button class="btn global_btn_color " @@click="toBottom()"
                                                   >
                                                   <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                      viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                      stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                      class="feather feather-arrow-down">
                                                      <line x1="12" y1="5" x2="12" y2="19"></line>
                                                      <polyline points="19 12 12 19 5 12"></polyline>
                                                   </svg>
                                                </button>
                                             </td>
                                          </tr>
                                          <tr>
                                             @error('sum')
                                             {{ $message }}
                                             @enderror
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </section>
               <section id="input-mask-wrapper">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card">
                           <div class="card-body">
                              <div class="row" id="table-head">
                                 <div class="col-12">
                                    <div class="card">
                                    
                                          <table class="table table-bordered"  width="100%"
                                             cellspacing="0" style="font-size:smaller;">
                                             <thead class="">
                                                <tr style="background-color: #32AD89; color:white;">

                                                   <td >P Code</td>
                                                   <td >C Code</td>
                                                   @foreach($sizes as $size)
                                                   <td>
                                                      <?php
                                                      $str=explode('/',$size->size);
                                                      
                                                      $a=$str[0]??'';
                                                      $b=$str[1]??'';
                                                      echo "$a<br>$b";
                                                       ?>
                                                   </td>
                                                   @endforeach

                                                   <td >Total Qty</td>
                                                   <td >MRP</td>
                                                   <td >Amount</td>
                                                   <td >Action</td>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <tr id="" v-for="(c, k) in child" :key="k">
                                                   <td class="tp"  style="text-align:center;"> @{{
                                                      c.product_name }} </td>
                                                   <td class="tp"  style="text-align:center;"> @{{ c.color_name
                                                      }} </td>
                                                   <td class="tp"  style="text-align:center;" v-for="s in sizes"
                                                      > @{{ c.cs[s.id] }} </td>
                                                   <td class="tp"  style="text-align:center;">@{{ c.totalq }}
                                                   </td>
                                                   <td class="tp"  style="text-align:center;">@{{ c.mrp }}</td>
                                                   <td class="tp"  style="text-align:center;">@{{ c.amount }}
                                                   </td>
                                                   <td style="paddng:0px !important">
                                                      <a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                                         @@click="deleteData(k)">
                                                         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" class="feather feather-trash-2">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path
                                                               d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                            </path>
                                                            <line x1="10" y1="11" x2="10" y2="17">
                                                            </line>
                                                            <line x1="14" y1="11" x2="14" y2="17">
                                                            </line>
                                                         </svg>
                                                      </a>
                                                   </td>
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
               </section>
            </div>
         </div>
      </div>
      <button class="btn global_btn_color" @@click="sumbitData()" >Save</button>
      <form id="mainformm" method="post" action="{{ route('moveToOrder') }}">
         @csrf
         <input type="hidden" id="formdataa" name="data">
      </form>
   </section>
</div>
</div>
@endsection
@push('scripts')

<script>
   

   //  function getClient() {
   //     var client = JSON.parse($('#state').find(':selected').attr('data-client'));

   //     var html = "";
   //     html = "<option>Select Client</option>";
   //     $.each(client, function(index, el) {
   //         html += "<option  value='" + el.id + "'>" + el.name + "</option>";
   //     });
   //     $('#client').html(html);

   // }

</script>


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
Vue.component('v-select', VueSelect.VueSelect);

    var app = new Vue({
        el: '#basic-inputt',
        data: {
            sizes: @json($sizes),
            season_codes:@json($season_code),
            state:"",
            client:"",
            checkorder:"",
            ratio: "",
            totalq: 0,
            mrp:0,
            amount:0,
            products: [],
            product_object:"",
            colors:[],
            product_id: "",
            product_name: "",
            color_id:"",
            color_name: "",
            season_id:"",
            season_name:"",
            child: [],
            formData: "",
            order_no:"",
        },
        mounted() {
         $('#state').select2();
         $('#season_code').select2();
         $('#client').select2();
         $('#state').select2('open');

        },
        methods: {

         focusVSelect:function(){
                vm=this;
                vm.$refs.colorSelect.focus();
            },
          
         focusToSeason(){
            vm=this;
            vm.$refs.seasonFocus.focus();

         },
         getClient(){
            vm=this;
            var client = JSON.parse($('#state').find(':selected').attr('data-client'));
            var html = "";
            html = "<option>Select Client</option>";
            $.each(client, function(index, el) {
               html += "<option  value='" + el.id + "'>" + el.name + "</option>";
            });
            $('#client').html(html);
            vm.$refs.clientFocus.focus();

         },
         
         getProductCode() {
            vm=this;
            vm.$refs.productSelect.searchEl.focus();
            vm.products=[];
         var order_season_code=vm.season_id.code;
         $('#s_order_no').val(order_season_code +"-"+{{$order_serial_no}});
         $('#season_order_no').text(order_season_code +"-"+{{$order_serial_no}});
         $.ajax({
                  url:"{{ url('/checkSeasonOrder/') }}/"+order_season_code,
                type:"GET",
                success:function(response)
                {

                    if(response.status == 200)
                    {
                      $('#season_order_no').text(order_season_code +"-"+response.data);
                      $('#s_order_no').val(order_season_code +"-"+response.data);
                    }
                    if(response.status == 201)
                    {
                      $('#season_order_no').text(order_season_code +"-"+response.data);
                      $('#s_order_no').val(order_season_code +"-"+response.data);
                    }
                   
                }
            });
   },
          searchProducts(search, loading){
            if (search.length < 1) {
                return ;
            }
                    vm=this;
                    axios.get(`{{ url('/getSearchProductBySeason') }}/${search}/${vm.season_id.id}`).then(res => {
                    vm.products = res.data.data;
                });
                },
                getColor(){
                  vm=this;
                  axios.get(`{{ url('/getSearchColorBySeasonProduct') }}/${vm.product_object.id}/${vm.season_id.id}`).then(res => {
                       vm.colors=res.data.data
                  });
                },
            sumbitData() {
        

                var vm = this;
                if($('#state').val() == null){
                  return toastr['success']('Select State', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
               }else if(vm.season_id == ''){
                  return toastr['success']('Select Season Code', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
               }
               else if(vm.child.length == 0){
                  return toastr['success']('Select Product', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
               }
               else if($('#client').val() == 'Select Client'){
                  return toastr['success']('Select Client', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
               }else if($('input[name=checkorder]:checked').val() == undefined){
                  return toastr['success']('Select Order Type', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
               }
                var formData = {};
                alert('d');
                formData.checkorder = $('input[name=checkorder]:checked').val();
                formData.state = $('#state').val();
                formData.client = $('#client').val();
                formData.order_no = $('#s_order_no').val();
                formData.child = vm.child;
                vm.formData = JSON.stringify(formData);
                document.getElementById("formdataa").value = vm.formData;
                document.getElementById("mainformm").submit();

            },
            updateTotal() {
               vm=this;
               var total = 0;
               var list = document.getElementsByClassName("orderqty");
               var values = [];
               for(var i = 0; i < list.length; ++i) {
                  values.push(list[i].value);
               }
               vm.sub(values);
                },
                sub(arr){
                  vm=this;
                  var values= $.grep(arr, n => n ==  ' ' || n)
                  var total = 0;
                  for (var i in values) {
                  total += parseInt(values[i]);
                  }
                  vm.totalq=total;
                },

            toBottom() {
                var vm = this;
                if(vm.totalq > 0){
                var cs = {};
                var css = {};
                        for (k in vm.sizes) {
                            cs[vm.sizes[k].id] = vm.sizes[k].value ? vm.sizes[k].value : 0;
                        }

                        if(vm.child.length > 0){
                            var product=  vm.child.filter(function(el) {                                
                            return el.color_id== vm.color_id.color_id && el.product_id== vm.product_object.id;
                            });
                      
                            if(product.length > 0){
                            vm.error=[];
                            for (k in vm.sizes) {
                            css[vm.sizes[k].id] = vm.sizes[k].value ? parseInt(vm.sizes[k].value) : 0
                            }
                            let totalqty={};
                            for(let csskeys in css){
                                totalqty[csskeys]= parseInt(css[csskeys]) + parseInt(product[0].cs[csskeys]);
                            }

                                    let spl_key = []
                                    for(const [key,val] of Object.entries(vm.child)){
                                            if(val.product_name == product[0].product_name){
                                            spl_key.push(key)
                                            }
                                    }
                                    var totalQTY=parseInt(vm.totalq) + parseInt(product[0].totalq);
                                    vm.child[spl_key].cs = totalqty;  
                                    vm.child[spl_key].totalq=totalQTY;
                                    vm.child[spl_key].amount=totalQTY*vm.child[spl_key].mrp;

                                    vm.totalq = 0;
                                    for (k in vm.sizes) {
                                        vm.sizes[k].value = 0;
                                    }
                                    vm.$refs.productSelect.searchEl.focus();

                            }else{
                                this.updateTotal();
                                    vm.child.push({
                                    "mrp":  parseInt(vm.color_id.mrp),
                                    "totalq": vm.totalq,
                                    "amount":parseInt(vm.color_id.mrp) *  vm.totalq,
                                    'product_id':vm.product_object.id,
                                    'product_name':vm.product_object.product_code,
                                    'color_id':vm.color_id.color.id,
                                    'color_name':vm.color_id.color.color_code,
                                    'season_name':vm.season_id.code,
                                    'season_id':vm.season_id.id,
                                    cs,
                                    });
                                    vm.totalq = 0;
                                    for (k in vm.sizes) {
                                        vm.sizes[k].value = 0;
                                    } 
                                    vm.$refs.productSelect.searchEl.focus();

                            }
                            }else{
                    vm.child.push({
                        "mrp":  parseInt(vm.color_id.mrp),
                        "totalq":  vm.totalq,
                        "amount":parseInt(vm.color_id.mrp) *  vm.totalq,
                        'product_id':vm.product_object.id,
                        'product_name':vm.product_object.product_code,
                        'color_id':vm.color_id.color.id,
                        'color_name':vm.color_id.color.color_code,
                        'season_name':vm.season_id.code,
                        'season_id':vm.season_id.id,
                        cs
                    });

                    vm.totalq = 0;
                    for (k in vm.sizes) {
                            vm.sizes[k].value = 0;
                        }
                        vm.$refs.productSelect.searchEl.focus();

                     }  
                  }      
            },
            deleteData(k) {
                this.child.splice(k, 1)
            }
        },
        watch: {}
    })
// $('#state').on('select2:close', function (e) {
//                 console.log('test');
//                 if (event.which == 13) {
//                     var $this = $(e.target);
//                     var index = parseFloat($this.attr('data-index'));
//                     $('[data-index="' + (index + 1).toString() + '"]').focus();
//                 }
//             });
</script>
@endpush