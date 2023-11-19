@extends('layouts.app')


@section('content')
<div class="container">
        <section class="tooltip-validations" id="tooltip-validation">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Transaction History</h4>
                            <a href="{{route('petty.index')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if($errors->any())
        <p class="alert alert-danger alert-heading">{{$errors->first()}}</p>
        @endif

        <div class="card-datatable">
            <table class="table table-bordered" id="retailtralisting" width="100%" cellspacing="0" style="">
                <thead class="">
                   <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                        <th>Date</th>
                        <th>Previos Balance</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Current Balance</th>
                        <th>Action By</th>
                        <th>Validated</th>
                        <th>Petty Head</th>
                        <th>Doc</th>
                        
                   </tr>
                </thead>
             </table>
        </div>
</div>


@endsection
@push('scripts')
<script>
      $(function() {
            $('#retailtralisting').DataTable({
                order: [
                    [1, "desc"]
                ],
                processing: true,
                serverSide: true,
                ajax: "{!! route('admin.datatransaction.history',['retail_id'=>$retail_id])!!}",
                columns: [
                    {
                        data: 'date'
                    },
                    {
                        data: 'old_amount'
                    },
                    {
                        data: 'type'
                    },
                      
                    {
                        data: 'amount'
                    },
                    {
                        data: 'new_amount'
                    },
                    {
                        data: 'action_by'
                    },
                    {
                        data: 'validated'
                    },
                    {
                        data: 'reason'
                    },
                    {
                        data: 'doc'
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
                    // {
                    //     data: 'action',

                    // },
                   
                 
                ],
                dom: 'fBrtip',
                buttons: [
                     'csv', 'excel', 'pdf'
                ]
            });
        });

</script>    

@endpush

