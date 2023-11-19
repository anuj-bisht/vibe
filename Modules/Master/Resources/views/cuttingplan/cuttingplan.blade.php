@extends('layouts.app')
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
    <div class="container" id="basic-input">

        <section >
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Create Cutting</h4>
                            <a href="{{route('Allplan')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="">
                        <section id="input-mask-wrapper">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-5 col-md-6 col-sm-12 ">
                                                    <label for="basicSelect">Cutting Plan No.</label>
                                                    <span class="plan_season_name"></span>
                                                    <input type="hidden" class="form-control"  id="plan_season_name" name="cutting_plan_name" placeholder="Cutting Plan Name"  required  />
                                                </div>
                                                <div class="col-xl-7 col-md-6 col-sm-12 " style="text-align:end">
                                                    <h5 class="card-title" style="font-size:1rem;">{{ \Carbon\Carbon::today()->format('d-M-Y');}}</h5>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-9 col-md-6 col-sm-12 ">
                                                    <label for="basicSelect">Select Season</label>
                                                    <a style="float: right;" href="{{route('master.season.create')}}" target="_blank" style="color:blue; ">Create</a>
                                                    <select ref="setFocus"  class="form-control " data-index="1" id="season_id" name="season_id" required  v-model="seasion" @@change="makecode($event)"  v-select2>
                                                        <option disabled selected value="">Select Warehouse</option>
                                                        <option v-for="season in Seasons" :value="season.id" >@{{ season.name }}</option>
                                                    </select>
                                                    @error('parent_id')
                                                        <h5 class="alert alert-danger">{{ $message }}</h5>
                                                    @enderror
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
                                            <div class="row">
                                                <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                                    <table class="title-form horizontaltable" >
                                                        <tbody style="font-size:12px;">
                                                            <tr>
                                                                <td class="text-left" >P Code</td>
                                                                <td class="text-color">C Code</td>
                                                                <td>Cutting Ratio</td>
                                                                <td>QTY</td>
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
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="width:9rem;" >
                                                                    <v-select ref="productSelect" @@close="focusVSelect" label="product_code" :options="products" v-model="product_object" @@input="getColor"  @@search="searchProducts"></v-select>
                                                                </td>
                                                                <td style="width:8rem;">
                                                                    <input type="hidden" id="pro_code"  >
                                                                    <select ref="colorSelect" v-model="color_id" data-index="3"  class="form-control" id="color_id" name="color_id" required @@change="getColorObject($event)"   v-select2>
                                                                        <option selected disabled></option>
                                                                        <option v-for="color in colors" :value="color.color.id"> @{{ color.color.color_code }} 
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td style="width:8rem;">
                                                                    <select v-model="ratio" class="form-control" id="cutting_id" name="cutting_id"
                                                                        @@change="rationChnage()" required data-index="4"  >
                                                                        <option disabled selected>Select Cutting Ratio Name</option>
                                                                        <option v-for="v in cuttingData" :value="v"> @{{ v.name }}
                                                                        </option>
                                                                    </select>
                                                                </td>
                                                                <td style="width:5rem;"><input v-model="totalq" @@change="qchange()" type="number"
                                                                    name="sum" id="total" class="form-control cuttingplantotal" data-index="5"  >
                                                                </td>
                                                                <td v-for="size in sizes" >
                                                                    <input  type="number" name="cutting_plans" v-model="size.value"
                                                                        class="form-control input cutting_plans"  style="padding:0px !important; " @@change='updateTotal'>
                                                                </td>
                                                                 <td>
                                                                    <button class="btn global_btn_color " @@click="toBottom()" data-index="6"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down"><line x1="12" y1="5" x2="12" y2="19"></line><polyline points="19 12 12 19 5 12"></polyline></svg></button>
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
            </div>


            <section id="input-mask-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" id="table-head">
                                        <div class="col-12"> 
                                        <div class="card">
                                            <div >
                                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
                                                    <thead>
                                                        <tr style="background-color: #32AD89; color:white;">
                                                            <td style="text-align:center;">P Code</td>
                                                            <td style="text-align:center;">C Code</td>
                                                            <td style="text-align:center;">Ratio</td>
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
                                                            <td style="text-align:center;" class="tp">@{{ c.ratio_id.name }}</td>
                                                            <td style="text-align:center;"  class="tp" v-for="s in sizes"  > @{{ c.cs[s.id] }} </td>
                                                            <td style="text-align:center;" class="tp">@{{ c.totalq }}</td>
                                                            <td  style="paddng:0.75px !important"><a class="btn btn-sm btn-danger" href="javascript:void(0)"
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
            <form id="mainform" method="post" action="{{ route('moveToQuantity') }}">
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
                Seasons:@json($season),
                products:[],
                colors: [],
                product_object:"",
                season_id:"",
                planSeasonName: "",
                sizes: @json($sizes),
                cuttingData: @json($cuttingData),
                ratio: "",
                totalq: 0,
                color_id:"",
                color_name: "",
                child: [],
                formData: "",
                seasion: 0,
                plan_season_name:'',
                totalq:0,
            },
            created() {

            },
            methods: {
                focusVSelect:function(){
                vm=this;
                vm.$refs.colorSelect.focus();
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
                    vm=this;
                var values= $.grep(arr, n => n ==  ' ' || n)
                var total = 0;
            
                for (var i in values) {
                total += parseInt(values[i]);
                }
                vm.totalq=total;
                    // document.getElementById("total").value = total;
                    // $('#total').attr('value',total);
                },
                searchProducts(search, loading){
                    vm=this;
                    if (search.length < 1) {
                      return ;
                  }
                    axios.get(`{{ url('/getSearchProduct') }}/${search}`).then(res => {
                    vm.products = res.data.data;
                });
                },
                getColor:function(){
                    vm=this;
                axios.get(`{{ url('/getColorId/') }}/${vm.product_object.id}`).then(res => {
                    
                    vm.colors=res.data.data;
                })
                },
                getColorObject:function(event){
                    vm=this;
                    vm.color_name = event.target.options[event.target.options.selectedIndex].text;
                },
                sumbitData() {
                    var vm = this;
                    if(vm.plan_season_name == '' && vm.child.length == 0){
                 return toastr['success']('Please fill all the field', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                }
               
                    var formData = {};
                    formData.plan_name = vm.planName;
                    formData.planSeasonName=$('#plan_season_name').val();
                    formData.seasion_id = vm.seasion;
                    formData.child = vm.child;
                    vm.formData = JSON.stringify(formData);
                    document.getElementById("formdata").value = vm.formData;
                    document.getElementById("mainform").submit();
                },
                rationChnage() {
                    if (this.ratio.child_array != undefined) {
                        var sizes = this.sizes;
                        for (s in sizes) {
                            if (this.ratio.child_array[this.sizes[s].id] !== undefined) {
                                sizes[s].ratio = this.ratio.child_array[sizes[s].id];
                            } else {
                                sizes[s].ratio = 0;
                            }
                        }
                        this.sizes = sizes;
                    }
                },
                qchange() {
                    var sizes = this.sizes;
                    var sum = 0;
                    for (s in sizes) {
                        var v = Math.ceil((sizes[s].ratio * this.totalq) / 100);
                        sum += v;
                        if (sum > this.totalq) {
                            sum = sum - v;
                            v = this.totalq - sum;
                        }
                        sizes[s].value = v;
                    }
                    this.sizes = sizes;
                    this.$forceUpdate();
                },
                makecode(event){
                    this.$refs.productSelect.searchEl.focus();
                    vm=this;
                    var code= event.target.options[event.target.options.selectedIndex].text;
                    $('#plan_season_name').val(code+'-0'+{{$unique_id}});
                    $('.plan_season_name').text(code+'-0'+{{$unique_id}});   
                    },
                toBottom() {
                    var vm = this;
                    if (vm.product_object.id != 0 && vm.ratio != "" && vm.totalq > 0) {
                        var cs = {};
                        var css = {};
                        for (k in vm.sizes) {
                            cs[vm.sizes[k].id] = vm.sizes[k].value;
                        }

                        if(vm.child.length > 0){
                            var product=  vm.child.filter(function(el) {                                
                            return el.color_id== vm.color_id && el.product_id== vm.product_object.id;
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
                                    vm.$refs.productSelect.searchEl.focus();

                            }else{
                                this.updateTotal();
                                    vm.child.push({
                                    "totalq": vm.totalq,
                                    'product_id':vm.product_object.id,
                                    'product_name':vm.product_object.product_code,
                                    'color_id':vm.color_id,
                                    'color_name':vm.color_name,
                                     "ratio_id":vm.ratio,
                                    cs,
                                    });
                                    vm.totalq = 0;
                                    for (k in vm.sizes) {
                                        vm.sizes[k].value = 0;
                                    }
                                    vm.$refs.productSelect.searchEl.focus();

                                   
                            }
                            }
                        else{
                            this.updateTotal();
                        vm.child.push({
                            "totalq": vm.totalq,
                            'product_id':vm.product_object.id,
                            'product_name':vm.product_object.product_code,
                            'color_id':vm.color_id,
                            'color_name':vm.color_name,
                            "ratio_id": vm.ratio,
                            cs,
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
            computed: {
                isDisabled: function() {
                    return (this.product_id != 0 && this.totalq != 0 && this.ratio != "");
                }
            },
            mounted(){
             $('#season_id').select2();
             $('#season_id').select2('open');

        },
            watch: {}
        })
  

        
       
     
        // $(document).ready(function() {
        //     // $('#color_id').select2();
        //     $('#season_id').select2();

        // });
</script>
@endpush
