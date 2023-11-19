


@extends('layouts.app')
@include('styles.style')
@section('content')
<style>

    .select2-container--default .select2-search--inline .select2-search__field{
        display:none !important;

    }
    </style>
        <section >
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Stock</h4>
                            <a class="btn global_btn_color" href="{{route('export.product')}}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>Add Stock</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div class="row" id="table-head">
            <div class="col-12">
                @if($errors->any())
                <p class="alert alert-danger alert-heading">{{$errors->first()}}</p>
                @endif
                @if(Session::has('message'))
                <p class="alert alert-success alert-heading">{{ Session::get('message') }}</p>
                @endif

                <div class="container-fluid" >
                    <section id="">
                        <div class="row">
                                    <div class="col-md-3">
                                        <label for="">Select Warehouse</label>
                                        <select class=" form-control" data-index="1"  id="warehouse" name="warehouse" >
                                          
                                            @foreach($all_warehouse as $warehouse)
                                            <option value="{{ $warehouse->id }}" {{ $select== $warehouse->id? "selected": "" }}>{{ $warehouse->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Main Category</label>
                                        <select class="form-control " id="main_category" name="main_category"  onchange="getCategory(this)">
                                            <option disabled data-set="1" selected>Select</option>
                                            @foreach($main_category as $mainCategory)
                                            <option value={{$mainCategory->id}}>{{$mainCategory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Category</label>
                                        <select class="form-control"  id="category" multiple="multiple" name="category[]" onchange="getSubCategory(this)" >
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label> Sub Category</label>
                                        <select class="form-control " id="subcategory" multiple="multiple" name="subcategory[]" onchange="getSubSubCategory(this)">
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label> Sub Sub Category</label>
                                        <select class="form-control " id="subsubcategory" multiple="multiple" name="subsubcategory[]">
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label> Fit</label>
                                        <select class="form-control" id="fit" name="fit" >
                                            <option disabled data-set="1" selected>Select</option>
                                            @foreach($fits as $fit)
                                            <option value={{$fit->id}}>{{$fit->code}}</option>
                                            @endforeach
                                        </select>
                                    </div>
    
                            <div class="col-md-3">
    
                                <div class="card-header" style="background: #F8F8F8; border: none;">
                                    <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                                    <button type="button" name="refresh" id="refresh" class="btn btn-primary">Reset</button>
                                </div>
    
                            </div>
                        </div>
                    </section>
                </div>

               <div class="card">
                   
                    <div class="card-datatable">
                        <div class="table-responsive">

                        <table class="table table-bordered" id="getEmployees" width="100%" cellspacing="0" style="">
                            <thead class="">
                               <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                                    {{-- <th>S. no</th> --}}
                                    <th>Product Code</th>
                                    <th>Color Code</th>
                                    @foreach($sizes as $size)
                                    <th style="text-align:center;">
                                      <?php
                                                               $str=explode('/',$size->size);
                                                               $a=$str[0]??'';
                                                               $b=$str[1]??'';
                                                               echo "$a<br>$b";
                                                                ?>
                                    </th>
                                    @endforeach
                                    <th>Total Qty.</th>
                                    <th>Rate</th>
                                    <th>Total Amt</th>
                                    <th>Action</th>
                               </tr>
                            </thead>
                         </table>
                        </div>
                    </div>
               </div>
            </div>
         </div>   
</div>

@endsection
@push('scripts')
<script>
      $(function() {
        load_data();

        function load_data() {
            var table = $('#getEmployees').DataTable({
                order: [
                    [1, "desc"]
                ],
                processing: true,
                serverSide: true,
                searchable : true,
                ajax: {
                url: "{!! route('warehouse.list') !!}",

                 data: {
                        warehouse_id: $('#warehouse').find(':selected').val(),
                        main_category: $('#main_category').find(':selected').val(),
                        category: $('#category').val(),
                        sub_category:  $('#subcategory').val(),
                        sub_sub_category:  $('#subsubcategory').val(),
                        fit: $('#fit').find(':selected').val(),
                     }
                    },
                columns: [
                    // {
                    //     data: 'DT_RowIndex'
                    // },
                    {
                        data: '_p_code'
                    },
                    {
                        data: 'color_code'
                    },
                    {
                        data: '_26'
                    },
                    {
                        data: '_28'
                    },
                    {
                        data: '_30'
                    },
                    {
                        data: '_32'
                    },
                    {
                        data: '_S34'
                    },
                    {
                        data: '_M36'
                    },
                    {
                        data: '_L38'
                    },
                    {
                        data: '_XL40'
                    },
                    {
                        data: '_XXL42'
                    },
                    {
                        data: '_XXXL44'
                    },
                    {
                        data: '_46'
                    },
                    {
                        data: '_48'
                    },
                    {
                        data: 'sum'
                    },
                    {
                        data: '_rate'
                    },
                    {
                        data: '_total_amt'
                    },
                    {
                        data: 'action',

                    },
                 
                ],
                dom: 'fBrtip',
                buttons: [
                     'csv', 'excel', 'pdf'
                ]
            });
        }

        $('#filter').click(function() {
            var warehouse = $('#warehouse').find(':selected').val();
            if (warehouse != 'Select') {
                $('#getEmployees').DataTable().destroy();
                load_data();
            } 

        });

        $('#refresh').click(function() {
            $('#warehouse').select2("val", '1');

            $('#main_category').val('');
            $('#category').html("");
            $('#subcategory').html("");
            $('#subsubcategory').html("");
            $('#fit').val("");
            $('#getEmployees').DataTable().destroy();
            load_data();
        });

        });


        function getCategory()
        {
            $('#category').empty();
            var maincountryid = document.getElementById('main_category').value;
            $('#category').html("<option>Select Category</option>");
            $('#subcategory').html("<option>Select Sub Category</option>");
            $('#subsubcategory').html("<option>Select Sub Sub Category</option>");
            $.ajax({
                url:"{{ url('/getcategory/') }}/"+maincountryid,
                type:"GET",
                success:function(response)
                {
                    if(response.status == 200)
                    {
                        var html = "";
                        html = "<option disabled>Select Category</option>";
                        $.each(response.data,function(index,el){
                            html += "<option value='"+el.id+"'>"+el.name+"</option>";
                            
                        });
                        $('#category').html(html);
                    }
                    else
                    {
                        $('#category').html("<option>Record Not Found</option>");

                    }
                }
            });
        }
    
    function getSubCategory(h){
        var category_id = $('#category').select2('val');
            $('#subcategory').html("<option>Select Sub Category</option>");
            $.ajax({
                url:"{!! route('product.getSubCategory') !!}",
                data: {
                        category: category_id,
                     },
                type:"GET",
                success:function(response)
                {
                    if(response.status == 200)
                    {
                        var html = "";
                        html = "<option>Select Sub Category</option>";
                        $.each(response.data,function(index,el){
                            html += "<option value='"+el.id+"'>"+el.name+"</option>";
                            // console.log(el.name);
                        });
                        $('#subcategory').html(html);
                    }
                    else
                    {
                        $('#subcategory').html("<option>Record Not Found</option>");

                    }
                }
            });
    }   


    function getSubSubCategory(a){
        var sub_category_id = $('#subcategory').select2('val');
            $('#subsubcategory').html("<option>Select Sub Sub Category</option>");
            $.ajax({
                url:"{!! route('product.getSubSubCategory') !!}",
                data: {
                        sub_category: sub_category_id,
                     },
                type:"GET",
                success:function(response)
                {
                    if(response.status == 200)
                    {
                        var html = "";
                        html = "<option>Select Sub Sub Category</option>";
                        $.each(response.data,function(index,el){
                            html += "<option value='"+el.id+"'>"+el.name+"</option>";
                            // console.log(el.name);
                        });
                        $('#subsubcategory').html(html);
                    }
                    else
                    {
                        $('#subsubcategory').html("<option>Record Not Found</option>");

                    }
                }
            });
    } 
    $(document).ready(function() {
    $('#warehouse').select2();
    $('#category').select2();
    $('#subcategory').select2();
    $('#subsubcategory').select2();

 
});

function selectwarehouse(val){
    console.log(val.value);
    window.location.href = "{{ route('warehouse.index') }}?warehouse="+val.value;
}
function showqty(id){
    // console.log(val.value);
    // window.location.href = "{{ route('warehouse.index') }}?warehouse="+val.value;
}
</script>    



@endpush

