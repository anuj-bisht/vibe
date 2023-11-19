
@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">

@include('styles.style')

<div class="container">
    <section >
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Product Summary</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="productfilterreport" >
        <div class="row">
            <div class="col-sm-12">
                <div class="card collapse-icon">
                   
                    <div class="card-body">
                    
                        <div class="collapse-default">
                            <div class="card">
                                <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                    <span class="lead collapse-title"> Filter </span>
                                </div>
                                <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse">
                                    <div class="col-xl-12 col-md-12 col-12">
                                        <div class="card invoice-preview-card">
                                          <!-- Address and Contact starts -->
                                          @if(Session::has('message'))
                                          <p class="alert alert-success alert-heading">{{ Session::get('message') }}</p>
                                          @endif
                                          <div class="card-body invoice-padding pb-0">
                                            <div class="row invoice-spacing">
                                              <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                  <label for="city-column" style="color:black; ">Select Warehouse</label>
                                                  <select  class="form-control" id="warehouse_id" name="warehouse_id" data-index="1" v-model="warehouse_id"
                                                    v-select2 @@change="getWarehouseData" >
                                                    <option disabled selected value="">Select Warehouse</option>
                                                    <option v-for="warehouse in warehouses" :value="warehouse.id">@{{ warehouse.name}}
                                                    </option>
                                                  </select>
                                                </div>
                                              </div>
                                              <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                  <label for="city-column" style="color:black;">Main Category</label>
                                                  <select  class="form-control " id="main_category_id" name="main_category_id" v-model="main_category_id"
                                                    data-index="1" @@change="getSubCategory" >
                                                    <option disabled selected value="">Main Category</option>
                                                    <option v-for="main_cat in mainCat" :value="main_cat">@{{ main_cat.name}}</option>
                                                  </select>
                                                </div>
                                              </div>
                                              <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                  <label for="city-column" style="color:black;">Sub Category</label>
                                                  <v-select multiple label="name" :options="subCat" v-model="sub_category_id" @@input="getSubSubCategory" >
                                                  </v-select >
                                                </div>
                                              </div>
                                              <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                  <label for="city-column" style="color:black;">Sub Sub Category</label>
                                                  <v-select multiple label="name" :options="subsubCat" v-model="sub_sub_category_id"
                                                    @@input="getSubSubSubCategory" :disabled=showbtn></v-select>
                                                </div>
                                              </div>
                                              <div class="col-md-3 col-12">
                                                <button  class="btn btn-primary" data-index="7" @@click="startAuditing">Search</button>
                                                <form id="saveAuditForm" method="post" action="{{ route('productSummary.report') }}" >
                                                    @csrf
                                                    <input type="hidden"  id='saveAuditDetail' name="data" >
                                                  </form>
                                              </div>
                                            </div>
                                          </div>
                                          <!-- Address and Contact ends -->
                                        </div>
                                      </div>
                                </div>
                            </div>
                      
               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="card-demo-example">
        <div class="row match-height">
            @foreach($finished_data as $data)
            <div class="col-md-6 col-lg-3 " onmouseenter="showqty({{$data['id']}})" onmouseleave="hideModal({{$data['id']}})">
                <div class="card">
                    <img class="card-img-top" src="{{$data['p_image1']}}" alt="Card image cap" />
                    <div class="card-body">
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>
                        <p class="card-text text-center">
                            {{ $data['color']['name'] }}
                        </p>
                        <p class="card-text text-center">
                            {{ $data['sum'] }}
                        </p>
                   
                    </div>
                </div>
            </div>
            @endforeach

            


       
        </div>
    </section>
    <div class="d-flex justify-content-center">
        {!! $finished_data->links() !!}
    </div>
</div>

@foreach($finished_data as $data)
@foreach ($data['child'] as $detail)
    

<div class="modal fade text-left" id="xlarge{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h4 class="modal-title" id="myModalLabel16">Edit</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
           
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: smaller;">
                   <thead class="">
                       <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant; text-align:center;">
                           @foreach($sizes as $size)
                           <th style="padding:0.75rem !important;">
                               <?php
                                $str=explode('/',$size->size);
                                
                                $a=$str[0]??'';
                                $b=$str[1]??'';
                                echo "$a<br>$b";
                                 ?>
                           </th>
                           @endforeach
                           {{-- <th style="padding:0.75rem !important;">Total Qty</th> --}}
                       </tr>
                   </thead>
                   <tbody>
                     <tr style="text-align:center;">
                        @foreach ($data['child'] as $attribute)
                        <td><input type="number"  value="{{$attribute->qty}}"  class="form-control input"></td>
                        @endforeach
                     </tr>
                   
                   </tbody>
               </table>
           
           </div>
          
       </div>
   </div>
</div>
@endforeach
@endforeach


@endsection

@push('scripts')

<script>
function showqty(id){
var product_id = `#xlarge${id}`
$(product_id).modal({
        show: true
    });
}

function hideModal(id){
var product_id = `#xlarge${id}`
$(product_id).modal({
        show: false
    });
}

    

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
        el: '#productfilterreport',
        data: {
            warehouses: @json($warehouses),
            mainCat:@json($main_categories),
            warehouse_id: {!! $cat_data == null ? "''" :  json_encode($cat_data['warehouse_id']) !!},
            maincatoption:[],//
            main_category_id:  {!! $cat_data == null ? "''" :  json_encode($cat_data['main_category_id']) !!},
             sub_category_id: {!! $cat_data == null ? "[]" :  json_encode($cat_data['sub_cat_ids']) !!},
             sub_sub_category_id:  {!! $cat_data == null ? "[]" :  json_encode($cat_data['sub_sub_category_ids']) !!},//
             sub_sub_sub_category_id: [],
             formData:"",
             subCat:[],//
             subsubCat:[],//
             sub_cat_ids:{!! $cat_data == null ? "[]" :  json_encode($cat_data['array_sub_category']) !!},
             sub_sub_cat_ids:{!! $cat_data == null ? "[]" :  json_encode($cat_data['array_sub_sub_category']) !!},
             
             temp_child:{},
             categoryData:{},
     


             
            


        },
        created(){
         
        },

        methods: {
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
           
         
          
             startAuditing:function(){
                vm=this;
              

                    var formData = {};
                    formData.warehouse_id=vm.warehouse_id;
                    formData.main_category_id=vm.main_category_id;
                    formData.array_sub_category=vm.sub_cat_ids;
                    formData.sub_cat_ids=vm.sub_category_id;
                    formData.sub_sub_category_ids=vm.sub_sub_category_id;
                    formData.sub_sub_category_ids=vm.sub_sub_cat_ids;
                    vm.formData = JSON.stringify(formData);
                    document.getElementById("formdata").value = vm.formData;
                    document.getElementById("auditform").submit();
               
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
                },
                getSubSubSubCategory:function(){
                vm=this;
                var producthtmll = "";
                var sub_ids = vm.sub_sub_category_id.map(function(i, el) {
                        return i.id;
                    });
                   vm.sub_sub_cat_ids=  sub_ids;
                }
            , 
       
            sumbitData() {
                // var vm = this;
                // var auditformData = {};
                // auditformData.main_category_id=vm.main_category_id;
                // auditformData.warehouse_id=vm.warehouse_id;
                // auditformData.auditNumber = vm.auditNumber;
                // auditformData.oldChild = vm.child;
                // vm.formData = JSON.stringify(auditformData);

                // document.getElementById("saveAuditDetail").value = vm.formData;
                // document.getElementById("saveAuditForm").submit();


            },
        
          
             

        },
       
         computed: {
       
        }
        , watch: {

        }
    })

    $(document).ready(function() {
    $('#warehouse_id').select2();
    $('#sub_category_id').select2();
    $('#sub_sub_category_id').select2();
   
});    
</script>
    
@endpush




