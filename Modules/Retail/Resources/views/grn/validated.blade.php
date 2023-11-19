@extends('retail.layouts.app')
@section('retail_content')
<div class="container">
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Validated Grn</h4>
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
                    <table class="table table-bordered" id="grnPendingListing" width="100%" cellspacing="0" >
                        <thead class="">
                            <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                                <th>Grn No</th>
                                <th>Corporate Profile</th>
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
           $('#grnPendingListing').DataTable({
      


                processing: true,
                serverSide: true,
                searchable : true,

              
                ajax: "{!! route('retail.grnValidatedListing') !!}",
                columns: [
                  
                    {
                        data: 'grn_no'
                    },
                    {
                        data: 'corporate_profile.name'
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
