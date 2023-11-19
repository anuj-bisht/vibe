@extends('layouts.app')

@section('content')
<div class="container">
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Invoice difference Listing</h4>
                        <a href="{{route('picklist.invoice.difference')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
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
                    <table class="table table-bordered" id="invoiceDifferenceListing" width="100%" cellspacing="0" >
                        <thead class="">
                            <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                                <th>Invoice No</th>
                                <th>Client Name</th>
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
           $('#invoiceDifferenceListing').DataTable({
        

                processing: true,
                serverSide: true,
                searchable : true,

              
                ajax: "{!! route('picklist.dtinvoice.difference') !!}",
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

            // $('#search-button').on('click',function(){
            //     table.search($('#search-input').val()).draw();
            // });
        });

 


</script>    

@endpush
