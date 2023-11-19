<form class="form" method="POST" action={{route('product.store')}} id="inputform" enctype="multipart/form-data">
    @csrf
    <section id="multiple-column-form">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        @if($errors->any())
                        <h6 class="alert alert-danger">{{$errors->first()}}</h6>
                        @endif
                        <div class="row">

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="first-name-column" style="color:black; ">Gender</label>
                                    <select class=" form-control" data-index="1" id="gender" name="gender"
                                        onchange="setGender()" value="{{old('gender')}}" onkeydown="if (event.keyCode == 13) {event.preventDefault(); document.getElementsByName('mrp')[0].focus();}">
                                        <option disabled selected>Select Gender</option>
                                        @foreach($gender as $gender)
                                        <option data-gender="{{$gender->short_form}}" {{ old("gender")==$gender->id ?
                                            "selected":"" }} value={{$gender->id}} >{{$gender->name}}</option>

                                        @endforeach

                                    </select>
                                    @error('gender')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="city-column" style="color:black; ">Style Code</label>
                                    <select class="form-control select2" id="style_code" name="style_code"
                                        data-index="3" onchange="setStyle()" onkeydown="setNextField(event)">
                                        <option disabled selected>Select Style</option>
                                        @foreach($style as $style)
                                        <option data-style="{{$style->code}}" value={{$style->id}} {{ old("style_code")
                                            == $style->id ? "selected":"" }}>{{$style->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('style_code')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="city-column" style="color:black; ">MRP</label>
                                    <input type="text" id="city-column" class="form-control" data-index="6"
                                        value="{{ old('mrp') }}" placeholder="MRP" name="mrp"
                                        onkeydown="setNextField(event)" />
                                    @error('mrp')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                    @enderror
                                </div>

                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="first-name-column" style="color:black; ">Cost Price</label>
                                    <input type="text" id="first-name-column" class="form-control " data-index="7"
                                        placeholder="Cost Price" name="cost_price" value="{{old('cost_price')}}"
                                        onkeydown="setNextField(event)" />
                                    @error('cost_price')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="main_category" style="color:black; ">Main Category</label>
                                    <select class="form-control select2" id="main_category" name="main_category"
                                        onchange="getCategory(this)" data-index="9" onkeydown="setNextField(event)">
                                        <option disabled selected>Select Main Category</option>
                                        @foreach($main_category as $mainCategory)
                                        <option value={{$mainCategory->id}} {{ old("main_category") == $mainCategory->id
                                            ? "selected":"" }}>{{$mainCategory->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('main_category')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="first-name-column" style="color:black;">Category</label>
                                    <select class="form-control select2" id="category" name="category"
                                        onchange="getSubCategory(this)" data-index="10" onkeydown="setNextField(event)">
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
                                    <select class="form-control select2" id="subcategory" name="subcategory"
                                        onchange="getSubSubCategory(this)" data-index="11"
                                        onkeydown="setNextField(event)">
                                        <option disabled selected>Select Sub Category</option>
                                        @foreach($subcategory as $subCategory)
                                        <option value={{$subCategory->id}} {{ old("subcategory") == $subCategory->id ?
                                            "selected":"" }}>{{$subCategory->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('subcategory')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-7 col-12">
                                <div class="form-group">
                                    <label for="last-name-column" style="color:black; ">Description</label>
                                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1"
                                        rows="10" data-index="16" placeholder="Textarea"
                                        value="{{old('description')}}">{{ old('description') }}</textarea>
                                    @error('description')
                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-sm global_btn_color"
                            style="background-color: #009973; color:white; border-radius: 10px"
                            type="submit">Submit</button>

</form>