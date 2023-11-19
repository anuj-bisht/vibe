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
</style>
<div class="container" id='customer_invoice'>

    <!-- Invoice -->
    <div class="col-xl-12 col-md-12 col-12">
        <div class="card invoice-preview-card">
            <div class="card-body invoice-padding pb-0">
                <div class="row">
                    <div class="col-md-2">
                        <h4 class="invoice-title">
                            Invoice No.
                            <span class="invoice-number"> 1</span>
                        </h4>
                    </div>
                    <div class="col-md-7" style="text-align:center;">
                        <div class="logo-wrapper">
                            <img style="max-width:140px;"
                                src="https://vibecode.paramsoft.co.in/public/masters/img/logo.png" alt="">
                        </div>
                    </div>
                    <div class="col-md-3">

                        <p class="invoice-date-title">Date Issued: @{{ invoiceDate }}</p>

                    </div>
                </div>

            </div>

            <hr class="invoice-spacing" />

            <!-- Address and Contact starts -->
            <div class="card-body invoice-padding pt-0">
                <div class="row invoice-spacing">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="city-column" style="color:black; ">Search Customer No.</label>
                            <select class="form-control " data-index="1" id="customer_id" name="customer_id" required
                                v-model="customer_no" v-select2>
                                <option disabled selected value="">Type Phone No.</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Address and Contact ends -->
        </div>
    </div>
    <!-- /Invoice -->


    <!-- Invoice -->
    <div class="col-xl-12 col-md-12 col-12">
        <div class="card invoice-preview-card">


            <div id="ean" class="row">
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <input class="form-control input" type="text" placeholder="Search Ean" data-search="search"
                                v-model="typeEan" id="ean_no" @@input="searchEAN(this)">
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
                                                        <v-select label="product_code" :options="products"
                                                            v-model="product_object" @@input="getColor"
                                                            @@search="searchProduct"></v-select>
                                                    </td>
                                                    <td style="width:8rem;">
                                                        <input type="hidden" id="pro_code">
                                                        <select data-index="3" class="form-control" id="color"
                                                            v-model="color_object" name="color_id" required
                                                            @@change="getMrp" v-select2>
                                                            <option selected disabled></option>
                                                            <option v-for="color in colors" :value="color"> @{{
                                                                color.color.color_code }}

                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td v-for="(size, k) in sizes" :key="k">
                                                        <input type="number" name="cutting_plans" v-model="size.value"
                                                            class="form-control input retailqty"
                                                            style="padding:0px !important;"
                                                            @@change='changeTotal(k)'>
                                                    </td>

                                                    <td style="width:5rem;"><input readonly v-model="totalq"
                                                            type="number" name="sum" id="total"
                                                            class="form-control cuttingplantotal" data-index="5"> @{{
                                                        updateTotal() }}
                                                    </td>
                                                    <td>
                                                        <button class="btn global_btn_color " @@click="toBottom()"
                                                            data-index="6"><svg xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-arrow-down">
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

            <section id="input-mask-wrapper">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row" id="table-head">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="table-responsive">
                                                <table class="table table-bordered" id="dataTable" width="100%"
                                                    cellspacing="0" style="">
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
                                                            <td style="text-align:center;" class="tp"> @{{
                                                                c.product_name }} </td>
                                                            <td style="text-align:center;" class="tp"> @{{ c.color_name
                                                                }} </td>
                                                            <td style='text-align:center;' class="tp"
                                                                v-for="(s,j) in c.cs"><span
                                                                    v-if="child[k].cs[j].err != ''"
                                                                    style="color:red;">@{{child[k].cs[j].err}}</span><input
                                                                    @@change="calData(child[k],k,c.product_id,c.color_id,child[k].cs[j],j,k,j)"
                                                                    style="width:35px; border:none;" type="number"
                                                                    name="" id="" v-model="child[k].cs[j]">
                                                            </td>
                                                            <td style="text-align:center;" class="tp">@{{ c.totalq }}
                                                            </td>
                                                            <td style="text-align:center;" class="tp">@{{ c.per_qty }}
                                                            </td>
                                                            <td style="text-align:center;" class="tp">@{{ c.total_price
                                                                }}</td>
                                                            <td style="paddng:0.75px !important"><a
                                                                    class="btn btn-sm btn-danger"
                                                                    href="javascript:void(0)"
                                                                    @@click="deleteData(k)"><svg
                                                                        xmlns="http://www.w3.org/2000/svg" width="24"
                                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="2"
                                                                        stroke-linecap="round" stroke-linejoin="round"
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

                    <div class="col-sm-1" v-if="child.length > 0">@{{parseFloat(subTotal).toFixed()}}</div>

                </div>

                {{-- <div class="row pt-1" style="align-items:center;">

                    <div class="col-sm-9" style="text-align: end;">Discount:</div>

                    <div class="col-sm-2"><select class="form-control " id="discount" @@change="calculatediscount"
                            name="discount" data-index="3" v-model="discount" v-select2>

                            <option disabled selected value="">Discount</option>

                            <option v-for="discount in discounts" :value="discount.percent">@{{discount.percent}}
                            </option>

                        </select>
                    </div>

                    <div class="col-sm-1" v-if="child.length > 0">@{{parseFloat(amtafterdiscount).toFixed(2)}}</div>

                </div> --}}

                {{-- <div class="row pt-1" style="align-items:center;">

                    <div class="col-sm-9" style="text-align:end;">Tax:</div>

                    <div class="col-sm-2"><select class="form-control " id="tax" name="tax" data-index="3"
                            v-model="tax_object" v-select2 @@change="calculateAmount">

                            <option disabled selected value="">Select Tax</option>

                            <option v-for="tax in taxes" :value="tax"> @{{ tax.name }} - @{{ tax.percent }}</option>

                        </select>
                    </div>

                    <div class="col-sm-1" v-if="child.length > 0">@{{parseFloat(tax_amt).toFixed(2)}}</div>

                </div> --}}

                {{--
                <hr style="border:0.5px solid; margin-left:65%;">



                <div class="row pt-1" style="align-items: center; font-weight:600">

                    <div class="col-sm-9" style="text-align: end;">Grant Total:</div>

                    <div class="col-sm-2"></div>

                    <div class="col-sm-1" v-if="child.length > 0">@{{parseFloat(afterWholeCalc).toFixed(2)}}</div>

                </div>

            </div> --}}





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
        el: '#customer_invoice',
         data: {
            invoiceDate: new Date().toISOString().slice(0, 10)
            , customer_no: ""
            , sizes: @json($sizes)
            , typeEan: ""
            , product_object: ""
            , color_object: ""
            , products: []
            , colors: []
            , product_mrp: ""
            , totalq: ""
            , child: []
            , subTotal: 0,




        },

        methods: {
            searchProduct(search, loading) {
                vm = this;

                if (search.length < 1) {
                    return;
                }
                vm.colors = [];

                const data = JSON.stringify({
                    srch: search
                });
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                axios.post("{{ url('/getRetailProduct') }}", data, config).then(res => {
                    vm.products = res.data.data;
                })

            },

            calc_sub_total: function() {
                vm = this;
                subtotal = 0;
                for (i in vm.child) {
                    subtotal += vm.child[i].total_price;
                }
                vm.subTotal = subtotal;
            },

            getColor: function(event) {
                vm = this;
                const data = JSON.stringify({
                    p_id: vm.product_object.id
                });
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                axios.post("{{ url('/getRetailProductColor') }}", data, config).then(res => {
                    vm.colors = res.data.data;
                })
            },
            getMrp: function() {
                vm = this;

                const data = JSON.stringify({
                    p_id: vm.product_object.id
                    , c_id: vm.color_object.color.id
                , });
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                axios.post("{{ url('/getRetailProductColorMrp') }}", data, config).then(res => {
                    vm.product_mrp = parseInt(res.data.data);
                })
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
            , sub(arr) {
                vm = this;
                var values = $.grep(arr, n => n == ' ' || n)
                var total = 0;
                for (var i in values) {
                    total += parseInt(values[i]);
                }
                vm.totalq = total;
                
            },
            searchEAN: function(e) {
                vm = this;
                if (vm.typeEan.length == 12) {
                    $('#searchErrorMessage').text("");
                    const data = JSON.stringify({
                        product_ean: vm.typeEan,
                    });
                    const config = {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }
                    axios.post("{{ url('/getQtyByRetailSearch') }}", data, config).then(res => {
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
                                    vm.child[spl_key].total_price = vm.child[spl_key].totalq * product[0].per_qty;
                                } else {
                                    return toastr['success'](`No Quantity left`, '', {
                                        closeButton: true
                                        , tapToDismiss: false
                                        , progressBar: true
                                    , });
                                }
                                this.calc_sub_total();
                                vm.color_object = "";
                                vm.product_object = "";
                            } else {

                                //   var product_commission=(parseInt(res.data.data.product.mrp)*vm.margin_percent)/100;
                                var p_rate = parseInt(res.data.data.product.mrp);
                                vm.child.push({
                                    "totalq": 1
                                    , 'product_id': res.data.data.product.product_master_id
                                    , 'product_name': res.data.data.product.parent.product_code
                                    , 'color_id': res.data.data.product.color_id
                                    , 'color_name': res.data.data.product.color.color_code
                                    , 'per_qty': p_rate
                                    , 'total_price': p_rate
                                    , cs
                                });
                                this.calc_sub_total();
                                vm.color_object = "";
                                vm.product_object = "";
                            }
                        } else {


                            var p_rate = parseInt(res.data.data.product.mrp);
                            vm.child.push({
                                "totalq": 1
                                , 'product_id': res.data.data.product.product_master_id
                                , 'product_name': res.data.data.product.parent.product_code
                                , 'color_id': res.data.data.product.color_id
                                , 'color_name': res.data.data.product.color.color_code
                                , 'per_qty': p_rate
                                , 'total_price': p_rate
                                , cs
                            });
                            this.calc_sub_total();
                            vm.color_object = "";
                            vm.product_object = "";

                        }
                    }).catch(error => {
                        toastr['success']('Product not found', '', {
                            closeButton: true
                            , tapToDismiss: false
                            , progressBar: true
                        , });
                        vm.color_object = "";
                        vm.product_object = "";
                    });
                } else {
                    toastr['success']('EAN Should be 12 Digit', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });

                }
                vm.typeEan = "";

            },

            toBottom() {

                vm = this;
                for( k in vm.sizes){
                    if(vm.sizes[k].isloading){
                        toastr['success'](` Loading `, '', {
                                                                            closeButton: true
                                                                            , tapToDismiss: false
                                                                            , progressBar: true
                                                                        , });
                                              
                        return;
                    }
                }
                if (vm.product_object.id != 0 && vm.color_object.color_id > 0) {
                    var cs = {};
                    var css = {};
                    for (k in vm.sizes) {
                        cs[vm.sizes[k].id] = vm.sizes[k].value ? parseInt(vm.sizes[k].value) : 0
                    }
                    //    const obj = {warehouse_id:vm.warehouse_object.id, invoice_product_id: vm.product_object.id, color_id:vm.color_object.color.id,picklist_master_id:vm.picklist_master_id}
                    //     const options = {
                    //     headers: {'X-Custom-Header': 'value'}
                    //   };
                    // axios.post(`{{ url('/checkquantity')}}`,obj)
                    //   .then(response => {
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


                            //  let difference={};
                            //     for(let key in response.data.data){
                            //       difference[key]=response.data.data[key] - totalqty[key]
                            //     }
                            //  let hasNegativeValue=false;
                            //     for(const val of Object.values(difference)){
                            //       if(val < 0){
                            //         hasNegativeValue=true;
                            //         break;
                            //       }
                            //     }
                            // if(hasNegativeValue){
                            //   let qt = {};
                            //     for(let key in product[0].cs){
                            //     qt[key]=response.data.data[key] - product[0].cs[key]
                            //     }
                            //     let negativeKeys=[];
                            //     for(const [key , value] of Object.entries(difference)){
                            //       if(value < 0){
                            //         negativeKeys.push(key);
                            //       }
                            //     }
                            //     for(const val of negativeKeys){
                            //       vm.error.push(`${vm.plucksize[val]} has ${qt[val]} Qty`);

                            //     }   
                            // }else{
                            let spl_key = []
                            for (const [key, val] of Object.entries(vm.child)) {
                                if (val.product_name == product[0].product_name) {
                                    spl_key.push(key)
                                }
                            }
                            var totalQTY = parseInt(vm.totalq) + parseInt(product[0].totalq);
                            vm.child[spl_key].cs = totalqty;
                            vm.child[spl_key].totalq = totalQTY;
                            vm.child[spl_key].total_price = totalQTY * product[0].per_qty;

                            vm.totalq = 0;
                            for (k in vm.sizes) {
                                vm.sizes[k].value = 0;
                            }
                            this.calc_sub_total();

                            // }

                        } else {
                            //   vm.error=[];
                            // let difference={};
                            // for(let key in response.data.data){
                            //   difference[key]=response.data.data[key] - cs[key]
                            // }
                            // let hasNegativeValue=false;
                            // for(const val of Object.values(difference)){
                            //   if(val < 0){
                            //     hasNegativeValue=true;
                            //     break;
                            //   }
                            // }
                            // if(hasNegativeValue){
                            //     let negativeKeys=[];
                            //     for(const [key , value] of Object.entries(difference)){
                            //       if(value < 0){
                            //         negativeKeys.push(key);
                            //       }
                            //     }
                            //     return console.log(negativeKeys);
                            //     for(const val of negativeKeys){
                            //       vm.error.push(`${vm.plucksize[val]} has ${response.data.data[val]} Qty`);

                            //     }
                            // }
                            // else{

                            vm.child.push({
                                "totalq": vm.totalq
                                , 'product_id': vm.product_object.id
                                , 'product_name': vm.product_object.product_code
                                , 'color_id': vm.color_object.color.id
                                , 'color_name': vm.color_object.color.color_code
                                , 'per_qty': vm.product_mrp
                                , 'total_price': vm.totalq * vm.product_mrp
                                , cs
                            , });

                            vm.totalq = 0;
                            for (k in vm.sizes) {
                                vm.sizes[k].value = 0;
                            }
                            this.calc_sub_total();

                            // }
                        }
                    } else {
                      
                        vm.child.push({
                            "totalq": vm.totalq
                            , 'product_id': vm.product_object.id
                            , 'product_name': vm.product_object.product_code
                            , 'color_id': vm.color_object.color.id
                            , 'color_name': vm.color_object.color.color_code
                            , 'per_qty': vm.product_mrp
                            , 'total_price': vm.totalq * vm.product_mrp
                            , cs
                        , });
                        vm.totalq = 0;
                        for (k in vm.sizes) {
                            vm.sizes[k].value = 0;
                        }
                        this.calc_sub_total();

                    }
           
                }
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
                            prod_id: vm.product_object.id
                            , col_id: vm.color_object.color_id
                            , qy: vm.sizes[sizes_key].value
                            , s_id: vm.sizes[sizes_key].id
                            , warehouse_id: 0
                        });
                if (vm.child.length > 0) {
                    var product = vm.child.filter(function(el) {
                        return el.color_id == vm.color_object.color_id && el.product_id == vm.product_object.id;
                    });
                 
                    if (product.length > 0) {

                       var totalqty= product[0].cs[vm.sizes[sizes_key].id];

                        axios.post("{{ url('/checkwarehouseqty') }}", wareData, config).then(res => {
                            if((totalqty + vm.sizes[sizes_key].value) > res.data.qty ){
                                var cqty= res.data.qty-totalqty;
                                vm.sizes[sizes_key].value= cqty;
                                toastr['success'](`Only  ${cqty} Quantities available`, '', {
                                                                            closeButton: true
                                                                            , tapToDismiss: false
                                                                            , progressBar: true
                                                                        , });
                                                                        vm.$forceUpdate();

                            }
                            vm.sizes[sizes_key].isloading= false;
                            // vm.upsub();
                        });
                        // vm.updateTotal();
                        return ;

                    }
                }
                axios.post("{{ url('/checkwarehouseqty') }}", wareData, config).then(res => {
                        if (res.data.cqty < 0) {
                            toastr['success'](`Only  ${res.data.qty} Quantities available`, '', {
                                closeButton: true
                                , tapToDismiss: false
                                , progressBar: true
                            , });
                            vm.sizes[sizes_key].value = res.data.qty;
                            vm.$forceUpdate();
                        }
                        // vm.upsub();
                        vm.sizes[sizes_key].isloading= false;
                    });
                    
            },

            // upsub() {
            //     vm = this;
            //     var total = 0;
            //     for (var i in vm.sizes) {
            //         total += parseInt(vm.sizes[i].value) ? parseInt(vm.sizes[i].value) : 0;
            //     }
            //     vm.totalq = total;
            // },

            

            deleteData(k) {
                this.child.splice(k, 1)
            }


        },

    })




    $(document).ready(function() {
        $('#customer_id').select2({
            ajax: {
                url: "{{route('retail.customer.search')}}"
                , dataType: 'json'
                , delay: 250
                , data: function(params) {
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                }
                , processResults: function(data, params) {
                    // parse the results into the format expected by Select2
                    // since we are using custom formatting functions we do not need to
                    // alter the remote JSON data, except to indicate that infinite
                    // scrolling can be used
                    params.page = params.page || 1;

                    return {
                        results: data.items
                        , pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                }
                , cache: true
            }
            , placeholder: 'Search for a repository'
            , minimumInputLength: 1
            , templateResult: formatRepo
            , templateSelection: formatRepoSelection
        });

        function formatRepo(repo) {

            if (repo.loading) {
                return repo;
            }

            if (repo.is_create !== undefined) {


                var $container = $(
                    "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__meta'>" +
                    "<a class='select2-result-btn__name btn btn-primary' href='{{route('customer.create')}}'>Add</a>" +
                    "</div>" +
                    "</div>"
                );

                $container.find(".select2-result-btn__name").append(repo.name);

            } else {
                var $container = $(
                    "<div class='select2-result-repository clearfix'>" +
                    "<div class='select2-result-repository__meta'>" +
                    "<div class='select2-result-repository__name'></div>" +
                    "<div class='select2-result-repository__title'></div>" +
                    "</div>" +
                    "</div>"
                );

                $container.find(".select2-result-repository__name").append(repo.name);
                $container.find(".select2-result-repository__title").text(repo.country.name + ',' + repo.state.name + ',' + repo.city.name);


            }








            return $container;
        }

        function formatRepoSelection(repo) {
            return repo.name
        }
    });

</script>
@endpush