


@extends('layouts.app')

@section('content')
<div class="container" >




        <section class="tooltip-validations" id="tooltip-validation">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Product Sizes</h4>
                            <a class="btn global_btn_color" href="{{route('product.create')}}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>Add</a>

                        </div>

                    </div>
                </div>
            </div>



        </section>




     <!-- Table head options start -->
     <div class="table-responsive">
        <table class="table" id="dataTable" width="100%" cellspacing="0">
            <thead class="" >
                <tr>
                    <th>Sno.</th>
                    <th>Size</th>
                    <th>Ean Code</th>
                    <th>Color Code</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
                    @foreach ($products as  $product)

                        <td>{{$loop->iteration}}</td>
                        <td>{{$product->sizes->size }}</td>
                        <td>{{$product->ean_code}}</td>
                        <td>{{$product->color_code}}</td>
                        <td>{{$product->sizes->type }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{route('get.barcode',['id'=>$product->id])}}">Print Barcodes</a>

                        </td>

                    </tr>
                    @endforeach

            </thead>
          
        </table>
    </div>
    <!-- Table head options end -->
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.2/jspdf.min.js"></script>

<script>

</script>
@endsection





