


@extends('layouts.app')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>

@section('content')
<div class="container">
    <section >
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Product Summary</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @php
    {{ $category = Modules\Master\Entities\Category::get(); }}
    {{ $subcategory = Modules\Master\Entities\SubCategory::get(); }}
    {{ $subsubcategory = Modules\Master\Entities\SubSubCategory::get(); }}


    @endphp
    <section id="collapsible">
        <div class="row">
            <div class="col-sm-12">
                <div class="card collapse-icon">
                   
                    <div class="card-body">
                    
                        <div class="collapse-default">
                            <div class="card">
                                <div id="headingCollapse1" class="card-header" data-toggle="collapse" role="button" data-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                    <span class="lead collapse-title"> Filter </span>
                                </div>
                                <div id="collapse1" role="tabpanel" aria-labelledby="headingCollapse1" class="collapse">
                                    <form class="needs-validation" novalidate method="POST" action="{{route('master.color.store')}}">
                                        @csrf
                                        <div class="form-row">
                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label for="">Select Warehouse</label>
                                                    <select class=" form-control" data-index="1"  id="warehouse" name="warehouse" >
                                                        @foreach($all_warehouse as $warehouse)
                                                        <option value="{{ $warehouse->id }}" {{ $select== $warehouse->id? "selected": "" }}>{{ $warehouse->name }}</option>
                                                        @endforeach
                                                    </select>
                                            </div>
                                        </div>

                                           

                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label for="main_category" style="color:black; font-weight:bold;">Main Category</label>
                                                    <select class="form-control " id="main_category" name="main_category" onchange="getCategory(this)" data-index="9" onkeydown="setNextField(event)">
                                                        <option disabled selected>Select Main Category</option>
                                                       @foreach($main_category as $mainCategory)
                                                       <option value={{$mainCategory->id}} {{ old("main_category") == $mainCategory->id ? "selected":"" }}>{{$mainCategory->name}}</option>
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
        
                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column" style="color:black; font-weight:bold;">Category</label>
                                                    <select class="form-control"  id="category" multiple="multiple" name="category[]"  onchange="getSubCategory(this)" data-index="10" onkeydown="setNextField(event)">
                                                        {{-- @foreach($category as $Category)
                                                        <option value={{$Category->id}} {{ old("category") == $Category->id ? "selected":"" }}>{{$Category->name}}</option>
                                                        @endforeach --}}
                                                       
        
                                                    </select>
                                                    @error('category')
                                                    <h5 class="alert alert-danger">{{$message}}</h5>
                                                @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12">
                                                <div class="form-group">
                                                    <label for="last-name-column" style="color:black; font-weight:bold;">Sub Category</label>
                                                    <select class="form-control " id="subcategory" multiple="multiple" name="subcategory[]" onchange="getSubSubCategory(this)" data-index="11"  onkeydown="setNextField(event)">
                                                        {{-- @foreach($subcategory as $subCategory)
                                                        <option value={{$subCategory->id}} {{ old("subcategory") == $subCategory->id ? "selected":"" }}>{{$subCategory->name}}</option>
                                                        @endforeach --}}
                                                    </select>
                                                    @error('subcategory')
                                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                                   @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-12" style="color:black; font-weight:bold;">
                                                <div class="form-group">
                                                    <label for="city-column">Sub Sub Category</label>
                                                    <select class="form-control select2" id="subsubcategory" name="subsubcategory" data-index="12"   onkeydown="setNextField(event)">
                                                        <option disabled selected>Select Sub Sub Category</option>
                                                        {{-- @foreach($subsubcategory as $subsubCategory)
                                                        <option value={{$subsubCategory->id}} {{ old("subsubcategory") == $subsubCategory->id ? "selected":"" }}>{{$subsubCategory->name}}</option>
                                                        @endforeach --}}
                                                    </select>
                                                    @error('subsubcategory')
                                                       <h5 class="alert alert-danger">{{$message}}</h5>
                                                   @enderror
                                                </div>
                                            </div>
                    
                                          
                                            <div class="col-md-3 col-12" style="color:black; font-weight:bold;">
                                                <a class="btn global_btn_color" href="javascript:void(0)" onclick="searchfilter()">Submit</a>

                                                </div>
                                            </div>
                    
                                        </div>
                                    </form>
                                </div>
                            </div>
                      
               
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="card-demo-example">
        <div class="row match-height">
            @foreach($finished_data as $data)
            <div class="col-md-6 col-lg-3 " onclick="showqty({{$data['id']}})">
                <div class="card">
                    <img class="card-img-top" src="{{$data['p_image1']}}" alt="Card image cap" />
                    <div class="card-body">
                        <p class="card-text">
                            Some quick example text to build on the card title and make up the bulk of the card's content.
                        </p>
                        <p class="card-text text-center">
                            {{ $data['color']['name'] }}
                        </p>
                        <p class="card-text text-center">
                            {{ $data['sum'] }}
                        </p>
                        {{-- <a data-toggle="modal" data-target="#xlarge{{$data->id}}">
                            {{ $data['p_mrp'] }}
                        </p> --}}
                    </div>
                </div>
            </div>
            @endforeach

            


       
        </div>
    </section>
    <div class="d-flex justify-content-center">
        {!! $finished_data->links() !!}
    </div>
</div>

@foreach($finished_data as $data)
@foreach ($data['child'] as $detail)
    

<div class="modal fade text-left" id="xlarge{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h4 class="modal-title" id="myModalLabel16">Edit</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
            <form class="table-responsive" action="{{route('update.orderAttribute', ['id' => $detail->id]) }}" method="post">
               @csrf
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: smaller;">
                   <thead class="">
                       <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant; text-align:center;">
                           @foreach($sizes as $size)
                           <th style="padding:0.75rem !important;">
                               <?php
                                $str=explode('/',$size->size);
                                
                                $a=$str[0]??'';
                                $b=$str[1]??'';
                                echo "$a<br>$b";
                                 ?>
                           </th>
                           @endforeach
                       </tr>
                   </thead>
                   <tbody>
                     <tr style="text-align:center;">
                        @foreach ($data['child'] as $attribute)
                        <td><input type="text" readonly style="border:none;" value="{{$attribute->qty}}"  class="form-control input"></td>
                        @endforeach
                     </tr>
                   
                   </tbody>
               </table>
           </form>
           </div>
          
       </div>
   </div>
</div>
@endforeach
@endforeach


@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
{{-- <script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script> --}}
<script>
function showqty(id){
var p_id=`#xlarge${id}`;
$(p_id).modal({
        show: true
    });
}


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
                            // console.log(el.name);
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

        function searchfilter(){
            var w_id = $('#warehouse').find(':selected').val();
            var mc_id= $('#main_category').find(':selected').val() > 0 ? $('#main_category').find(':selected').val() : null;
            var sc_id=$("#category :selected").map(function(i, el) {
            return $(el).val();
           }).get();

           var ssc_id=$("#subcategory :selected").map(function(i, el) {
            return $(el).val();
           }).get();
            var sc_ids = sc_id.length > 0 ? sc_id : null;
            var ssc_ids = ssc_id.length > 0 ? ssc_id : null;

            
       
           
            
            window.location.href = "{{ route('productSummary.report') }}?warehouse_id="+w_id+"&main_category_id="+mc_id+"&sub_category_id="+sc_ids+"&sub_sub_category_id="+ssc_ids;
           }      
   
           $(document).ready(function() {
            // $('#color_id').select2();
            $('#category').select2();
            $('#subcategory').select2();


        });
</script>
@endpush




