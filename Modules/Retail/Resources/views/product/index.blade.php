@extends('retail.layouts.app')

@section('retail_content')
<div class="container">
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">All Products</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Table head options start -->
     <div class="row" id="table-head">
   
            <div class="card" style="width:100%">
                <div class="table-responsive">
                    <table class="table table-bordered" id="ProductListing" width="100%" cellspacing="0" >
                        <thead class="">
                            <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                                <th>P Code</th>
                                <th>C Code</th>
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
           $('#ProductListing').DataTable({
    

                processing: true,
                serverSide: true,
                searchable : true,

              
                ajax: "{!! route('retailProductListing', ['retailer_id'=>$id]) !!}",
                f:'child',
                columns: [
                    // {
                    //     data: 'DT_RowIndex'
                    // },
                    {data: '_product_code', name: '_product_code'},
                   
                    {
                        data: '_color_code'
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
             
                ],
                order: [
                    [0, "desc"]
                ],
                lengthMenu:[[10,25,50,-1],[10,25,50,"all"]],
                dom: 'flBrtip',
                buttons: [
                     'csv', 'excel', 'pdf'
                ],
                
            });

    
        });

 


</script>    

@endpush


