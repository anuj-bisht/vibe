@extends('layouts.app')
<link rel="stylesheet" type="text/css" href="{{ asset('app-assets/vendors/css/forms/select/select2.min.css') }}">

@section('content')

<style>
    .select2-container--default .select2-search--inline .select2-search__field {
        display: none !important;

    }
</style>
<div class="container">
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Product Master</h4>
                        <a class="btn global_btn_color" href="{{route('product.create')}}" type="submit"><svg
                                xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-plus mr-25">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>Add</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Table head options start -->
    <div class="row" id="table-head">
        <div class="col-12">
            @if($errors->any())
            <p class="alert alert-danger alert-heading">{{$errors->first()}}</p>
            @endif
            @if(Session::has('message'))
            <p class="alert alert-success alert-heading">{{ Session::get('message') }}</p>
            @endif
            <div class="container-fluid">
                <section id="">
                    <div class="row">
                        <div class="card" style="width:70%">
                            <div class="card-header">
                                <div class="col-md-3">
                                    <label>Main Category</label>
                                    <select class="form-control " id="main_category" name="main_category"
                                        onchange="getCategory(this)">
                                        <option disabled data-set="1" selected>Select</option>
                                        @foreach($main_category as $mainCategory)
                                        <option value={{$mainCategory->id}}>{{$mainCategory->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Category</label>
                                    <select class="form-control" id="category" multiple="multiple" name="category[]"
                                        onchange="getSubCategory(this)">
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label> Sub Category</label>
                                    <select class="form-control " id="subcategory" multiple="multiple"
                                        name="subcategory[]" onchange="getSubSubCategory(this)">
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label> Sub Sub Category</label>
                                    <select class="form-control " id="subsubcategory" multiple="multiple"
                                        name="subsubcategory[]">
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label> Fit</label>
                                    <select class="form-control" id="fit" name="fit">
                                        <option disabled data-set="1" selected>Select</option>
                                        @foreach($fits as $fit)
                                        <option value={{$fit->id}}>{{$fit->code}}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
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
                <div class="table-responsive">
                    <table class="table table-bordered" id="productListing" width="100%" cellspacing="0">
                        <thead class="">
                            <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                                <th>P Code</th>
                                <th>C Code</th>
                                <th>MRP Price</th>
                                <th>Cost Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Table head options end -->
</div>

@endsection
@push('scripts')

<script>
    $(function() {
        load_data();

        function load_data(from_date = '', to_date = '') {
            var table = $('#productListing').DataTable({
                order: [
                    [1, "desc"]
                ],
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: {
                    url: "{!! route('product.listing') !!}",
                    data: {
                        main_category: $('#main_category').find(':selected').val(),
                        category: $('#category').val(),
                        subcategory: $('#subcategory').val(),
                        sub_sub_category: $('#subsubcategory').val(),
                        fit: $('#fit').find(':selected').val(),
                    }
                },
                columns: [{
                        data: 'parent.product_code'
                    }, {
                        data: 'color.color_code'
                    }, {
                        data: 'mrp'
                    }, {
                        data: 'cost_price'
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
            var main_category = $('#main_category').find(':selected').val();
            if (main_category != 'Select') {
                $('#productListing').DataTable().destroy();
                load_data();
            } else {
                alert('Select Category');
            }
        });
        $('#refresh').click(function() {
            $('#main_category').val('');
            $('#category').html("");
            $('#subcategory').html("");
            $('#subsubcategory').html("");
            $('#fit').val("");
            $('#productListing').DataTable().destroy();
            load_data();
        });
    });

    function getCategory() {
        $('#category').empty();
        var maincountryid = document.getElementById('main_category').value;
        $('#category').html("<option>Select Category</option>");
        $('#subcategory').html("<option>Select Sub Category</option>");
        $('#subsubcategory').html("<option>Select Sub Sub Category</option>");
        $.ajax({
            url: "{{ url('/getcategory/') }}/" + maincountryid,
            type: "GET",
            success: function(response) {
                if (response.status == 200) {
                    var html = "";
                    html = "<option disabled>Select Category</option>";
                    $.each(response.data, function(index, el) {
                        html += "<option value='" + el.id + "'>" + el.name + "</option>";
                    });
                    $('#category').html(html);
                } else {
                    $('#category').html("<option>Record Not Found</option>");
                }
            }
        });
    }

    function getSubCategory(h) {
        var category_id = $('#category').select2('val');
        $('#subcategory').html("<option>Select Sub Category</option>");
        $.ajax({
            url: "{!! route('product.getSubCategory') !!}",
            data: {
                category: category_id,
            },
            type: "GET",
            success: function(response) {
                if (response.status == 200) {
                    var html = "";
                    html = "<option>Select Sub Category</option>";
                    $.each(response.data, function(index, el) {
                        html += "<option value='" + el.id + "'>" + el.name + "</option>";
                        // console.log(el.name);
                    });
                    $('#subcategory').html(html);
                } else {
                    $('#subcategory').html("<option>Record Not Found</option>");
                }
            }
        });
    }

    function getSubSubCategory(a) {
        var sub_category_id = $('#subcategory').select2('val');
        $('#subsubcategory').html("<option>Select Sub Sub Category</option>");
        $.ajax({
            url: "{!! route('product.getSubSubCategory') !!}",
            data: {
                sub_category: sub_category_id,
            },
            type: "GET",
            success: function(response) {
                if (response.status == 200) {
                    var html = "";
                    html = "<option>Select Sub Sub Category</option>";
                    $.each(response.data, function(index, el) {
                        html += "<option value='" + el.id + "'>" + el.name + "</option>";
                        // console.log(el.name);
                    });
                    $('#subsubcategory').html(html);
                } else {
                    $('#subsubcategory').html("<option>Record Not Found</option>");
                }
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#category').select2();
        $('#subcategory').select2();
        $('#subsubcategory').select2();
    });
</script>

@endpush