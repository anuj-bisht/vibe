@extends('layouts.app')

@section('content')
<div class="container">
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Customer</h4>
                        <a class="btn global_btn_color" href="{{route('customer.create')}}" type="submit"><svg
                                xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-plus mr-25">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>Add</a>
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
                    <table class="table table-bordered" id="customerListing" width="100%" cellspacing="0" >
                        <thead class="">
                            <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
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
            $('#customerListing').DataTable({
                order: [
                    [1, "desc"]
                ],
                processing: true,
                serverSide: true,
                searchable : true,
              
                ajax: "{!! route('customer.listing') !!}",
                columns: [
                    // {
                    //     data: 'DT_RowIndex'
                    // },
                    {
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'mobile'
                    },
                    {
                        data: 'action',
                    },
                 
                ],
                dom: 'fBrtip',
                buttons: [
                     'csv', 'excel', 'pdf'
                ]
            });
        });

 


</script>    

@endpush
