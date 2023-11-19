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
<div class="container" id="product_barcode">

    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Print Product Barcode</h4>
                        <a class="btn btn-sm global_btn_color" href="{{ url()->previous() }}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left">
                                <polyline points="11 17 6 12 11 7"></polyline>
                                <polyline points="18 17 13 12 18 7"></polyline>
                            </svg></a>

                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">

                <section id="input-mask-wrapper">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-12 col-md-6 col-sm-12 mb-2">
                                            <table class="title-form horizontaltable">
                                                <tbody style="">
                                                    <tr>
                                                        <td class="text-left">P Code</td>
                                                        <td class="text-color">C Code</td>
                                                        {{-- <td>Description</td> --}}
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
                                                        {{-- <td>Total</td> --}}
                                                        <td></td>

                                                    </tr>
                                                    <tr>
                                                        <td style="width:9rem;">
                                                            <v-select ref="productSelect" @@close="focusVSelect" label="product_code" :options="products" v-model="product_object" @@input="getColor" @@search="searchProducts"></v-select>

                                                        </td>
                                                        <td style="width:8rem;">
                                                            <input type="hidden" id="pro_code">
                                                            <select  ref="colorSelect" v-model="color_object" data-index="3" class="form-control" id="color_id" name="color_id" required  v-select2>
                                                                <option selected disabled></option>
                                                                <option v-for="color in colors" :value="color.color">
                                                                    @{{ color.color.color_code }}
                                                                </option>
                                                            </select>
                                                        </td>
                                                        {{-- <td>
                                                            <input type="text" name="product_description"
                                                                class="form-control" style="padding:0px !important; ">
                                                        </td> --}}
                                                        <td v-for="size in sizes">
                                                            <input type="number" name="cutting_plans" v-model="size.value" class="form-control input cutting_plans">
                                                        </td>
                                                        {{-- <td style="width:5rem;"><input type="number" name="sum"
                                                                id="total" class="form-control cuttingplantotal"
                                                                data-index="5" onkeydown="jumpNextField(event)">
                                                        </td> --}}
                                                        <td>
                                                            <button class="btn global_btn_color " @@click="toBottom()" ><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down">
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


        <section id="input-mask-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="row" id="table-head">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size:smaller;">
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
                                                        <td style="text-align:center;">Action</td>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    <tr  v-for="(c, k) in child" :key="k">
                                                        <td style="text-align:center;" class="tp"> @{{
                                                            c.product_name }} </td>
                                                        <td style="text-align:center;"  class="tp"> @{{
                                                            c.color_name }} </td>
                                                        
                                                        <td style="text-align:center;"  class="tp" v-for="s in sizes"> @{{
                                                            c.cs[s.id] }} </td>

                                                        <td style="text-align:center;"><a class="btn btn-sm btn-danger" href="javascript:void(0)" @@click="deleteData(k)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
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
        <button class="btn global_btn_color" @@click="sumbitData()" data-index="7">Print</button>

        <form id="mainform" method="post" action="{{ route('moveToQuantity') }}">
            @csrf
            <input type="hidden" id="formdata" name="data">

        </form>
    </section>
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
        el: '#product_barcode',
        data: {
            sizes: @json($sizes)
             ,current_total:0
            , product_object: ""
            , products: []
            , colors: []
            , color_object: ""
            , totalq: 0
            , child: []
        , },

        methods: {
            focusVSelect:function(){
                vm=this;
                vm.$refs.colorSelect.focus();
            },

            getColor: function() {
                vm = this;
                axios.get(`{{ url('/getColorId/') }}/${vm.product_object.id}`).then(res => {

                    vm.colors = res.data.data;
                })
            }
            , searchProducts(search, loading) {
                vm = this;
                if (search.length < 1) {
                    return;
                }
                axios.get(`{{ url('/getSearchProduct') }}/${search}`).then(res => {
                    vm.products = res.data.data;
                });
            }
            , toBottom() {
                var vm = this;
                if (vm.product_object == "") {
                    return toastr['success']('Select Product', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                }
                if (vm.color_object == "") {
                    return toastr['success']('Select Color', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                }
               
                if (vm.product_object.id != 0 ) {
                    var cs = {};
                    var css = {};
                    for (k in vm.sizes) {
                        cs[vm.sizes[k].id] = vm.sizes[k].value ? vm.sizes[k].value : 0;
                        vm.current_total += vm.sizes[k].value ? parseInt(vm.sizes[k].value) : 0;
                    }

                    if (vm.current_total == 0) {
                    return toastr['success']('Please fill the atleast 1 quantity.', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                }



                    if (vm.child.length > 0) {
                        var product = vm.child.filter(function(el) {
                            return el.color_id == vm.color_object.id && el.product_id == vm.product_object.id;
                        });

                        if (product.length > 0) {
                            vm.error = [];
                            for (k in vm.sizes) {
                                css[vm.sizes[k].id] = vm.sizes[k].value ? parseInt(vm.sizes[k].value) : 0
                            }
                            let totalqty = {};
                            for (let csskeys in css) {
                                totalqty[csskeys] = parseInt(css[csskeys]) + parseInt(product[0].cs[csskeys]);
                            }
                            let spl_key = []
                            for (const [key, val] of Object.entries(vm.child)) {
                                if (val.product_name == product[0].product_name) {
                                    spl_key.push(key)
                                }
                            }
                            vm.child[spl_key].cs = totalqty;
                            vm.totalq = 0;
                            vm.current_total = 0;
                            for (k in vm.sizes) {
                                vm.sizes[k].value = 0;
                            }
                            vm.$refs.productSelect.searchEl.focus();

                        } else {
                            vm.child.push({
                                'product_id': vm.product_object.id
                                , 'product_name': vm.product_object.product_code
                                , 'color_id': vm.color_object.id
                                , 'color_name': vm.color_object.color_code
                                , cs
                            , });
                            vm.totalq = 0;
                            vm.current_total = 0;
                            for (k in vm.sizes) {
                                vm.sizes[k].value = 0;
                            }
                            vm.$refs.productSelect.searchEl.focus();


                        }
                    } else {
                        vm.child.push({
                            'product_id': vm.product_object.id
                            , 'product_name': vm.product_object.product_code
                            , 'color_id': vm.color_object.id
                            , 'color_name': vm.color_object.color_code
                            , cs
                        , });
                        vm.totalq = 0;
                        vm.current_total = 0;
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


        }
        , computed: {

        },
        mounted() 
        {
            this.$refs.productSelect.searchEl.focus();

        }
        , watch: {}
    })

</script>



@endpush
