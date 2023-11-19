@extends('retail.layouts.app')

@section('retail_content')
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
<div class="container" id='retailstock_audit'>
  <section id="">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title" >Stock Audit</h4>
            <span>
              <a href="{{route('retail.stockAudit')}}" class="btn btn-sm" style="background-color: #009973; color:white;">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="feather feather-home">
                  <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                  <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
              </a>
            </span>
          </div>
        </div>
      </div>
    </div>
  </section>


  <form id="auditform" method="post" action="{{ route('moveToTempAuditDetail') }}">
    @csrf
    <input type="hidden" id="formdata" name="data">
  </form>

  <div class="col-xl-12 col-md-12 col-12" >
  <button v-if="show == 0" class="btn btn-primary" data-index="7" @@click="startAuditing">Start</button>
  <button v-if="show == 1" class="btn btn-dark" data-index="7" @@click="startAuditing">Reset</button>
  </div>
  <div class="col-md-12 d-flex justify-content-end">
    <abbr  data-toggle="tooltip" :data-original-title=scannerStatus><img style="width:30px; height:30px; object-fit:contain; margin-left:10px; cursor: pointer;"  @@click="changeStatus()"  src={{asset('device.jpeg')}} alt="Image"/></abbr>
  </div>
  <div>
    <div class="col-xl-12 col-md-12 col-12" >
      <div class="card invoice-preview-card">
        <section v-if="show == 1">
          <div class="row" style="justify-content: center;">
            <div class="col-md-9">
              <div class="card">
                <div class="card-header">
                  <input v-if="isActive" class="form-control input" type="text" placeholder="Search Ean" data-search="search"
                    v-model="typeEan" id="ean_no" @@input="searchEAN(this)">
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Invoice Description starts -->
        <section id="input-mask-wrapper"  v-if="show == 1">
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
                              <v-select label="product_code" :options="products" v-model="product_object"
                              @@close="focusVSelect" ref="productSelect" @@input="getColor" @@search="searchProduct"></v-select>
                            </td>
                            <td style="width:8rem;">
                              <input type="hidden" id="pro_code">
                              <select data-index="3" class="form-control" ref="colorSelect" id="color" v-model="color_object"
                                name="color_id" required  @@change="getMrp"  v-select2>
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
                                class="form-control cuttingplantotal" data-index="5" onkeydown="jumpNextField(event)">
                            </td>
                            <td>
                              <button class="btn global_btn_color" ref="totalfocus" data-index="6" @@click="toBottom()"><svg
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
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>



    <section id="input-mask-wrapper"  v-if="show == 1">
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
      <form id="saveRetailAuditForm" method="post" action="{{ route('moveToRetailStock') }}" >
        @csrf
        <input type="hidden"  id='saveRetailAuditDetail' name="data" >
      </form>
    </section>

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
        el: '#retailstock_audit',
        data: {
            auditNumber: {{$auditNumber }},
            sizes: @json($sizes),
             products:[],
             colors:[],
             formData:"",
             product_object:"",
             color_object:"",
             product_id: "",
             product_name: "",
             color_id: "",
             color_name: "",
             child: [],
             audit: "",
             selected:0,
             typeEan:"",
             totalq:0,
             show:{{ $temp_audit }},
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
            getMrp: function() {
                vm = this;

                const nextField = document.getElementsByName("cutting_plans")[0];
                  nextField.focus();
            },
          startAuditing(){
          vm=this;
          if(vm.show == 0){
            vm.show = 1;
            const data = JSON.stringify({
                      show: vm.show,
                       
                  });
            const config = {
                      headers: {
                          'Content-Type': 'application/json'
                      }
                  }
              axios.post("{{ url('/saveTempRetailAudit') }}", data,config).then(res => {
                console.log(res.data.data);
              });
          }else{
            vm.show = 0;
            const data = JSON.stringify({
                      show: vm.show,
                       
                  });
            const config = {
                      headers: {
                          'Content-Type': 'application/json'
                      }
                  }
              axios.post("{{ url('/saveTempRetailAudit') }}", data,config).then(res => {
                console.log(res.data.data);
              });

          }
          },
            searchProduct(search, loading){
            vm=this;
            if (search.length < 1) {
                return ;
            }
            vm.colors = [];
            const data = JSON.stringify({
                      type_search: search,
                       
                  });
            const config = {
                      headers: {
                          'Content-Type': 'application/json'
                      }
                  }
              axios.post("{{ url('/getRetailAuditProductSearch') }}", data,config).then(res => {
                vm.products= res.data.data;
              });
                    
          },
          getColor: function(e) {
              const data = JSON.stringify({
                        p_id:vm.product_object.id
                    });
                    const config = {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }
                    axios.post("{{ url('/getColorByRetailAudit') }}", data, config).then(res => {
                    vm.colors = res.data.data;
                })
            },
             searchEAN:function(e){
                vm=this;
              
                if(vm.typeEan.length  == 13){
                    const data = JSON.stringify({ 
                      product_ean : vm.typeEan});
                const config = {
                    headers: {'Content-Type': 'application/json'}
                }

                axios.post("{{ url('/getDataByRetailStockSearch') }}", data,config).then(res => {
               
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
                                     totalqt[cskeys]= cskeys == res.data.data.qty.size_id ?  parseInt(product[0].cs[cskeys]) + 1 : parseInt(product[0].cs[cskeys])  + 0;
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
                  vm.color_object = "";
                  vm.product_object = "";
                  vm.typeEan = "";
                          });
                }else{
                    toastr['success']('EAN Should be 13 Digit', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                  
                }
             },
          
          

            toBottom() {
                var vm = this;
              
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
                                      vm.color_object="";

                                      this.$refs.productSelect.searchEl.focus();
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
                                      vm.color_object="";
                                      this.$refs.productSelect.searchEl.focus();                                    
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
                                      vm.color_object="";
                                      this.$refs.productSelect.searchEl.focus();
                                  }       
                        }
            },
            sumbitData() {
                var vm = this;
                var auditformData = {};
                auditformData.auditNumber = vm.auditNumber;
                auditformData.child = vm.child;
                vm.formData = JSON.stringify(auditformData);
                document.getElementById("saveRetailAuditDetail").value = vm.formData;
                document.getElementById("saveRetailAuditForm").submit();

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
        mounted(){
          vm=this;
            vm.$refs.productSelect.searchEl.focus();

        },
    })


</script>


@endpush