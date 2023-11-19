


@extends('layouts.app')

@section('content')
<div class="container">
        <section class="tooltip-validations" id="tooltip-validation">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Petty Cash Management</h4>
                            {{-- <a class="btn global_btn_color" href="{{route('petty.cash.create')}}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>Add Petty Cash</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if($errors->any())
        <p class="alert alert-danger alert-heading">{{$errors->first()}}</p>
        @endif

        <div class="card-datatable">
            <table class="table table-bordered" id="cashlisting" width="100%" cellspacing="0" style="">
                <thead class="">
                   <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                        <th>Retailer Name</th>
                        <th>Action</th>
                   </tr>
                </thead>
         
             </table>
    
        </div>
  
</div>


@endsection
@push('scripts')
<script>
      $(function() {
            $('#cashlisting').DataTable({
                order: [
                    [1, "desc"]
                ],
                processing: true,
                serverSide: true,
                ajax: "{!! route('pettycash.listing')!!}",
                columns: [
                 
                    {
                        data: 'name'
                    },
                    // {
                    //     data: 'ord_id'
                    // },
                    // {
                    //     data: 'corporate_name'
                    // },
                    // {
                    //     data: 'state_name'
                    // },
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

