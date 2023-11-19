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
<div class="container">
        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" style="color:black; font-weight:bold;">Edit Product</h4>
                            <h4 class="card-title" style="color:#009973; font-weight:bold;">Product ID : &nbsp;{{$product_master->parent->product_code}}&nbsp;&nbsp;&nbsp;{{$product_master->color->color_code}}</h4>
                            <a href="{{route('product.index')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
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
                            <form class="form" method="POST" action={{route('product.update', ['id'=>$product_master->id])}}   enctype="multipart/form-data" onsubmit="return validateForm()">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">Gender</label>
                                            <input type="text" id="gender" name="gender" required value="{{$product_master->gender->name}}" class="form-control"  selected disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Fabric Code</label>
                                            <input type="text" id="fabric_code" name="fabric_code" required value="{{$product_master->fabric->name}}" class="form-control"  selected disabled/>

                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column">Style Code</label>
                                            <input type="text" id="style_code" name="style_code" required value="{{$product_master->style->name}}" class="form-control"  selected disabled/>


                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">Color Code</label>
                                            <input type="text"  id="color_code" name="color_code" required value="{{$product_master->color->name}}" class="form-control"  selected disabled/>


                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Season</label>
                                            <input type="text" id="last-name-column" value="{{$product_master->season->name}}" class="form-control" placeholder="Season Name" name="season_name" selected disabled/>

                                        </div>
                                    </div>

                                  

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">EAN Prefix</label>
                                            <select class="form-control select2" id="ean_prefix" name="ean_prefix" data-index="9" onkeydown="setNextField(event)" disabled>
                                                <option disabled selected>Select Prefix</option>
                                                @foreach ($ean as $ean)
                                                @if($ean->id == $product_master->ean_id)
                                                <option selected value={{$ean->id}}>
                                                @else
                                                <option  value={{$ean->id}}>
                                                @endif
                                                    {{$ean->prefix}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                
                                 

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Margin Code</label>
                                            <select class="form-control select2" id="margin_code" name="margin_code" data-index="3" onkeydown="setNextField(event)">
                                                <option disabled selected>Select Margin Code</option>
                                                <option value="A" @if($product_master->margin == 'A') selected @endif>A</option>
                                                <option value="B"  @if($product_master->margin == 'B') selected @endif>B</option>
                                                <option value="C"  @if($product_master->margin == 'C') selected @endif>C</option>
                                                <option value="D"  @if($product_master->margin == 'D') selected @endif>D</option>


                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Composition</label>
                                            <select class="form-control select2" id="composition_name" name="composition_name" data-index="9" onkeydown="setNextField(event)">
                                                <option disabled selected>Select Composition</option>
                                                @foreach ($compositions as $composition)
                                                @if($composition->id == $product_master->composition_id)
                                                <option selected value={{$composition->id}}>
                                                @else
                                                <option  value={{$composition->id}}>
                                                @endif
                                                    {{$composition->text}}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="main_category">Main Category</label>
                                            <select class="form-control select2" id="main_category" name="main_category" data-index="4" onchange="getCategory(this)" onkeydown="setNextField(event)">
                                                <option disabled selected>Select Main Category</option>
                                               @foreach ($main_category as $mainCategory)
                                               @if($mainCategory->id == $product_master->category->id)
                                               <option selected value={{$mainCategory->id}}>
                                               @else
                                               <option  value={{$mainCategory->id}}>
                                               @endif
                                                   {{$mainCategory->name}}</option>
                                               @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">Category</label>
                                            <select class="form-control select2" id="category" name="category" data-index="5"  onchange="getSubCategory(this)" onkeydown="setNextField(event)">
                                                <option  value="{{$product_master->main_child->id}}">{{$product_master->main_child->name}}</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="last-name-column">Sub Category</label>
                                            <select class="form-control select2" id="subcategory" name="subcategory" data-index="6" onchange="getSubSubCategory(this)" onkeydown="setNextField(event)">
                                                <option  value="{{$product_master->main_child_sub_child->id}}">{{$product_master->main_child_sub_child->name}}</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column">Sub Sub Category</label>
                                            <select class="form-control select2" id="subsubcategory" name="subsubcategory" data-index="7"  onkeydown="setNextField(event)">
                                                <option  value="{{$product_master->main_child_sub_sub_child->id}}">{{$product_master->main_child_sub_sub_child->name}}</option>

                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">Fit</label>
                                            <select class="form-control select2" id="fit_id" name="fit_id" data-index="8" onkeydown="setNextField(event)">
                                                <option disabled selected>Select Fit</option>
                                                @foreach ($fit as $fit)
                                                @if($fit->id == $product_master->fit_id)
                                                <option selected value={{$fit->id}}>
                                                @else
                                                <option  value={{$fit->id}}>
                                                @endif
                                                    {{$fit->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('fit_id')
                                               <h5 class="alert alert-danger">{{$message}}</h5>
                                           @enderror
                                        </div>
                                    </div>
                                  
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column">HSN Code</label>
                                            <select class="form-control select2" id="hsn_code" name="hsn_code" data-index="10" onkeydown="setNextField(event)">
                                                <option disabled selected>Select HSN Code</option>
                                                @foreach ($hsn as $hsn)
                                                @if($hsn->id == $product_master->hsn_id)
                                                <option selected value={{$hsn->id}}>
                                                @else
                                                <option  value={{$hsn->id}}>
                                                @endif
                                                    {{$hsn->code}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="city-column">MRP</label>
                                            <input type="text" id="mrp" data-index="1"  value="{{$product_master->mrp}}" class="form-control" placeholder="MRP" name="mrp" onkeydown="setNextField(event)"/>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">Cost Price</label>
                                            <input type="text" id="cost_price" data-index="2" value="{{$product_master->cost_price}}" class="form-control" placeholder="Cost Price" name="cost_price" onkeydown="setNextField(event)"/>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-6">
                                        <div class="form-group">
                                            <label for="country-floating">Size</label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-6" style="text-align: end;">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input"  type="checkbox" id="checknumber" onclick='handleClick(this);'
                                                 value="checked" disabled  @if($product_master->type === 'check') checked disabled @endif/>
                                                <label class="form-check-label" for="inlineCheckbox1">Tick For Size Can Be By Waist</label>
                                                <input type="hidden" id="numbercheck" @if($product_master->type === 'check') value="check" @else value="uncheck"  @endif  name="type_check">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <section class="basic-checkbox">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <input type="file" id=""  class="form-control" data-index="6" value="{{$product_master->image1}}"  name="image1" />
                                                        @isset($product_master->image1)
                                                        <div id="img-container">
                                                        <a href="{{asset('/ProductImage'.$product_master->image1)}}" target="_blank">
                                                        <img style="width:120px; height:120px; object-fit:contain;" src={{asset('ProductImage/'.$product_master->image1)}} alt="Image"/>
                                                        </a>
                                                    </div>
                                                        @endisset
                                                    </div>
                                                    <div class="col-6">
                                                        <input type="file" id=""  class="form-control" data-index="6" value="{{$product_master->image2}}"   name="image2" />
                                                        @isset($product_master->image2)
                                                        <div>
                                                        <a href="{{asset('/ProductImage'.$product_master->image2)}}" target="_blank">
                                                        <img style="width:120px; height:120px; object-fit:contain;"  src={{asset('ProductImage/'.$product_master->image2)}} alt="Image"/>
                                                        </a>
                                                    </div>
                                                        @endisset                                                    
                                                    </div>
                                                </div>
                                            <input type="hidden"  value="{{$product_master->image1}}"  name="image11" />
                                            <input type="hidden" value="{{$product_master->image2}}"  name="image22" />
                                        </section>
                            </div>
                            <div class="col-md-7 col-12">
                                <div class="form-group">
                                    <label for="last-name-column">Description</label>
                                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="10" placeholder="Textarea" oninput="this.value = this.value.toUpperCase()">{{$product_master->description}}</textarea>
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
<script src="{{ asset('app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/forms/form-select2.js') }}"></script>


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

<script>
function getCategory()
        {
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
                        html = "<option>Select Category</option>";
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

        function getSubCategory()
        {
            var countryid = document.getElementById('category').value;
            $('#subcategory').html("<option>Select Sub Category</option>");
            $('#subsubcategory').html("<option>Select Sub Sub Category</option>");
            $.ajax({
                url:"{{ url('/getsubcategory/') }}/"+countryid,
                type:"GET",
                success:function(response)
                {
                    if(response.status == 200)
                    {
                        var html = "";
                        html = "<option>Select Sub Category</option>";
                        $.each(response.data,function(index,el){
                            html += "<option value='"+el.id+"'>"+el.name+"</option>";
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

        function getSubSubCategory()
        {
            var subcountryid = document.getElementById('subcategory').value;
            $('#subsubcategory').html("<option>Select Sub Sub Category</option>");
            $.ajax({
                url:"{{ url('/getsubsubcategory/') }}/"+subcountryid,
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
                        $('#subsubcategory').html(html);
                    }
                    else
                    {
                        $('#subsubcategory').html("<option>Record Not Found</option>");
                    }
                }
            });
        }

     
</script>
<script>
    function validateForm() {

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
<script>
    $('document').ready(function(){
$("#margin_code").select2().select2("open");
});
</script>
@endpush






