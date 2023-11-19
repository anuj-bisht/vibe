@extends('layouts.app') @include('styles.style') @section('content') <style>
    select.form-control:not([multiple='multiple']) {
        background-image: linear-gradient(45deg, transparent 50%, white 50%), linear-gradient(135deg, white 50%, transparent 50%), linear-gradient(to right, #32AD89, #32AD89);
        background-position: calc(100% - 20px) calc(1em + 2px), calc(100% - 15px) calc(1em + 2px), 100% 0;
        background-size: 5px 5px, 5px 5px, 2.8em 2.8em;
        background-repeat: no-repeat;
        -webkit-appearance: none;
    }

</style>
<div class="container">
    <form class="form" method="POST" action={{route('warehouse.store')}} id="inputform"> @csrf <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title" style="color:black; ">Add Warehouse</h4>
                            <h4 class="card-title " style="color: #009973; font-weight:bold;">
                                <span id="product_gender_id"></span>
                                <span id="product_fabric_id"></span>
                                <span id="product_style_id"></span>&nbsp;&nbsp;&nbsp;&nbsp; <span id="product_color_id"></span>&nbsp;&nbsp;&nbsp;&nbsp; <span id="product_size_id"></span>
                            </h4>
                            <span>
                                <a href="{{route('warehouse.listing.index')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>

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
                            <div class="row">
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Warehouse Name</label>
                                        <input type="text" id="last-name-column" class="form-control" placeholder="Warehouse Name" name="name" autofocus/>
                                    </div> @error('name') <h5 class="alert alert-danger">{{$message}}</h5> @enderror
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Warehouse Address</label>
                                        <input type="text" id="last-name-column" class="form-control" placeholder="Warehouse Address" name="address" /> @error('address') <h5 class="alert alert-danger">{{$message}}</h5> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Warehouse Contact</label>
                                        <input type="text" id="last-name-column" class="form-control" placeholder="Warehouse Contact" name="contact" /> @error('contact') <h5 class="alert alert-danger">{{$message}}</h5> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Warehouse Email</label>
                                        <input type="email" id="last-name-column" class="form-control" placeholder="Warehouse Email" name="email" /> @error('email') <h5 class="alert alert-danger">{{$message}}</h5> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Warehouse Type</label>
                                        <select class="form-control" id="" name="type" data-index="14" onkeydown="setNextField(event)">
                                            <option disabled selected>Type</option>
                                            <option value="Finished">Finished</option>
                                            {{-- <option value="Online">Online</option> --}}
                                        </select> @error('type') <h5 class="alert alert-danger">{{$message}}</h5> @enderror
                                    </div>
                                </div>
                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Status</label>
                                        <select class="form-control" id="" name="status" data-index="14" onkeydown="setNextField(event)">
                                            <option disabled selected>Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select> @error('status') <h5 class="alert alert-danger">{{$message}}</h5> @enderror
                                    </div>
                                </div>


                                <div class="col-md-4 col-12">
                                    <div class="form-group">
                                        <label for="last-name-column">Status</label>
                                        <select class="form-control" id="warehouse_status" name="status" data-index="14" onkeydown="setNextField(event)">
                                            <option disabled selected>Status</option>
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select> @error('status') <h5 class="alert alert-danger">{{$message}}</h5> @enderror
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



