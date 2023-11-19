@extends('layouts.app')
@include('styles.style')
@section('content')
<style>
    select.form-control:not([multiple='multiple']) {
      background-image: linear-gradient(45deg, transparent 50%, white 50%), linear-gradient(135deg, white 50%, transparent 50%), linear-gradient(to right, #32AD89, #32AD89);
      background-position: calc(100% - 20px) calc(1em + 2px), calc(100% - 15px) calc(1em + 2px), 100% 0;
      background-size: 5px 5px, 5px 5px, 2.8em 2.8em;
      background-repeat: no-repeat;
      -webkit-appearance: none;
    }
  </style>
  <div class="container" id='picklistvalidator'>
        <section id="">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title" style="color:black; ">Pickist Validator</h4>

                <span>
                  <a href="javascript:void(0)" class="btn btn-sm" style="background-color: #009973; color:white;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
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

      <section>
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="city-column" style="color:black; ">Order No.</label>
                      <select class="form-control select2" id="order_no" name="order_no" data-index="1" onchange="getPicklistId()">
                        <option disabled selected value="">Select Order</option>
                         @foreach($order_id as $order)
                         <option value="{{$order->id}}">{{$order->ord_id}}</option>
                         @endforeach
                      </select>
                       @error('order_no') <h5 class="alert alert-danger">{{$message}}</h5> @enderror
                    </div>
                  </div>

                  <div class="col-md-6 col-12">
                    <div class="form-group">
                      <label for="city-column" style="color:black; ">Picklist No.</label>
                      <select class="form-control " id="picklist_no" name="picklist_no" data-index="1" v-model="picklistSelected" onchange="getProduct()">
                        <option disabled selected value="">Select Picklist</option>
                        
                      </select>
                       @error('picklist_no') <h5 class="alert alert-danger">{{$message}}</h5> @enderror
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>


      <section id="">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title" style="color:black; ">Picklist </h4>
              </div>
              <div class="table-responsive">
                <table class="table" id="ordertable" width="100%" cellspacing="0">
                    <thead class="" >
                        <tr>
                            <th style='text-align:center;'>P Code</th>
                            <th style='text-align:center;'>C Code</th>
                            @foreach($sizes as $size)
                            <th  style=" text-align:center;">
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
                    <tbody>

                      <tr id="" v-for="c in  picklistData" >
                        <td style='text-align:center;' class="tp" > @{{ c.product.product_code}} </td>
                       <td style='text-align:center;' class="tp"> @{{ c.color.color_code}}</td>
                       <td style='text-align:center;' v-for="child in c.child">@{{child.qty}}</td>
                       <td style='text-align:center;'>@{{c.total}}</td>
                     </tr>


                    </tbody>
                </table>
            </div>
            </div>

          </div>
        </div>
      </section>


      <section id="input-mask-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    {{-- v-if="ratio.child_array !== undefined" --}}
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                <table class="title-form horizontaltable" >
                                    <tbody style="font-size:12px;">
                                        <tr>
                                            <td class="text-left" >P Code</td>
                                            <td></td>
                                            <td class="text-color" >C Code</td>
                                            <td></td>
                                        </tr>
                                        <tr>

                                            <td style="width:25rem;" >
                                                <select  class="form-control select2" id="product_id" name="product_id"
                                                    required  onchange="getColor()" data-index="2"   onkeydown="jumpNextField(event)">
                                                    <option selected disabled>Product</option>
                                                   

                                                </select>
                                            </td>
                                            <td style="width:5rem;" >
                                             
                                            </td>
                                            <td style="width:25rem;" >
                                                <input type="hidden" id="pro_code"  >
                                                <select  data-index="3"  class="form-control select2" id="color_id" name="color_id" required  onkeydown="jumpNextField(event)">
                                                    <option selected disabled></option>
                                                </select>
                                            </td>


                                            <td>
                                                <button class="btn global_btn_color " @@click="toBottom()" data-index="6"  >Add to list</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="title-form horizontaltable" >
                                    <tbody style="font-size:12px;">
                                        <tr>

                                          @foreach($sizes as $size)
                                          <td  style=" text-align:center;">
                                             <?php
                                             $str=explode('/',$size->size);
                                             
                                             $a=$str[0]??'';
                                             $b=$str[1]??'';
                                             echo "$a<br>$b";
                                              ?>
                                          </td>
                                          @endforeach
                                            <td  style="text-align:center"> Total</td>

                                        </tr>
                                        <tr>
                                            <td v-for="size in sizes" >
                                                <input  type="number" name="cutting_plans" v-model="size.value"
                                                    class="form-control input cutting_plans"   style="padding:0px !important;" onchange='updateTotal();'>
                                            </td>
                                            <td><input v-model="totalq" type="number"
                                            name="sum" id="total" class="form-control cuttingplantotal" data-index="5" onkeydown="jumpNextField(event)" >
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

      <section id="input-mask-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="card">

                    <div class="card-body">
                        <div class="row" id="table-head">
                            <div class="col-12">
                                <div class="card">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
                                            <thead class="thead-dark" style="font-size:12px;">
                                                <tr style="background-color: #32AD89; color:white;">
                                                    {{-- <td>Product Id</td> --}}
                                                    <td style="text-align:center;">P Code</td>
                                                    <td style="text-align:center;">C Code</td>
                                                    {{-- <td style="text-align:center;">Ratio</td> --}}
                                                    <td style="text-align:center;">Total Qty</td>
                                                    @foreach($sizes as $size)
                                                    <td  style="text-align:center; text-align:center;">
                                                       <?php
                                                       $str=explode('/',$size->size);
                                                       
                                                       $a=$str[0]??'';
                                                       $b=$str[1]??'';
                                                       echo "$a<br>$b";
                                                        ?>
                                                    </td>
                                                    @endforeach
                                                    <td style="text-align:center;">Action</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                              <tr id="" v-for="(c, k) in child" :key="k">
                                                {{-- <td> @{{ c.product_id }} </td> --}}
                                                <td class="tp"> @{{ c.product_name }} </td>
                                                <td class="tp"> @{{ c.color_name }} </td>
                                                {{-- <td class="tp">@{{ c.ratio_id.name }}</td>--}}
                                                <td class="tp">@{{ c.totalsum }}</td> 
                                                <td contenteditable="true" class="tp" v-for="s in sizes"  > @{{ c.cs[s.id] }} </td>

                                                <td style="paddng:0px !important"><a class="btn btn-sm btn-danger" href="javascript:void(0)"
                                                        @@click="deleteData(k)"><svg
                                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="feather feather-trash-2">
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
    <form id="picklistform" method="post" action="{{ route('moveToFinalPicklist') }}">
      @csrf
      <input type="hidden" id="formpicklistdata" name="data">

  </form>



  </div>
   @endsection
   @section('scripts')
   <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
   <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js" integrity="sha512-zJYu9ICC+mWF3+dJ4QC34N9RA0OVS1XtPbnf6oXlvGrLGNB8egsEzu/5wgG90I61hOOKvcywoLzwNmPqGAdATA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
   <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
     <script>
   
   
     var app = new Vue({
                 el: '#picklistvalidator',
                 data: {
                   sizes:@json($sizes),
                   products:@json($products),
                   picklistSelected:"",
                   picklistId:"",
                   picklistData:"",
                   product_id:"",
                   color_id:"",
                   product_name:"",
                   color_name:"",
                   child: [],
                   check:false,
                   order_no:"",
                   picklist_no:"",
                   totalq:"",                 },
                 methods: {
                  getAllPicklist:function(){
                    axios.get(`{{ url('/getTotalPicklist') }}/${this.picklistId}`).then(res=> {
                          console.log(res.data.data);
                          this.picklistData=res.data.data;
                        // $.each(res.data.data,function(index,el){

                        //   vm.pickuplistsizes.push(el.pickupList);
                        // });


                        })
                  },
                  toBottom() {
                  
                    var vm = this;
                    // if(this.check == true){
                        var cs = {};
                        for (k in vm.sizes) {
                        if(vm.sizes[k].value != undefined){
                          cs[vm.sizes[k].id] = parseInt(vm.sizes[k].value);
                        }else{
                          cs[vm.sizes[k].id] = 0;
                        }
                        }
                        vm.child.push({
                            'product_id':$('#product_id').find(":selected").val(),
                            'product_name':$('#product_id').find(":selected").text(),
                            'color_id':$('#color_id').find(":selected").val(),
                            'color_name':$('#color_id').find(":selected").text(),
                            'totalsum':$('#total').val(),
                            cs,

                        });    
                           
                    vm.product_id = 0;
                    vm.product_name = "",
                    vm.color_name = "",
                    vm.color_id = 0;
                    
                    
                      }
                // },
                ,
                sumbitData() {
                    var vm = this;
                    var formData = {};
                    formData.order_no = $('#order_no').find(":selected").val(),
                    formData.picklist_no = $('#picklist_no').find(":selected").val(),
                    formData.child = vm.child;
                    vm.formData = JSON.stringify(formData);
                    document.getElementById("formpicklistdata").value = vm.formData;
                    document.getElementById("picklistform").submit();
                },
                 },

                 watch: {
                picklistSelected:function(){
                  this.picklistId= $('#picklist_no').val();
                  this.getAllPicklist();
                }
              
   
                 }
             });

          function getPicklistId(){
            var order_unique_no = $('#order_no').find(':selected').val();
            axios.get(`{{ url('/getPicklistNo') }}/${order_unique_no}`).then(res=> {
                var html = "";
                html = "<option>Select Picklist</option>";
                for(let list of res.data.data){
                    html += "<option value='"+list.id+"'>"+list.picklist_no+"</option>";
                }
                $('#picklist_no').html(html);
          })
        } 

        function getProduct(){
            var product_id = $('#picklist_no').find(':selected').val();
            axios.get(`{{ url('/getPicklistProduct') }}/${product_id}`).then(res=> {
                var html = "";
                html = "<option>Select Product</option>";
                for(let list of res.data.data){
                  console.log(list);
                    html += "<option value='"+list.product.id+"'>"+list.product.product_code+"</option>";
                }
                $('#product_id').html(html);
          })
        } 


    function getColor(){
     
        var id=$('#product_id').find(":selected").val();
        var picklist_id = $('#picklist_no').find(':selected').val();
               $.ajax({
            url: "{{ url('/getPicklistColor/') }}/" +picklist_id+"/"+id,
            type: "GET",
            success: function(response) {

                if(response.status == 200)
                    {
                      console.log(response);
                        var html = "";
                        html = "<option>Select Color</option>";
                        $.each(response.data,function(index,el){
                            console.log(el['color']['name']);
                            html += "<option value='"+el['color']['id']+"'>"+el['color']['name']+"</option>";

                        });
                        $('#color_id').html(html);
                    }
                    else
                    {
                        $('#color_id').html("<option>Record Not Found</option>");

                    }
            }
        });

    }

    function updateTotal() {
    
    var total = 0;//
    var list = document.getElementsByClassName("cutting_plans");
    var values = [];

    for(var i = 0; i < list.length; ++i) {
        values.push(list[i].value);
    }
    console.log(values)

sub(values);
}


function sub(arr){
   var values= $.grep(arr, n => n ==  ' ' || n)
   var total = 0;

for (var i in values) {
  total += parseInt(values[i]);
}
    document.getElementById("total").value = total;
    $('#totalq').attr('value',total);
}
   
     </script>
     <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
   
     <script src="{{asset('app-assets/vendors/js/forms/select/select2.full.min.js')}}"></script>
   
     <script src="{{asset('app-assets/js/core/app-menu.js')}}"></script>
     <script src="{{asset('app-assets/js/core/app.js')}}"></script>
   
     <script src="{{asset('app-assets/js/scripts/forms/form-select2.js')}}"></script>
   
      @endsection
