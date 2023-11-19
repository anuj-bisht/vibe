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

<div class="container" id="productform">

    <form class="form" method="POST" action={{route('product.store')}} id="inputform" enctype="multipart/form-data" onsubmit="return validateForm()">
        @csrf
        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" style="color:black; ">Add Product</h4>
                            <h4 class="card-title " style="color: #009973; "><span id="product_gender_id"></span><span id="product_fabric_id"></span><span id="product_style_id"></span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="product_color_id"></span>&nbsp;&nbsp;&nbsp;&nbsp;<span id="product_size_id"></span></h4>
                            <span>
                                <a href="{{route('product.index')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                    </svg></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="multiple-column-form">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {{-- @if($errors->any())
                            <h6 class="alert alert-danger">{{$errors->first()}}</h6>
                            @endif --}}
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column" style="color:black; ">Gender</label>
                                        <select class=" form-control select2" data-index="1" id="gender" name="gender" onchange="setGender()" value="{{old('gender')}}">
                                            <option disabled selected>Select Gender</option>
                                            @foreach($gender as $gender)
                                            <option data-gender="{{$gender->short_form}}" {{ old("gender")==$gender->id
                                                ? "selected":"" }} value={{$gender->id}}>{{$gender->name}}</option>

                                            @endforeach

                                        </select>
                                        @error('gender')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column" style="color:black; ">Fabric Code</label>
                                        <a style="float: right;" href="{{ route('master.fabric.create') }}" target="_blank" style="color:blue; ">Create</a>
                                        <select class="select2 form-control" id="fabric_code" name="fabric_code" data-index="2" onchange="setFabric()">
                                            <option disabled selected>Select Fabric</option>
                                            @foreach($fabric as $fabric)
                                            <option data-fabric="{{$fabric->code}}" value={{$fabric->id}} {{
                                                old("fabric_code") == $fabric->id ? "selected":"" }}>{{$fabric->code}}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('fabric_code')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style="color:black; ">Style Code</label>
                                        <a style="float: right;" href="{{route('master.style.create')}}" target="_blank" style="color:blue; ">Create</a>
                                        <select class="form-control select2" id="style_code" name="style_code" data-index="3" onchange="setStyle()">
                                            <option disabled selected>Select Style</option>
                                            @foreach($style as $style)
                                            <option data-style="{{$style->code}}" value={{$style->id}} {{
                                                old("style_code") == $style->id ? "selected":"" }}>{{$style->code}}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('style_code')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column" style="color:black; ">Color Code</label>
                                        <a style="float: right;" href="{{route('master.color.create')}}" target="_blank" style="color:blue; ">Create</a>
                                        <select class="form-control select2" id="color_code" name="color_code" data-index="4" onchange="setColor()">
                                            <option disabled selected>Select Color</option>
                                            @foreach($color as $color)
                                            <option data-color="{{$color->color_code}}" value={{$color->id}} {{
                                                old("color_code") == $color->id ? "selected":""
                                                }}>{{$color->color_code}}</option>
                                            @endforeach
                                        </select>
                                        @error('color_code')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column" style="color:black; ">Season</label>
                                        <a style="float: right;" href="{{route('master.season.create')}}" target="_blank" style="color:blue; ">Create</a>
                                        <select class="form-control select2" id="season_name" data-index="5" name="season_name">

                                            <option disabled selected>Select Season</option>
                                            @foreach($season as $season)
                                            <option value={{$season->id}} {{ old("season_name") == $season->id ?
                                                "selected":"" }}>{{$season->code}}</option>
                                            @endforeach
                                        </select>
                                        @error('season_name')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column" style="color:black; ">Composition</label>
                                        <a style="float: right;" href="{{route('master.composition.create')}}" target="_blank" style="color:blue; ">Create</a>
                                        <select class="form-control select2" id="composition_name" data-index="5" name="composition_name">

                                            <option disabled selected>Select Composition</option>
                                            @foreach($compositions as $composition)
                                            <option value={{$composition->id}} {{ old("composition_name") == $composition->id ?
                                                "selected":"" }}>{{$composition->text}}</option>
                                            @endforeach
                                        </select>
                                        @error('composition_name')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                              
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column" style="color:black; ">Margin Code</label>
                                        <a style="float: right;" href="{{route('master.margin.create')}}" target="_blank" style="color:blue; ">Create</a>
                                        <select class="form-control select2" id="margin_code" name="margin_code" data-index="8">
                                            <option disabled selected>Select Margin Code</option>
                                            <option value="A" {{ old("margin_code")=="A" ? "selected" :"" }}>A</option>
                                            <option value="B" {{ old("margin_code")=="B" ? "selected" :"" }}>B</option>
                                            <option value="C" {{ old("margin_code")=="C" ? "selected" :"" }}>C</option>
                                            <option value="D" {{ old("margin_code")=="D" ? "selected" :"" }}>D</option>
                                        </select>
                                        @error('margin_code')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="main_category" style="color:black; ">Main Category</label>
                                        <a style="float: right;" href="{{route('master.maincategory.create')}}" target="_blank" style="color:blue; ">Create</a>
                                        <select class="form-control select2" id="main_category" name="main_category" onchange="getCategory(this)" data-index="9">
                                            <option disabled selected>Select Main Category</option>
                                            @foreach($main_category as $mainCategory)
                                            <option value={{$mainCategory->id}} {{ old("main_category") ==
                                                $mainCategory->id ? "selected":"" }}>{{$mainCategory->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('main_category')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>


                                @php
                                {{ $category = Modules\Master\Entities\Category::get(); }}
                                {{ $subcategory = Modules\Master\Entities\SubCategory::get(); }}
                                {{ $subsubcategory = Modules\Master\Entities\SubSubCategory::get(); }}
                                @endphp

                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column" style="color:black;">Category</label>
                                        <a style="float: right;" href="{{route('master.category.create')}}" target="_blank" style="color:blue; ">Create</a>
                                        <select class="form-control select2" id="category" name="category" onchange="getSubCategory(this)" data-index="10">
                                            <option disabled selected>Select Category</option>
                                            @foreach($category as $Category)
                                            <option value={{$Category->id}} {{ old("category") == $Category->id ?
                                                "selected":"" }}>{{$Category->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('category')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column" style="color:black;">Sub Category</label>
                                        <a style="float: right;" href="{{route('master.subcategory.create')}}" target="_blank" style="color:blue; ">Create</a>
                                        <select class="form-control select2" onchange="getSubSubCategory(this)" id="subcategory" name="subcategory" data-index="11">
                                            <option disabled selected>Select Sub Category</option>
                                            @foreach($subcategory as $subCategory)
                                            <option value={{$subCategory->id}} {{ old("subcategory") == $subCategory->id
                                                ? "selected":"" }}>{{$subCategory->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('subcategory')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12" style="color:black;">
                                    <div class="form-group">
                                        <label for="city-column">Sub Sub Category</label>
                                        <a style="float: right;" href="{{route('master.subsubcategory.create')}}" target="_blank" style="color:blue; ">Create</a>
                                        <select class="form-control select2" id="subsubcategory" name="subsubcategory" data-index="12">
                                            <option disabled selected>Select Sub Sub Category</option>
                                            @foreach($subsubcategory as $subsubCategory)
                                            <option value={{$subsubCategory->id}} {{ old("subsubcategory") ==
                                                $subsubCategory->id ? "selected":"" }}>{{$subsubCategory->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('subsubcategory')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column" style="color:black; ">Fit</label>
                                        <a style="float: right;" href="{{route('master.fit.create')}}" target="_blank" style="color:blue; ">Create</a>
                                        <select class="form-control select2" id="fit_id" name="fit_id" data-index="13">
                                            <option disabled selected>Select Fit</option>
                                            @foreach($fit as $fit)
                                            <option value={{$fit->id}} {{ old("fit_id") == $fit->id ? "selected":""
                                                }}>{{$fit->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('fit_id')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column" style="color:black; ">EAN Prefix</label>
                                        <a style="float: right;" href="{{route('master.ean.create')}}" target="_blank" style="color:blue; ">Create</a>
                                        <select class="form-control select2" id="ean_prefix" name="ean_prefix" data-index="14">
                                            <option disabled selected>Select Prefix</option>
                                            @foreach($ean as $ean)
                                            <option value={{$ean->id}} {{ old("ean_prefix") == $ean->id ? "selected":""
                                                }}>{{$ean->prefix}}</option>
                                            @endforeach
                                        </select>
                                        @error('ean_prefix')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style="color:black; ">HSN Code</label>
                                        <a style="float: right;" href="{{route('master.hsn.create')}}" target="_blank" style="color:blue; ">Create</a>
                                        <select class="form-control select2" id="hsn_code" name="hsn_code" data-index="15">
                                            <option disabled selected>Select HSN Code</option>
                                            @foreach($hsn as $hsn)
                                            <option value={{$hsn->id}} {{ old("hsn_code") == $hsn->id ? "selected":""
                                                }}>{{$hsn->code}}</option>
                                            @endforeach
                                        </select>
                                        @error('hsn_code')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                                  <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="city-column" style="color:black; ">MRP</label>
                                        <input type="text" id="mrp" class="form-control"  data-index="6" value="{{ old('mrp') }}" placeholder="MRP" name="mrp" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"/>
                                        @error('mrp')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>

                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="first-name-column" style="color:black; ">Cost Price</label>
                                        <input type="text" id="cost_price" class="form-control " data-index="7" placeholder="Cost Price" name="cost_price" value="{{old('cost_price')}}"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"/>
                                        @error('cost_price')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-1 col-6">
                                    <div class="form-group">
                                        <label for="country-floating" style="color:black; ">Size</label>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6" style="text-align: end;">
                                    <div class="form-group">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="checknumber" onclick='handleClick(this);' value="checked" />
                                            <label class="form-check-label" for="inlineCheckbox1" style="color:black; ">Tick For Size Can Be By Waist</label>
                                            <input type="hidden" id="numbercheck" value="uncheck" name="type_check">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <section class="basic-checkbox">
                                        <div class="row">
                                            <div class="col-6">
                                                <input type="file" id="" data-index="16" class="form-control" data-index="" name="image1" />
                                            </div>
                                            <div class="col-6">
                                                <input type="file" id="" data-index="17" class="form-control" data-index="" name="image2" />
                                            </div>
                                        </div>
                                    </section>
                                    @error('sizes')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                    @enderror
                                </div>
                                <div class="col-md-7 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column" style="color:black; ">Description</label>
                                        <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="10" data-index="18" placeholder="Textarea" oninput="this.value = this.value.toUpperCase()" value="{{old('description')}}">{{ old('description') }}</textarea>
                                        @error('description')
                                        <h5 class="alert alert-danger">{{$message}}</h5>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-sm global_btn_color" style="background-color: #009973; color:white; border-radius: 10px" type="submit">Submit</button>

    </form>
</div>
</div>
</div>
</div>
</section>

</div>
@endsection
@push('scripts')
<script>
    var inputs = $("input[type=text],select,input[type=checkbox] ,input[type=file]"); // You can use other elements such as textarea, button etc. 
    //depending on input field types you have used
    $("select").on("select2:close", function(e) {
        if(event.which == 13){
        var pos = $(inputs).index(this) + 1;
        var next = $(inputs).eq(pos);
        setTimeout(function() {
            next.focus();
            if (next.siblings(".select2").length) {
                next.select2("open");
            }
        }, 500);
    }
    });

</script>
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>
<script>
    function handleClick(cb) {
        if (cb.checked == true) {
            $('#numbercheck').val('check')

        } else {
            $('#numbercheck').val('uncheck')

        }
    }

    function getCategory() {
        var maincountryid = document.getElementById('main_category').value;
        $('#category').html("<option>Select Category</option>");
        $('#subcategory').html("<option>Select Sub Category</option>");
        $('#subsubcategory').html("<option>Select Sub Sub Category</option>");
        $.ajax({
            url: "{{ url('/getcategory/') }}/" + maincountryid
            , type: "GET"
            , success: function(response) {
                if (response.status == 200) {
                    var html = "";
                    html = "<option>Select Category</option>";
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

    function getSubCategory() {
        var countryid = document.getElementById('category').value;
        $('#subcategory').html("<option>Select Sub Category</option>");
        $('#subsubcategory').html("<option>Select Sub Sub Category</option>");
        $.ajax({
            url: "{{ url('/getsubcategory/') }}/" + countryid
            , type: "GET"
            , success: function(response) {
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

    function getSubSubCategory() {
        var subcountryid = document.getElementById('subcategory').value;
        $('#subsubcategory').html("<option>Select Sub Sub Category</option>");

        $.ajax({
            url: "{{ url('/getsubsubcategory/') }}/" + subcountryid
            , type: "GET"
            , success: function(response) {
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

    function setGender() {
        let element = document.getElementById("gender");
        let gender = element.options[element.selectedIndex].getAttribute("data-gender");
        $('#product_gender_id').text(gender);
    }

    function setFabric() {
        let element = document.getElementById("fabric_code");
        let fabric = element.options[element.selectedIndex].getAttribute("data-fabric");
        $('#product_fabric_id').text(fabric);
    }

    function setStyle() {
        let element = document.getElementById("style_code");
        let style = element.options[element.selectedIndex].getAttribute("data-style");
        $('#product_style_id').text(style);
    }

    function setColor() {
        let element = document.getElementById("color_code");
        let color = element.options[element.selectedIndex].getAttribute("data-color");
        $('#product_color_id').text(color);
    }

    function setSize() {
        let siz = [];
        $('input[name="sizes[]"]:checked').each(function() {
            siz.push(this.value);
        });
        $('#product_size_id').text(siz[0]);
    }
   
</script>
<script>
       $('document').ready(function(){
   $("#gender").select2().select2("open");
});
</script>

<script>
     function validateForm() {
        if($('#gender').val() == null ){
                    toastr['success']('Please Select Gender', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
        if($('#fabric_code').val() == null ){
                    toastr['success']('Please Select Fabric Code', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
        if($('#style_code').val() == null ){
                    toastr['success']('Please Select Style Code', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
        if($('#color_code').val() == null ){
                    toastr['success']('Please Select Color Code', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
        if($('#season_name').val() == null ){
                    toastr['success']('Please Select Season Name', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
        if($('#composition_name').val() == null ){
                    toastr['success']('Please Select Composition', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
        if($('#margin_code').val() == null ){
                    toastr['success']('Please Select Margin Code', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
        if($('#main_category').val() == null ){
                    toastr['success']('Please Select Main Category', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
        if($('#category').val() == null || $('#category').val() == 'Select Category'){
                    toastr['success']('Please Select Category', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
        if($('#subcategory').val() == null || $('#subcategory').val() == 'Select Sub Category'){
                    toastr['success']('Please Select Sub Category', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
        if($('#subsubcategory').val() == null || $('#subsubcategory').val() == 'Select Sub Sub Category' ){
                    toastr['success']('Please Select Sub Sub Category', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
        if($('#fit_id').val() == null ){
                    toastr['success']('Please Select FIT', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
        if($('#ean_prefix').val() == null ){
                    toastr['success']('Please Select EAN', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
        if($('#hsn_code').val() == null ){
                    toastr['success']('Please Select HSN', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;
        }
     if($('#mrp').val().trim().length == 0){
        toastr['success']('MRP Price is required', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;            
     }

     if($('#cost_price').val().trim().length == 0){
        toastr['success']('Cost Price is required', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;            
     }
     if($('#exampleFormControlTextarea1').val().trim().length == 0){
        toastr['success']('Description is required', '', {
                        closeButton: true
                        , tapToDismiss: false
                        , progressBar: true
                    , });
                return false;            
     }
  

    }
    </script>


@endpush
