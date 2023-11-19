@extends('retail.layouts.app')

@section('retail_content')
<div class="container">
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pending MRN Listing</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Table head options start -->
     <div class="row" id="table-head">
        <div class="col-12">
            @if(Session::has('message'))
            <p class="alert alert-success alert-heading">{{ Session::get('message') }}</p>
            @endif
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered" id="purchaseListing" width="100%" cellspacing="0" >
                        <thead class="">
                            <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                                <th>Invoice No</th>
                                <th>Retailer Name</th>
                                {{-- <th>Tax</th> --}}
                                <th>Total Pcs</th>
                                {{-- <th>Sub Total</th> --}}
                                {{-- <th>Discount Price</th>
                                <th>Tax Price</th> --}}
                                <th>Grand Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                    {{-- <input type="text" name="" id="search-input">
                    <button class="btn btn-success" id="search-button">Search</button> --}}
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
           $('#purchaseListing').DataTable({
    

                processing: true,
                serverSide: true,
                searchable : true,

              
                ajax: "{!! route('listing.datatable', ['retailer_id'=>$id]) !!}",
                columns: [
                    // {
                    //     data: 'DT_RowIndex'
                    // },
                    {
                        data: 'invoice_no'
                    },
                    {
                        data: 'client.name'
                    },
                    // {
                    //     data: 'tax.name'
                    // },
                    {
                        data: 'total_pcs'
                    },
                  
                    // {
                    //     data: 'sub_total'
                    // },
                    // {
                    //     data: 'discount_price'
                    // },
                    // {
                    //     data: 'tax_price'
                    // },
                    {
                        data: 'grand_total'
                    },
                    {
                        data: 'action', orderable:true, searchable:true
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
