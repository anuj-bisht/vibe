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

  textarea.select2-search__field {
    opacity: 0;
  }
</style>
<div class="container" id='stock_audit'>
  <section id="">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Stock Audit</h4>
            <span class="d-flex align-items-center">
              <abbr v-if="show == 1" style="margin-right:0.5rem;"  data-toggle="tooltip" :data-original-title=scannerStatus><img style="width:30px; height:30px; object-fit:contain; margin-left:10px; cursor: pointer;"  @@click="changeStatus()"  src={{asset('device.jpeg')}} alt="Image"/></abbr>
              <a href="{{route('stock.audit.index')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>



  <!-- Invoice -->
  <div class="col-xl-12 col-md-12 col-12">
    <div class="card invoice-preview-card mb-0">
      <!-- Address and Contact starts -->
      @if(Session::has('message'))
      <p class="alert alert-success alert-heading">{{ Session::get('message') }}</p>
      @endif
      <div class="card-body invoice-padding pb-0">
        <div class="row invoice-spacing">
          <div class="col-md-4 col-12">
            <div class="form-group">
              <label for="city-column" style="color:black; ">Select Warehouse</label>
              <select :disabled=showbtn class="form-control" id="warehouse_id" name="warehouse_id" data-index="1" v-model="warehouse_id"
                v-select2 @@change="getWarehouseData" >
                <option disabled selected value="">Select Warehouse</option>
                <option v-for="warehouse in warehouses" :value="warehouse.id">@{{ warehouse.name}}
                </option>
              </select>
            </div>
          </div>
          <div class="col-md-4 col-12">
            <div class="form-group">
              <label for="city-column" style="color:black;">Main Category</label>
              <select :disabled=showbtn class="form-control " id="main_category_id" name="main_category_id" v-model="main_category_id"
                data-index="1" @@change="getSubCategory" >
                <option disabled selected value="">Main Category</option>
                <option v-for="main_cat in maincatoption" :value="main_cat">@{{ main_cat.text}}</option>
              </select>
            </div>
          </div>
          <div class="col-md-4 col-12">
            <div class="form-group">
              <label for="city-column" style="color:black;">Sub Category</label>
              <v-select multiple label="name" :options="subCat" v-model="sub_category_id" @@input="getSubSubCategory" :disabled=showbtn>
              </v-select >
            </div>
          </div>
          {{-- <div class="col-md-4 col-12">
            <div class="form-group">
              <label for="city-column" style="color:black;">Sub Sub Category</label>
              <v-select multiple label="name" :options="subsubCat" v-model="sub_sub_category_id"
                @@input="getSubSubSubCategory" :disabled=showbtn></v-select>
            </div>
          </div> --}}
        </div>
      </div>
      <!-- Address and Contact ends -->
    </div>
  </div>
  <!-- /Invoice -->

  <div class="col-md-1 col-2">
    <div class="form-group">
      <label for="city-column" style="color:black; font-weight:bold;">&nbsp;</label>
      <button v-if="show == 0" class="btn btn-primary" data-index="7" @@click="startAuditing">Start</button>
      <button v-if="show == 1" @@click="resetData" class="btn btn-dark" data-index="7" >Reset</button>

    </div>
  </div>

  <form id="auditform" method="post" action="{{ route('moveToTempAuditDetail') }}">
    @csrf
    <input type="hidden" id="formdata" name="data">

  </form>
  <div>
   
    <div class="col-xl-12 col-md-12 col-12" v-if="show == 1" >
      <div class="card invoice-preview-card" style="margin-bottom:0.5rem;">
        <section>
          <div class="row" style="justify-content: center;">
            <div class="col-md-9">
              <div class="card" style="margin-bottom:0.5rem;">
                <div class="card-header">
                  <input v-if="isActive" class="form-control input" type="text" placeholder="Search Ean" data-search="search"
                    v-model="typeEan" id="ean_no" @@input="searchEAN(this)">
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Invoice Description starts -->
        <section id="input-mask-wrapper" v-if="!isActive">
          <div class="row">
            <div class="col-md-12">
              <div class="card mb-0">
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
                              <v-select label="product_code" :options="products" v-model="product_object"
                                @@input="getColor" @@search="searchProduct"></v-select>
                            </td>
                            <td style="width:8rem;">
                              <input type="hidden" id="pro_code">
                              <select data-index="3" class="form-control" id="color" v-model="color_object"
                                name="color_id" required  v-select2>
                                <option selected disabled></option>
                                <option v-for="color in colors" :value="color"> @{{
                                  color.color.color_code }}

                                </option>
                              </select>
                            </td>
                            <td v-for="(size, k) in sizes" :key="k">
                              <input type="number" name="cutting_plans" v-model="size.value"
                                class="form-control input cutting_plans" style="padding:0px !important;"
                                @@change='updateTotal' @@keydown.enter="goToNextField(k)">
                            </td>
                            <td style="width:5rem;"><input readonly v-model="totalq" type="number" name="sum" id="total"
                                class="form-control cuttingplantotal" data-index="5" >
                            </td>
                            <td>
                              <button class="btn global_btn_color" data-index="6" @@click="toBottom()" ref="totalfocus"><svg
                                  xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                  fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                  stroke-linejoin="round" class="feather feather-arrow-down">
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
     



    <section id="input-mask-wrapper" v-if="show == 1" >
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <div class="row" id="table-head">
                <div class="col-12">
                  <div class="card">
                    <div >
                      <table class="table table-bordered"  width="100%" cellspacing="0" style="">
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
                           
                            <td style="text-align:center; "  class="tp" v-for="s in sizes"> @{{
                              c.cs[s.id] }} </td>
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
      <button class="btn global_btn_color" @@click="sumbitData()" data-index="7">Save</button>
      <form id="saveAuditForm" method="post" action="{{ route('moveToStock') }}" >
        @csrf
        <input type="hidden"  id='saveAuditDetail' name="data" >
      </form>
    </section>
  </div>
</div>

  </div>

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
        el: '#stock_audit',
        data: {
            auditNumber: {{$auditNumber }},
            sizes: @json($sizes),
            warehouses: @json($warehouses),
            mainCat:@json($main_categories),
            maincatoption:[],//
            main_category_id:  {!! $cat_data == null ? "''" :  json_encode($cat_data['main_category_id']) !!},
             sub_category_id: {!! $cat_data == null ? "[]" :  json_encode($cat_data['sub_cat_ids']) !!},
             sub_sub_category_id:  {!! $cat_data == null ? "[]" :  json_encode($cat_data['sub_sub_category_ids']) !!},//
             sub_sub_sub_category_id: [],
             products:[],
             filterProducts:[],
             products:[],
             colors:[],
             formData:"",
             subCat:[],//
             subsubCat:[],//
             warehouse_id: {!! $cat_data == null ? "''" :  json_encode($cat_data['warehouse_id']) !!},
             warehouse_name: "",
             product_object:"",
             color_object:"",
             product_id: "",
             product_name: "",
             color_id: "",
             color_name: "",
             child: {!! $child == null ? "[]" :  json_encode($child) !!},
             error:[],
             audit: "",
             buttonText: "",
             selected:0,
             typeEan:"",
             totalq:0,
             sub_cat_ids:{!! $cat_data == null ? "[]" :  json_encode($cat_data['array_sub_category']) !!},
             temp_child:{},
             categoryData:{},
             show:{!! $cat_data == null ? "0" :  1 !!},
             showbtn:{!! $cat_data == null ? "false" :  true !!},
             scannerStatus:"Disable Scanner",
             isActive:true,
        },
        created(){
            var vm=this;
            for (let index = 0; index < vm.mainCat.length; index++) {
                vm.maincatoption.push({ id: vm.mainCat[index].id, text: vm.mainCat[index].name });
            }
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
          getWarehouseData:function(){
          vm=this;
          const data = JSON.stringify({
                      // type_search: search,
                      w_id:vm.warehouse_id ? vm.warehouse_id : null,
                      main_cat_id: vm.main_category_id.id ? vm.main_category_id.id :null,
                      sub_cat_ids:vm.sub_cat_ids ? vm.sub_cat_ids  : null,

                  });
            const config = {
                      headers: {
                          'Content-Type': 'application/json'
                      }
                  }
              axios.post("{{ url('/getAuditProductSearch') }}", data,config).then(res => {
                console.log(res.data.data);
                vm.temp_child.products= res.data.data;
              });
          
          },
            searchProduct(search, loading){
            vm=this;
            console.log(vm.sub_category_id.id);
            if (search.length < 1) {
                return ;
            }
            vm.colors = [];
            const data = JSON.stringify({
                      type_search: search,
                      w_id:vm.warehouse_id ? vm.warehouse_id : null,
                      main_cat_id: vm.main_category_id.id ? vm.main_category_id.id :null,
                      sub_cat_ids:vm.sub_cat_ids ? vm.sub_cat_ids  : null,

                  });
            const config = {
                      headers: {
                          'Content-Type': 'application/json'
                      }
                  }
              axios.post("{{ url('/getAuditProductSearch') }}", data,config).then(res => {
                vm.products= res.data.data;
              });
                    
          },
            filterProd:function(){
                var vm= this;               
                vm.filterProducts= vm.mainProducts.filter(function (el){
                    if(vm.main_category_id != '' && vm.sub_category_id.length == 0){
                     return el.main_category_id == vm.main_category_id;
                    }
                    else if(vm.main_category_id != '' && vm.sub_category_id.length > 0 && vm.sub_sub_category_id.length == 0){
                         return vm.sub_category_id.includes(el.category_id);
                    }
                    else if(vm.main_category_id != '' && vm.sub_category_id.length > 0  &&  vm.sub_sub_category_id.length > 0){
                              console.log(el);
                              
                        return vm.sub_sub_category_id.includes(el.parseInt(sub_category_id));
                    }
                })
            },
            filterMain: function(){
               
            },
             startAuditing:function(){
                vm=this;
                // vm.categoryData.warehouse_id=vm.warehouse_id;
                // vm.categoryData.main_category_id=vm.main_category_id;
                // vm.categoryData.sub_cat_ids=vm.sub_cat_ids;
                // vm.categoryData.sub_sub_category_ids=vm.sub_sub_category_id;
                // vm.temp_child.sub_category_id=vm.sub_category_id;

                    var formData = {};
                    formData.warehouse_id=vm.warehouse_id;
                    formData.main_category_id=vm.main_category_id;
                    formData.array_sub_category=vm.sub_cat_ids;
                    formData.sub_cat_ids=vm.sub_category_id;
                    formData.sub_sub_category_ids=vm.sub_sub_category_id;
                    vm.formData = JSON.stringify(formData);
                    document.getElementById("formdata").value = vm.formData;
                    document.getElementById("auditform").submit();
               
             },

             searchEAN:function(e){
                vm=this;
                if(vm.warehouse_id == null){
                 return toastr['success']('Select Warehouse', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                }
                if(vm.typeEan.length  == 13){
                    $('#searchErrorMessage').text("");
                    const data = JSON.stringify({ 
                      warehouse_id:vm.warehouse_id,
                      product_ean : vm.typeEan});
                const config = {
                    headers: {'Content-Type': 'application/json'}
                }

                axios.post("{{ url('/getDataByStockSearch') }}", data,config).then(res => {
                  // if(res.data.data.qty.qty == 0 ){
                  // return   toastr['success'](`${res.data.data.qty.size.size} has 0 quantity`, '', {
                  //   closeButton: true,
                  //   tapToDismiss: false,
                  //   progressBar: true,
                  // });
                  // }
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

                          let totalqt={};
                        for(let cskeys in product[0].cs){
                                    //  if(parseInt(product[0].cs[cskeys]) <  res.data.data.qty.qty){
                                     totalqt[cskeys]= cskeys == res.data.data.qty.size_id ?  parseInt(product[0].cs[cskeys]) + 1 : parseInt(product[0].cs[cskeys])  + 0;
                                    //  }
                                    //  else{
                                    //   return  toastr['success'](`No Quantity left`, '', {
                                    //       closeButton: true,
                                    //       tapToDismiss: false,
                                    //       progressBar: true,
                                    //     });
                                    //  }
                                 }
                        cs=totalqt;
                        let spl_key = []
                                        for(const [key,val] of Object.entries(vm.child)){
                                               if(val.product_name == product[0].product_name){
                                                spl_key.push(key)
                                               }
                                        }
                                      var spliceElement=vm.child.splice(spl_key,1);
                        var sstotalQTY=product[0].totalq + 1;
                        vm.child.push({
                                      "totalq": product[0].totalq + 1,
                                      'product_id':res.data.data.product.product_master_id,
                                      'product_name':res.data.data.product.parent.product_code,
                                      'color_id':res.data.data.product.color_id,
                                      'color_name':res.data.data.product.color.color_code,
                                      cs
                                      });
                                      vm.color_id=""
                                      vm.product_id="";
                                      vm.typeEan="";


                        }else{
                          
                          vm.child.push({
                                      "totalq": 1,
                                      'product_id':res.data.data.product.product_master_id,
                                      'product_name':res.data.data.product.parent.product_code,
                                      'color_id':res.data.data.product.color_id,
                                      'color_name':res.data.data.product.color.color_code,
                                      cs
                                      });
                                      vm.color_id=""
                                      vm.product_id="";
                                      vm.typeEan="";

                        }
                      }else{
                        
                        vm.child.push({
                                      "totalq": 1,
                                      'product_id':res.data.data.product.product_master_id,
                                      'product_name':res.data.data.product.parent.product_code,
                                      'color_id':res.data.data.product.color_id,
                                      'color_name':res.data.data.product.color.color_code,
                                      cs
                                      });
                                      vm.color_id=""
                                      vm.product_id="";
                                      vm.typeEan="";

                                    

                      } 
                }).catch(error => {
                  toastr['success']('Product not found', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                          });
                }else{
                    $('#searchErrorMessage').text("EAN Should be 12 Digit");

                }
             },
              handleClick:function(){
                vm=this;
                axios.get(`{{ url('/getAllProduct') }}/${vm.warehouse_id}`).then(res => {
                })
              },
              getProductData:function(){
                vm=this;
                vm.selected=1;
                $('#auditButton').show();
                $('#addAuditButton').show();
                $('#addToList').show();
                var x = document.getElementById("product_id");
                var txt = "";
                var i;
                if(x.options[x.selectedIndex].value == 'yes'){
                for (i = 0; i < x.length; i++) {
                    if(x.options[i].value != 'yes'){
                    vm.child.push(JSON.parse(x.options[i].getAttribute('data-all'))); 
                    }
                  }
                }else{
                    var y = document.getElementById("color_id");
                     vm.child.push(JSON.parse(y.options[y.selectedIndex].getAttribute('data-all')));
                }
              },

              removeProductData:function(){
                vm=this;
                vm.child = [];
              },
            getSubCategory: function() {
                vm = this;
                vm.sub_category_id=[];
                axios.get(`{{ url('/getcategory') }}/${vm.main_category_id.id}`).then(res => {
                    vm.subCat=res.data.data;
                })
            //   vm.filterProd();
            },
            getSubSubCategory:function(){
                vm=this;                
                var producthtmll = "";
                var ids = vm.sub_category_id.map(function(i, el) {
                        return i.id;
                    });
                vm.sub_cat_ids=ids;
                      axios.get(`{{ url('/getSubCategory') }}/${ids}`).then(res => {
                            vm.subsubCat=res.data.data;
                        }).catch(error => {
                            $('#product_id').html(producthtmll);
                        });
                //  vm.filterProd();       
                },
                getSubSubSubCategory:function(){
                vm=this;
                var producthtmll = "";
                var sub_ids = vm.sub_sub_category_id.map(function(i, el) {
                        return i.id;
                    });
                    //   vm.filterProd();
                }
            , 
            getColor: function(e) {
              const data = JSON.stringify({
                        warehouse_id: vm.warehouse_id,
                        p_id:vm.product_object.id
                    });
                    const config = {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }
                    axios.post("{{ url('/getColorByAudit') }}", data, config).then(res => {
                    vm.colors = res.data.data;
                })
            },

        
            clickAudit: function() { 
                vm = this;
                if(vm.buttonText == "Enable"){
                  vm.audit = 1;
                   
                   for(list of vm.child){
                       axios.get(
                       `{{ url('/enableAudit') }}/${list.warehouse_id}/${list.product_master_id}/${list.color_id}/${vm.audit}`
                     ).then(res => {});
                   }

                }else{
                  vm.audit = 0;
                    for(list of vm.child){
                        axios.get(
                        `{{ url('/enableAudit') }}/${list.warehouse_id}/${list.product_master_id}/${list.color_id}/${vm.audit}`
                      ).then(res => {});
                    }
                }
            },

            toBottom() {
                var vm = this;
                if(vm.warehouse_id == null){
                 return toastr['success']('Select Warehouse', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                }
                if (vm.product_object.id != 0  && vm.totalq > 0 ) {
                  var cs = {};
                  var css = {};
                        for (k in vm.sizes) {
                            cs[vm.sizes[k].id] = vm.sizes[k].value ? parseInt(vm.sizes[k].value) : 0
                        }
                           const obj = {child:vm.child}
                            const options = {
                            headers: {'X-Custom-Header': 'value'}
                          };
                          //   axios.post(`{{ url('/auditcheckquantity')}}`,obj)
                          // .then(response => {
                            if(vm.child.length > 0){
                              var product=  vm.child.filter(function(el) {
                                return el.color_id== vm.color_object.color.id && el.product_id== vm.product_object.id;
                              });
                            if(product.length > 0){
                                let totalqty={};
                                 for(let csskeys in product[0].cs){
                                     totalqty[csskeys]= cs[csskeys] + product[0].cs[csskeys];
                                 }
                                      let spl_key = []
                                        for(const [key,val] of Object.entries(vm.child)){
                                               if(val.product_name == product[0].product_name){
                                                spl_key.push(key)
                                               }
                                        }
                                        var totalQTY=parseInt(vm.totalq) + parseInt(product[0].totalq);
                                        vm.child[spl_key].cs = totalqty;  
                                        vm.child[spl_key].totalq=parseInt(vm.totalq) + parseInt(product[0].totalq);
                                        vm.totalq = 0;
                                      for (k in vm.sizes) {
                                          vm.sizes[k].value = 0;
                                      }
                                      axios.post(`{{ route('storeTempAudit')}}`,obj).then(response => {
                                    })
                                    .catch(error => {
                                      console.log(error);
                                    }); 
                            }else{
                                      vm.child.push({
                                      "totalq": vm.totalq,
                                      'product_id':vm.product_object.id,
                                      'product_name':vm.product_object.product_code,
                                      'color_id':vm.color_object.color.id,
                                      'color_name':vm.color_object.color.color_code,
                                      cs,
                                      });
                                      vm.totalq = 0;
                                      for (k in vm.sizes) {
                                          vm.sizes[k].value = 0;
                                      }
                                      axios.post(`{{ route('storeTempAudit')}}`,obj).then(response => {
                                    })
                                    .catch(error => {
                                      console.log(error);
                                    }); 
                            }
                            }
                              else{
                                      vm.child.push({
                                      "totalq": vm.totalq,
                                      'product_id':vm.product_object.id,
                                      'product_name':vm.product_object.product_code,
                                      'color_id':vm.color_object.color.id,
                                      'color_name':vm.color_object.color.color_code,
                                      cs,
                                      });
                                      vm.totalq = 0;
                                      for (k in vm.sizes) {
                                          vm.sizes[k].value = 0;
                                      }

                                     axios.post(`{{ route('storeTempAudit')}}`,obj).then(response => {
                                      
                                    })
                                    .catch(error => {
                                      console.log(error);
                                    }); 
                                  }       
                        
                        }
              
            },
            sumbitData() {
                var vm = this;
                var auditformData = {};
                auditformData.main_category_id=vm.main_category_id;
                auditformData.warehouse_id=vm.warehouse_id;
                auditformData.auditNumber = vm.auditNumber;
                auditformData.oldChild = vm.child;
                vm.formData = JSON.stringify(auditformData);

                document.getElementById("saveAuditDetail").value = vm.formData;
                document.getElementById("saveAuditForm").submit();


                // vm.$refs.submit.submit()
            },
            resetData(){
              axios.get(`{{ route('resetCate')}}`).then(response => {
                window.location.href = "{{ route('stock.audit')}}";


                                    })
            },
            deleteData(k) {
               vm.child.splice(k, 1)
                },
            updateTotal() {
                    var total = 0;
                    var list = document.getElementsByClassName("cutting_plans");
                    var values = [];
                    for(var i = 0; i < list.length; ++i) {
                        values.push(list[i].value);
                    }
                this.sub(values);
            },
            sub(arr){
            var values= $.grep(arr, n => n ==  ' ' || n)
            var total = 0;
            
            for (var i in values) {
            total += parseInt(values[i]);
            }
                vm.totalq=total;
                
            
            },    

        },
       
         computed: {
            buttonStatus: function() {
                vm = this;
                if (vm.audit == 0) {
                    vm.buttonText = "Enable";
                } else {
                    vm.buttonText = "Disable";
                }
                return (vm.audit == 0) ? 'btn btn-success' : 'btn btn-danger ';
            },
        }
        , watch: {

        }
    })

    $(document).ready(function() {
    $('#warehouse_id').select2();
    $('#sub_category_id').select2();
    $('#sub_sub_category_id').select2();
    $('#product_id').select2();
});

</script>


@endpush