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
<div class="container" id="basic-input">
  <section>
    <div class="row" style="margin-bottom:1rem;">
      <div class="col-md-12">
        <div class="card mb-0">
          <div class="card-header" style="padding:0.5rem;">
            <h4 class="card-title">Stock</h4>
            <span class="d-flex align-items-center">
              <select class="form-control " data-index="1" id="warehouse" name="warehouse" required
                v-model="warehouse_id" @@change="jumpToProduct" v-select2>
                <option disabled selected value="">Select Warehouse</option>
                <option v-for="warehouse in Warehouses" :value="warehouse.id">@{{ warehouse.name }}</option>
              </select>
              <img style="width:30px; height:30px; object-fit:contain; margin-left:10px; cursor: pointer;"
                @@click="showhideScanner" src={{asset('device.jpeg')}} alt="Image" />
              <a href="{{route('warehouse.index')}}" class="btn btn-sm"
                style="background-color: #009973; color:white; margin-left:10px;"><svg
                  xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-home">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                  <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg></a>
            </span>
          </div>
        </div>
      </div>
    </div>
    <div style="display:flex; justify-content:end; margin:0.5rem; display:none;"><button
        :class="[isActive ? 'btn btn-sm btn-danger' : 'btn btn-sm btn-success']"
        @@click="showhideScanner">@{{buttonText}}</button></div>


    <div class="row">
      <div class="col-12">
        <div class="">
          <div id="error_message" style="text-align: center; color:red;"></div>
          <section id="input-mask-wrapper" v-if='isActive'>
            <div class="row">
              <div class="col-md-12">
                <div class="card" style="margin-bottom:1rem;">
                  <div class="card-body" style="padding:1rem;">
                    <div class="row">
                      <div id="searchErrorMessage"></div>
                      <div class="col-xl-12 col-md-12 col-sm-12 ">
                        <label for="basicSelect">Search By EAN</label>
                        <input ref="scanner" class="form-control input" @@keydown.enter="self" type="number"
                          placeholder="Search Ean" data-search="search" v-model="typeEan" id="ean_no"
                          @@input="searchEAN(this)">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <section id="input-mask-wrapper" v-else>
            <div class="row">
              <div class="col-md-12">
                <div class="card" style="margin-bottom:1rem;">
                  <div class="card-body" style="padding:0.5rem;">
                    <div class="row">
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
                                <v-select ref="productSelect" @@close="focusVSelect" label="product_code"
                                  :options="products" v-model="product_object" @@input="getColor"
                                  @@search="searchProduct"></v-select>
                              </td>
                              <td style="width:8rem;">
                                <input type="hidden" id="pro_code">
                                <select v-model="color_id" data-index="3" ref="colorSelect" class="form-control"
                                  id="color_id" name="color_id" required @@change="getColorObject($event)" v-select2>
                                  <option selected disabled></option>
                                  <option v-for="color in colors" :value="color.color.id"> @{{ color.color.color_code }}

                                  </option>
                                </select>
                              </td>
                              <td v-for="(size,k) in sizes" :key="k">
                                <input type="number" name="cutting_plans" v-model="size.value"
                                  class="form-control input cutting_plans"
                                  style="padding:0px !important; text-align:center;" @@change='changeTotal(k)'
                                  @@keydown.enter="goToNextField(k)">
                              </td>
                              <td style="width:5rem;"><input readonly v-model="totalq" type="number" name="sum"
                                  id="total" class="form-control cuttingplantotal"> @{{
                                updateTotal() }}
                              </td>
                              <td>
                                <button class="btn global_btn_color " @@click="toBottom()" ref="totalfocus"
                                  data-index="6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
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
        </div>
      </div>
    </div>


    <section id="input-mask-wrapper">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row" id="table-head">
                <div class="col-12">
                  <div class="card">
                    <div>
                      <table class="table table-bordered" id="" width="100%" cellspacing="0" style="">
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
                            <td style="text-align:center;">Action</td>
                          </tr>
                        </thead>
                        <tbody>
                          <tr id="" v-for="(c, k) in child" :key="k">
                            <td style="text-align:center;" class="tp"> @{{ c.product_name }} </td>
                            <td style="text-align:center;" class="tp"> @{{ c.color_name }} </td>
                            <td style="text-align:center; " class="tp" v-for="s in sizes"> @{{ c.cs[s.id] }} </td>
                            <td style="text-align:center;" class="tp">@{{ c.totalq }}</td>
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
    <button class="btn global_btn_color" @@click="sumbitData()" data-index="7">Save</button>
    <form id="mainform" method="post" action="{{ route('export.product.store') }}">
      @csrf
      <input type="hidden" id="formdata" name="data">
    </form>
  </section>
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
  Vue.component('v-select', VueSelect.VueSelect);

        var app = new Vue({
            el: '#basic-input',
             data: {
                sizes:@json($sizes),
                Warehouses:@json($warehouses),
                warehouse_id: {!! $default_warehouse->id !!},
                product_object :"",
                products:[],
                colors:[],
                color_id:"",
                color_name:"",
                error:[],
                child:[],
                totalq:0,
                dummychild:[],
                typeEan: '',
                plucksize:@json($plucksize),
                buttonText:"Disabled Scanner",
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

             showhideScanner(){
              vm =this;
              if(vm.isActive == true){
              vm.isActive = false;
              vm.buttonText = "Enabled Scanner";
              }
              else{
              vm.isActive = true;
              vm.buttonText = "Disabled Scanner";
              }
              },

             jumpToProduct:function(){
              if($("#warehouse").select2().select2("close")){
              this.$refs.productSelect.searchEl.focus();
              }
              },

              self(event){
              event.preventDefault();
              this.$refs.scanner.focus();
              },

             focusVSelect:function(){
              vm=this;
              vm.$refs.colorSelect.focus();
              },

             searchEAN:function(e){
              vm=this;
              if(vm.typeEan.length == 13){
              $('#searchErrorMessage').text("");
              const data = JSON.stringify({ product_ean : vm.typeEan});
              const config = {
              headers: {'Content-Type': 'application/json'}
              }
              
              axios.post("{{ url('/getDataBySearch') }}", data,config).then(res => {
              if(res.data.data.qty.qty == 0 ){
              return toastr['success'](`${res.data.data.qty.size.size} has 0 quantity`, '', {
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
              
              var product = vm.child.filter(function(el) {
              return el.color_id == vm.color_id && el.product_id == vm.product_object.id;
              });
              
              if(product.length > 0){
              let spl_key = []
              for(const [key,val] of Object.entries(vm.child)){
              if(val.product_name == product[0].product_name){
              spl_key.push(key)
              }
              }
              if(parseInt(product[0].cs[res.data.data.qty.size_id]) < res.data.data.qty.qty){
                vm.child[spl_key].cs[res.data.data.qty.size_id] = parseInt(product[0].cs[res.data.data.qty.size_id]) + 1;
                vm.child[spl_key].totalq=product[0].totalq + 1; vm.color_id="" ; vm.product_object="" ; 
              }
               else
                 { 
                return
                toastr['success'](`No Quantity left`, '' , { closeButton: true, tapToDismiss: false, progressBar: true, }); } 
                }else{
                vm.child.push({
                  "totalq" : 1, 
                  'product_id' :res.data.data.product.product_master_id, 
                  'product_name':res.data.data.product.parent.product_code, 
                  'color_id' :res.data.data.product.color_id, 
                  'color_name':res.data.data.product.color.color_code, cs });
                   vm.product_object="" ; 
                   vm.color_id="" ; 
                 } 
                }
                else
                {
               vm.child.push({ 
                "totalq" : 1,
                'product_id' :res.data.data.product.product_master_id, 
                'product_name' :res.data.data.product.parent.product_code, 
                'color_id' :res.data.data.product.color_id, 
                'color_name':res.data.data.product.color.color_code, cs });
                 vm.color_id="" ; 
                 vm.product_object="" ;


                } }).catch(error=> {
                toastr['success']('Product not found', '', {
                closeButton: true,
                tapToDismiss: false,
                progressBar: true,
                });
                });
                vm.typeEan="";
              
                }
                else{
                $('#searchErrorMessage').text("EAN Should be 13 Digit");
              
                }
                },

                searchProduct(search, loading){
                vm=this;
                  vm.color_id='';
                  vm.color_name="";
                  if (search.length < 1) { return ; } vm.colors=[]; axios.get(`{{
                    url('/getUnfinishedProductSearch')}}/${search}`).then(res=> {
                    vm.products= res.data.data;
                    })
                },

                getColor:function(event){
                vm = this;
                const data = JSON.stringify({
                p_id: vm.product_object.id
                });
                const config = {
                headers: {
                'Content-Type': 'application/json'
                }
                }
                axios.post("{{ url('/getUnfinishedProductColor') }}", data, config).then(res => {
                vm.colors = res.data.data;
                })
                },

                getColorObject:function(event){
                  vm.color_name = event.target.options[event.target.options.selectedIndex].text;
                  const nextField = document.getElementsByName("cutting_plans")[0];
                  nextField.focus();

                },

                sumbitData() {
                var vm = this;
                if(vm.warehouse_id == ''){
                    return toastr['success']('Select Warehouse', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                }
                if(vm.child.length == 0){
                 return toastr['success']('Please fill all the field', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                }
                    var formData = {};
                    formData.warehouse_id = vm.warehouse_id;
                    formData.child = vm.child;
                    vm.formData = JSON.stringify(formData);
                    document.getElementById("formdata").value = vm.formData;
                    document.getElementById("mainform").submit();
                },

              changeTotal(sizes_key) {
               const config = {
               headers: {
              'Content-Type': 'application/json'
              }
              }
               vm =this;
               vm.sizes[sizes_key].isloading= true;
               vm.sizes[sizes_key].value= parseInt(vm.sizes[sizes_key].value.replace(/^0+/, ''));
               const wareData = JSON.stringify({
                           prod_id: vm.product_object.id,
                           col_id: vm.color_id,
                           qy: vm.sizes[sizes_key].value,
                           s_id: vm.sizes[sizes_key].id
                       });
               if (vm.child.length > 0) {
                   var product = vm.child.filter(function(el) {
                       return el.color_id == vm.color_id && el.product_id == vm.product_object.id;
                   });
                if (product.length > 0) {

                var totalqty= product[0].cs[vm.sizes[sizes_key].id];

                axios.post("{{ url('/checkUnfinishedWarehouseQty') }}", wareData, config).then(res => {

                if((totalqty + vm.sizes[sizes_key].value) > res.data.qty ){
                var cqty= res.data.qty-totalqty;
                vm.sizes[sizes_key].value= cqty;

                toastr['success'](`Only ${cqty} Quantities available`, '', {
                closeButton: true,
                tapToDismiss: false,
                progressBar: true,
                });

                vm.$forceUpdate();
                }

                vm.sizes[sizes_key].isloading= false;
                });
                return ;
                }
               }
               axios.post("{{ url('/checkUnfinishedWarehouseQty') }}", wareData, config).then(res => {
                       if (res.data.cqty < 0) {
                           toastr['success'](`Only  ${res.data.qty} Quantities available`, '', {
                               closeButton: true
                               , tapToDismiss: false
                               , progressBar: true
                           , });
                           vm.sizes[sizes_key].value = res.data.qty;
                           vm.$forceUpdate();
                       }
                       vm.sizes[sizes_key].isloading= false;
                   });                    
           },
            
  
                toBottom() {
                  vm=this;
                  if (vm.product_object.id != 0 && vm.color_id != ''  && vm.totalq > 0 ) {
                  var cs = {};
                  var css = {};
                        for (k in vm.sizes) {
                            cs[vm.sizes[k].id] = vm.sizes[k].value ? parseInt(vm.sizes[k].value) : 0
                        }
                           const obj = { product_id: vm.product_object.id, color_id:vm.color_id,}
                            const options = {
                            headers: {'X-Custom-Header': 'value'}
                          };
                            axios.post(`{{ url('/checkquantity')}}`,obj)
                          .then(response => {

                            if(vm.child.length > 0){
                              var product=  vm.child.filter(function(el) {
                                return el.color_id== vm.color_id && el.product_id== vm.product_object.id;
                              });
                              
                            if(product.length > 0){
                              if(vm.product_object.id != 0 && vm.color_id != ''  && vm.totalq > 0 ){

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
                                        console.log(qt);
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
                                      var spliceElement=vm.child.splice(spl_key,1);
                                      cs=totalqty;
                                      vm.child.push({
                                      "totalq": parseInt($('#total').val()) + parseInt(spliceElement[0].totalq),
                                      'product_id':vm.product_object.id,
                                      'product_name':vm.product_object.product_code,
                                      'color_id':vm.color_id,
                                      'color_name':vm.color_name,
                                      cs
                                      });
                                      vm.totalq = 0;
                                      for (k in vm.sizes) {
                                          vm.sizes[k].value = 0;
                                      }
                                      vm.color_id = "";
                                      vm.color_name = "";
                                      vm.product_id = "";
                                      vm.product_name = "";
                                     this.$refs.productSelect.searchEl.focus();
                                    }
                                  }
                            }else{
                              if(vm.product_object.id != 0 && vm.color_id != ''  && vm.totalq > 0 ){

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
                                    }else{
                                      vm.child.push({
                                      "totalq": vm.totalq,
                                      'product_id':vm.product_object.id,
                                      'product_name':vm.product_object.product_code,
                                      'color_id':vm.color_id,
                                      'color_name':vm.color_name,
                                      cs,
                                      });
                                      vm.totalq = 0;
                                    for (k in vm.sizes) {
                                        vm.sizes[k].value = 0;
                                    }
                                      vm.color_id = "";
                                      vm.color_name = "";
                                      vm.product_id = "";
                                      vm.product_name = "";
                                      this.$refs.productSelect.searchEl.focus();
                                        }
                                      }
                            }
                            }
                              else{
                                console.log('nhi hai');

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
                                    }else{
                                      vm.child.push({
                                      "totalq": vm.totalq,
                                      'product_id':vm.product_object.id,
                                      'product_name':vm.product_object.product_code,
                                      'color_id':vm.color_id,
                                      'color_name':vm.color_name,
                                      cs,
                                      });

                                      vm.totalq = 0;
                                      for (k in vm.sizes) {
                                          vm.sizes[k].value = 0;
                                      }
                                      vm.color_id = "";
                                      vm.color_name = "";
                                      vm.product_id = "";
                                      vm.product_name = "";
                                      this.$refs.productSelect.searchEl.focus();

                                        }
                                  }       
                          })
                          .catch(error => {
                            console.log(error);
                          }); 
                        }
                     
                },
                updateTotal() {
                vm = this;
                var total = 0;
                var list = vm.sizes;
                var values = [];
                for (var i = 0; i < list.length; ++i) {
                    if(list.value !== undefined || list.value !== '' || list.value !== 0){
                        values.push(list[i].value);
                    }
                }
                 vm.sub(values);
            }
            ,
             sub(arr) {
                vm = this;
                var values = $.grep(arr, n => n == ' ' || n)
                var total = 0;
                for (var i in values) {
                    total += parseInt(values[i]);
                }
                vm.totalq = total;
            },

            deleteData(k) {
              this.child.splice(k, 1)
              }

            },

            mounted(){
            $('#warehouse').select2();
            this.$refs.scanner.focus();
            },
        })
</script>
@endpush