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
        <div class="card invoice-preview-card" style="margin-bottom:1rem;" >
            <div class="card-body invoice-padding pb-0">
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="invoice-title">
                            GRN No.
                            <span class="invoice-number"> @{{ grnNumber }}</span>
                        </h4>
                    </div>
                    <div class="col-md-7" style="text-align:center;">
                        <div class="logo-wrapper">
                            <img style="max-width:140px;" src="https://vibecode.paramsoft.co.in/public/masters/img/logo.png" alt="">
                        </div>
                    </div>
                    <div class="col-md-3">

                        <p class="invoice-date-title">Date Issued: @{{ gnrDate }}</p>
                        <select class="form-control " data-index="1" id="warehouse" name="warehouse" required v-model="warehouse_object"  v-select2>
                            <option disabled selected value="">Select Warehouse</option>
                            <option v-for="warehouse in warehouses" :value="warehouse">@{{ warehouse.name }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <hr class="invoice-spacing" />

            <!-- Address and Contact starts -->
            <div class="card-body invoice-padding pt-0">
                <div class="row invoice-spacing">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="city-column" style="color:black; ">Select State</label>
                            <select class="form-control" ref="setFocus"  id="state" name="state" required v-model="state_object"  @@change="getClient" v-select2 :disabled="client_name.length > 1" >
                                <option disabled selected value="">Select State</option>
                                <option v-for="state in states" :value="state">@{{ state.name }}</option>
                            </select>
                        </div>
                    </div>


                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="city-column" style="color:black; ">Clients</label>
                            <a style="float: right;" href="{{route('corporate.create')}}" target="_blank" style="color:blue; ">Create</a>
                            <select v-if="client_name.length < 1"  class="form-control"  id="client" ref="client" name="client" data-index="2" v-model="client_object" @@change="getThisClientDiscount" v-select2>
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
        <div class="card invoice-preview-card" style="margin-bottom:1rem;" >
            <div id="ean" class="row" style="justify-content: center">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <input v-if="isActive" class="form-control input" type="text" placeholder="Search Ean" data-search="search" v-model="typeEan" id="ean_no" @@input="searchEAN(this)">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invoice Description starts -->
            <section id="input-mask-wrapper">
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
                                                    <td style="width:9rem;" >
                                                        <v-select ref="productSelect"   label="product_code" data-index="3"  @@close="focusVSelect" :options="products" v-model="product_object" @@input="getColor" @@search="searchProduct"></v-select>
                                                    </td>
                                                    <td style="width:8rem;">
                                                        <input type="hidden" id="pro_code">
                                                        <select data-index="3" class="form-control" ref="colorSelect" id="color" v-model="color_object" name="color_id" required @@change="getColorObject($event)"  v-select2>
                                                            <option selected disabled></option>
                                                            <option v-for="color in colors" :value="color"> @{{
                                                                    color.color.color_code }}

                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td v-for="(size, k) in sizes" :key="k">
                                                        <input type="number" name="cutting_plans"  v-model="size.value" class="form-control input cutting_plans" style="padding:0px !important;" @@change='updateTotal' @@change='checkInputQty'  @@keydown.enter="goToNextField(k)">
                                                    </td>

                                                    <td style="width:5rem;"><input readonly v-model="totalq" type="number" name="sum" id="total" class="form-control cuttingplantotal" data-index="5">
                                                    </td>
                                                    <td>
                                                        <button class="btn global_btn_color " @@click="toBottom()" ref="totalfocus" data-index="6" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down">
                                                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                                                <polyline points="19 12 12 19 5 12"></polyline>
                                                            </svg></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div id="errorMessage" style="color:red;" v-for="err in error">@{{ err }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="input-mask-wrapper" style="">
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
                                                            <td style="text-align:center;"></td>

                                                            <td style="text-align:center;">Action</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr id="" v-for="(c, k) in child" :key="k">
                                                            <td style="text-align:center;" class="tp"> @{{
                                                                    c.product_name }} </td>
                                                            <td style="text-align:center;" class="tp"> @{{
                                                                    c.color_name }} </td>
                                                            <td style='text-align:center;' class="tp" v-for="(s,j) in c.cs"><span v-if="child[k].cs[j].err != ''" style="color:red;">@{{child[k].cs[j].err}}</span><input @@change="calData(child[k],k,c.product_id,c.color_id,child[k].cs[j],j,k,j)" style="width:35px; border:none;" type="number" name="" id="" v-model="child[k].cs[j]">
                                                            </td>
                                                            <td style="text-align:center;" class="tp">@{{ c.totalq}}</td>
                                                            <td><input type="checkbox" class="form-control" v-model="child[k].defective" style="width:15px;"></td>
                                                            <td style="paddng:0.75px !important"><a class="btn btn-sm btn-danger" href="javascript:void(0)" @@click="deleteData(k)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
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


            <div class="col-sm-2">
                <button class="btn global_btn_color" @@click="sumbitData()" data-index="7">Save</button>
                <form id="returnform" method="post" action="{{ route('moveToGoods') }}">
                    @csrf
                    <input type="hidden" id="returndata" name="data">
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
            grnNumber: {{$grnNumber}}
            , gnrDate: new Date().toISOString().slice(0, 10)
            , states: @json($states)
            , clients: []
            , warehouses: @json($warehouses)
            , client_name: ""
            , client_object: null
            , warehouse_object: @json($default_warehouse)
            , product_object: ""
            , state_object: ""
            , products: []
            , colors: []
            , color_object: ""
            , child: []
            , dummychild: []
            , pc_price: ""
            , totalq: ""
            , error: []
            , address: ""
            , plucksize: @json($plucksize),
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
          

            calData: function(data, k, product_id, color_id, qty, size_id, data_index, child_index) {
                vm = this;
                const wareData = JSON.stringify({
                    prod_id: product_id
                    , col_id: color_id
                    , qy: qty
                    , s_id: size_id
                    , warehouse_id: vm.warehouse_object.id
                });
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                axios.post("{{ url('/checkwarehouseqty') }}", wareData, config).then(res => {
                    console.log(res.data);
                    if (res.data.cqty < 0) {
                        vm.child[data_index].cs[child_index] = res.data.qty;
                        return toastr['success'](`Only  ${res.data.qty} Quantities available`, '', {
                            closeButton: true
                            , tapToDismiss: false
                            , progressBar: true
                        , });
                        total = 0;
                        for (i in vm.child[k].cs) {
                            total += parseInt(vm.child[k].cs[i]);
                        }
                        vm.child[k].totalq = total;
                        vm.child[k].total_price = total * vm.child[k].per_qty;
                    } else {
                        console.log(vm.child[data_index].cs[child_index]);
                        vm.child[data_index].cs[child_index] = res.data.qty - res.data.cqty;
                        total = 0;
                        for (i in vm.child[k].cs) {
                            total += parseInt(vm.child[k].cs[i]);
                        }
                        vm.child[k].totalq = total;
                        vm.child[k].total_price = total * vm.child[k].per_qty;
                    }
                });

            }
            , searchProduct(search, loading) {
                vm = this;

                if (search.length < 1) {
                    return;
                }
                vm.colors = [];
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
            , getColor: function(event) {
                vm = this;
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
            , total: function(item) {
                var sum = 0;
                for (i in item) {
                    var b = parseInt(item[i]);
                    if (!isNaN(b))
                        sum += parseInt(item[i]);
                }
                return sum;
            }
            , totalamt: function(item, total_amt) {
                var sum = 0;
                for (i in item) {
                    var b = parseInt(item[i]);
                    if (!isNaN(b))
                        sum += parseInt(item[i]);
                }
                return sum * total_amt
            }
            , getClient: function() {
                vm = this;
                vm.clients = [];
                axios.get(`{{ url('/getClient')}}/${vm.state_object.id}`).then(res => {
                    vm.clients = res.data.data;
                });
                vm.$refs.client.focus();

            },
            calculateAmount: function() {
                vm = this;
                vm.percent = vm.tax_object.percent;
                this.calculate();
            }
            , getThisClientDiscount: function() {
                // this.$refs.productSelect.open=true;
                this.$refs.productSelect.searchEl.focus();
                vm = this;
                vm.address = vm.client_object.billing_address;
                vm.commission = parseInt(vm.client_object.commissions.percent);

            }
            , searchEAN: function(e) {
                vm = this;

                if (vm.warehouse_object == null) {
                    return toastr['success']('Select Warehouse', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                }
                if (vm.typeEan.length == 13) {
                    $('#searchErrorMessage').text("");
                    const data = JSON.stringify({
                        warehouse_id: vm.warehouse_object.id
                        , product_ean: vm.typeEan
                        , picklist_master_id: vm.picklist_master_id
                    });
                    const config = {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }

                    axios.post("{{ url('/getDataBySearchh') }}", data, config).then(res => {
                        if (res.data.data.qty.qty == 0) {
                            return toastr['success'](`${res.data.data.qty.size.size} has 0 quantity`, '', {
                                closeButton: true
                                , tapToDismiss: false
                                , progressBar: true
                            , });
                        }
                        vm.color_id = res.data.data.product.color_id;
                        vm.product_object = {
                            id: res.data.data.product.product_master_id
                        };
                        var id = res.data.data.qty.size_id;
                        var cs = {};
                        for (k in vm.sizes) {
                            cs[vm.sizes[k].id] = vm.sizes[k].id == res.data.data.qty.size_id ? 1 : 0
                        }
                        if (vm.child.length > 0) {
                            var product = vm.child.filter(function(el) {
                                return el.color_id == vm.color_id && el.product_id == vm.product_object.id;
                            });

                            if (product.length > 0) {
                                let spl_key = []
                                for (const [key, val] of Object.entries(vm.child)) {
                                    if (val.product_name == product[0].product_name) {
                                        spl_key.push(key)
                                    }
                                }
                                if (parseInt(product[0].cs[res.data.data.qty.size_id]) < res.data.data.qty.qty) {
                                    vm.child[spl_key].cs[res.data.data.qty.size_id] = parseInt(product[0].cs[res.data.data.qty.size_id]) + 1;
                                    vm.child[spl_key].totalq = product[0].totalq + 1;
                                } else {
                                    return toastr['success'](`No Quantity left`, '', {
                                        closeButton: true
                                        , tapToDismiss: false
                                        , progressBar: true
                                    , });
                                }
                                vm.color_object = "";
                                vm.product_object = "";
                                vm.typeEan = "";

                            } else {

                                vm.child.push({
                                    "totalq": 1
                                    , 'product_id': res.data.data.product.product_master_id
                                    , 'product_name': res.data.data.product.parent.product_code
                                    , 'color_id': res.data.data.product.color_id
                                    , 'color_name': res.data.data.product.color.color_code,

                                    cs
                                });
                                vm.color_object = "";
                                vm.product_object = "";
                                vm.typeEan = "";

                            }
                        } else {
                            vm.child.push({
                                "totalq": 1
                                , 'product_id': res.data.data.product.product_master_id
                                , 'product_name': res.data.data.product.parent.product_code
                                , 'color_id': res.data.data.product.color_id
                                , 'color_name': res.data.data.product.color.color_code
                                , cs
                            });
                            vm.color_object = "";
                            vm.product_object = "";
                            vm.typeEan = "";

                        }
                    }).catch(error => {
                        toastr['success']('Product not found', '', {
                            closeButton: true
                            , tapToDismiss: false
                            , progressBar: true
                        , });
                        vm.color_object = "";
                        vm.product_object = "";
                        vm.typeEan = "";

                    });
                } else {
                    toastr['success']('EAN Should be 13 Digit', '', {
                            closeButton: true
                            , tapToDismiss: false
                            , progressBar: true
                        , });

                }

            },
            getColorObject: function() {
                vm = this;
           
                axios.get(`{{ url('/getProductColorPrice')}}/${vm.product_object.id}/${vm.color_object.color.id}}`).then(res => {
                    vm.pc_price = parseInt(res.data.data);
                })
                const nextField = document.getElementsByName("cutting_plans")[0];
                  nextField.focus();
            
            },
            updateTotal() {
                vm = this;
                var total = 0;
                var list = document.getElementsByClassName("cutting_plans");
                var values = [];
                for (var i = 0; i < list.length; ++i) {
                    values.push(list[i].value);
                }
                vm.sub(values);
            }
            , sub() {
                vm = this;
                var total = 0;
                for (var i in vm.sizes) {
                    total += parseInt(vm.sizes[i].value) ? parseInt(vm.sizes[i].value) : 0;
                }
                vm.totalq = total;
            }
            , toBottom() {
                vm = this;
                if (vm.warehouse_object == null) {
                    return toastr['success']('Select Warehouse', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                }
                if (vm.product_object.id != 0 && vm.color_object.color_id > 0) {
                    var cs = {};
                    var css = {};
                    for (k in vm.sizes) {
                        cs[vm.sizes[k].id] = vm.sizes[k].value ? parseInt(vm.sizes[k].value) : 0
                    }

                    if (vm.child.length > 0) {

                        var product = vm.child.filter(function(el) {
                            return el.color_id == vm.color_object.color.id && el.product_id == vm.product_object.id;
                        });

                        if (product.length > 0) {

                            vm.error = [];
                            for (k in vm.sizes) {
                                css[vm.sizes[k].id] = vm.sizes[k].value ? parseInt(vm.sizes[k].value) : 0
                            }
                            let totalqty = {};
                            for (let csskeys in css) {
                                totalqty[csskeys] = css[csskeys] + product[0].cs[csskeys];
                            }

                            let spl_key = []
                            for (const [key, val] of Object.entries(vm.child)) {
                                if (val.product_name == product[0].product_name) {
                                    spl_key.push(key)
                                }
                            }
                            var totalQTY = parseInt(vm.totalq) + parseInt(product[0].totalq);
                            vm.child[spl_key].cs = totalqty;
                            vm.child[spl_key].totalq = totalQTY;
                            

                            vm.totalq = 0;
                            for (k in vm.sizes) {
                                vm.sizes[k].value = 0;
                            }
                            vm.$refs.productSelect.searchEl.focus();


                        } else {
                            vm.error = [];
                            vm.child.push({
                                "totalq": vm.totalq
                                , 'product_id': vm.product_object.id
                                , 'product_name': vm.product_object.product_code
                                , 'color_id': vm.color_object.color.id
                                , 'color_name': vm.color_object.color.color_code
                                , cs
                                ,'defective':false,
                            });
                            vm.totalq = 0;
                            for (k in vm.sizes) {
                                vm.sizes[k].value = 0;
                            }
                            vm.$refs.productSelect.searchEl.focus();

                        }
                    } else {
                        vm.child.push({
                            "totalq": vm.totalq
                            , 'product_id': vm.product_object.id
                            , 'product_name': vm.product_object.product_code
                            , 'color_id': vm.color_object.color.id
                            , 'color_name': vm.color_object.color.color_code
                            , cs
                            ,'defective':false,
                        });
                        vm.totalq = 0;
                        for (k in vm.sizes) {
                            vm.sizes[k].value = 0;
                        }
                        vm.$refs.productSelect.searchEl.focus();


                    }
                }
            },
            sumbitData() {
                var vm = this;
                if (vm.child.length == 0) {
                    return toastr['success']('Fill all details', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                }
                var formData = {};
                formData.warehouse=vm.warehouse_object;
                formData.grnNumber = vm.grnNumber;
                formData.gnrDate = vm.gnrDate;
                formData.client_id = vm.client_object.id;
                formData.child = vm.child;
                vm.formData = JSON.stringify(formData);
                document.getElementById("returndata").value = vm.formData;
                document.getElementById("returnform").submit();

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
        },
    });


</script>
@endpush
