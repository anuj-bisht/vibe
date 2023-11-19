@extends('retail.layouts.app')
@section('retail_content')
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

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

    .select2-dropdown--above {
        z-index: 9
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
                        <p class="invoice-date-title">Date Issued: @{{ new Date(invoiceDate).toLocaleDateString() }}</p>
                    </div>
                </div>
            </div>

            <hr class="invoice-spacing" />

            <!-- Address and Contact starts -->
            <div class="card-body invoice-padding pt-0">
                <div class="row invoice-spacing">
                    <div class="col-md-4 col-12">
                        <div class="form-group">
                            <label for="city-column" style="color:black; ">Customer Name.</label>
                           <input type="text" class="form-control" value="Customer 1 " readonly />
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
                                                            style="padding:0px !important;" @@change='changeTotal(k)'>
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
                                                                    style="color:red;">@{{child[k].cs[j].err}}</span>
                                                                    <input readonly
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

<div class="col-sm-2 pt-1">
    <button class="btn global_btn_color" @@click="sumbitData()" data-index="7">Save</button>
    <form id="consumerreturnform" method="post" action="{{ route('moveToCustomerInvoiceGoodReturn') }}">
        @csrf
        <input type="hidden" id="consumerreturndata" name="data">

    </form>
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
            // invoiceDate: new Date().toISOString().slice(0, 10)
            invoiceDate:"{{$data->date}}",
            invoiceNumber:"{{$data->invoice_no}}",
            customer_no: "{{ $data->customer_id }}",
            sizes: @json($sizes),
            typeEan: "",
            product_object: "",
            color_object: "",
             products: [],
             colors: [],
             product_mrp: "",
             totalq: "",
             child: [],
             subTotal: 0,
            formData:"",
            invoice_id:{{$id}},
            first_order : 0,
        },

        methods: {
            searchProduct(search, loading) {
                vm = this;

                if (search.length < 1) {
                    return;
                }
                vm.colors = [];

                const data = JSON.stringify({
                    invoice_id: vm.invoice_id,
                    srch: search
                });
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                axios.post("{{ url('/getConsumerInvoiceProduct') }}", data, config).then(res => {
                    vm.products = res.data.data;
                })

            },

            getColor: function(event) {
                vm = this;
                const data = JSON.stringify({
                    invoice_id: vm.invoice_id,
                    p_id: vm.product_object.id
                });
                const config = {
                    headers: {
                        'Content-Type': 'application/json'
                    }
                }
                axios.post("{{ url('/getConsumerInvoiceProductColor') }}", data, config).then(res => {
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
                        invoice_id:vm.invoice_id
                    });
                    const config = {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    }
                    axios.post("{{ url('/getQtyByConsumerInvoiceSearch') }}", data, config).then(res => {
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
                                vm.color_object = "";
                                vm.product_object = "";
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
                            vm.child[spl_key].total_price = totalQTY * product[0].per_qty;

                            vm.totalq = 0;
                            for (k in vm.sizes) {
                                vm.sizes[k].value = 0;
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
                    }
           
                }
            },
            sumbitData() {
              var vm = this;
              if(vm.child.length == 0 && vm.customer_no == ""){
                 return toastr['success']('Fill all details', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                }
              var formData = {};
              formData.invoiceNumber = vm.invoiceNumber;
              formData.customer_id = vm.customer_no;
              formData.customer_invoice_master_id = vm.invoice_id;
              formData.total_pcs = vm.itotalq;
              formData.child=vm.child;
              vm.formData = JSON.stringify(formData);
              document.getElementById("consumerreturndata").value = vm.formData;
              document.getElementById("consumerreturnform").submit();

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
                            invoice_id:vm.invoice_id,
                            prod_id: vm.product_object.id,
                            col_id: vm.color_object.color_id,
                            qy: vm.sizes[sizes_key].value,
                            s_id: vm.sizes[sizes_key].id
                            
                        });
                if (vm.child.length > 0) {
                    var product = vm.child.filter(function(el) {
                        return el.color_id == vm.color_object.color_id && el.product_id == vm.product_object.id;
                    });
                 
                    if (product.length > 0) {

                       var totalqty= product[0].cs[vm.sizes[sizes_key].id];

                        axios.post("{{ url('/checkconsumerinvoiceqty') }}", wareData, config).then(res => {
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
                        });
                        return ;

                    }
                }
                axios.post("{{ url('/checkconsumerinvoiceqty') }}", wareData, config).then(res => {
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

            deleteData(k) {
                this.child.splice(k, 1)
            }
        },
    })

</script>
@endpush