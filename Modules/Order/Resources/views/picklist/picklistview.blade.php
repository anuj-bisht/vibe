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
<div class="container">
    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" >Pickist Detail</h4>

                        <a href="{{route('pick.index')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
                    </div>

                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h6>Warehouse : &nbsp;{{ $picklist->warehouse->name }}</h6>
                        <h6>Client Name : &nbsp;{{ $picklist->corporate_profiles->name }}</h6>
                        <h6>Order No : &nbsp;{{ $picklist->order_master->ord_id }}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 col-md-2 col-sm-6 col-6">
                <a href="javascript:void(0)"
                    class="{{ $picklist->status == 0 ? 'btn btn-sm btn-danger' : 'btn btn-sm btn-success' }}">{{
                    $picklist->status == 0 ? 'Not Validated' : 'Validated' }}</a>
            </div>
        </div>
        @if ($errors->any())
        <h4>{{ $errors->first() }}</h4>
        @endif
        {!! Session::has('msg') ? Session::get('msg') : '' !!}

        
<div class="container" id="view_picklist">
    <section id="basic-input">

        <div class="row" id="table-head">
            <div class="col-12">
                <div class="card">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="">
                        <thead class="">
                            <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                                <th>P Code</th>
                                <th>C Code</th>
                                @foreach ($sizes as $size)
                                <th style=" text-align:center;">
                                    <?php
                                        $str = explode('/', $size->size);
                                        $a = $str[0] ?? '';
                                        $b = $str[1] ?? '';
                                        echo "$a<br>$b";
                                        ?>
                                </th>
                                @endforeach
                                <th>Total Qty</th>
                                @if ($picklist->status == 0)
                                <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            <tr id="" v-for="(c, k) in data" :key="k">
                                <td class="tp" style="padding:0.75rem !important;"> @{{ c.product.product_code }} </td>
                                <td class="tp" style="padding:0.75rem !important;"> @{{ c.color.color_code }} </td>
                                <td class="tp" v-for="(s,j) in c.child" style="padding:0.75rem !important;"><span
                                        v-if="data[k].child[j].err != '' && data[k].child[j].err == data[k].child[j].qty"
                                        style="color:red;">@{{data[k].child[j].err}}</span><input
                                        style="width:35px; border:none;" type="number" name="" id=""
                                        v-model="data[k].child[j].qty"
                                        @@change="checkqty( c.product_id,c.color_id,c.picklist_master_id,data[k].child[j].qty, data[k].child[j].size_id, k,j)">
                                </td>
                                <td class="tp" style="padding:0.75rem !important;">@{{ c.total }}</td>
                                @if ($picklist->status == 0)
                                <td style="paddng:0px !important">
                                    <a class="btn btn-sm btn-success" href="javascript:void(0)"
                                        @@click="updateData(data[k])">
                                        Save
                                    </a>
                                </td>
                                @endif

                            </tr>
                        </tbody>
                    </table>

                </div>
                @if ($picklist->status == 0)
                <a class="btn global_btn_color" type="button"
                    href="{{ route('store.picklist.validator', ['id' => $picklist->id]) }}">Validate</a>
                @endif
            </div>
        </div>
    </section>
</div>


@endsection


@push('scripts')
<script>
    var app = new Vue({
        el: '#view_picklist',
        data: {
            sizes: @json($sizes),
            data:@json($picklist->detail),
            err:"",
        },
      
        methods: {
           
            checkqty:function(product_id,color_id, picklist_master_id, qty, size_id,data_index,child_index){
                vm=this;
                console.log(vm.data[data_index].child[child_index]);
               
                const data = JSON.stringify({ 
                        prod_id:product_id,
                        col_id : color_id,
                        pick_mas_id: picklist_master_id,
                        qy:qty,
                        s_id:size_id
                });
                const config = {
                    headers: {'Content-Type': 'application/json'}
                }

                axios.post("{{ url('/checkqty') }}", data,config).then(res => {
                    console.log(res.data);
                    if(res.data.cqty < 0){
                        vm.data[data_index].child[child_index].qty = res.data.qty;
                        vm.data[data_index].child[child_index].err = res.data.qty;
                    }else{
                        vm.data[data_index].child[child_index].qty = res.data.qty-res.data.cqty;
                        vm.data[data_index].child[child_index].err = '';
                    }
                });
            }, 
            updateData(dataAttr){
                vm=this;
                const config = {
                    headers: {'Content-Type': 'application/json'}
                }
                var obj={}
                dataAttr.child.map((el)=>{
                    obj[el.size_id]=el.qty;
                });   
                const data = JSON.stringify({ 
                         'attr':dataAttr,
                         'ob':obj
                });
                axios.post("{{ route('update.picklistAttribute') }}", data,config).then(res => {
                    return   toastr['info'](`Picklist Update `, '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                }).catch(error => {
                  toastr['success']('this Product not found in warehouse ', '', {
                    closeButton: true,
                    tapToDismiss: false,
                    progressBar: true,
                  });
                 
                          });
            }
        },
        created() {
           
        }
       
       
    })

        

       
   

</script>
@endpush