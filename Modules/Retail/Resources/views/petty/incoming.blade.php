@extends('retail.layouts.app')
@section('retail_content')
<div class="container">
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Incoming Petty Cash</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <div class="card-datatable">
        <table class="table table-bordered" id="incoming" width="100%" cellspacing="0" style="">
            <thead class="">
                <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                    <th>Action By</th>
                    <th>Type</th>
                    <th>Amount</th>
                    <th>Previos Balance</th>
                    <th>Current Balance</th>
                    <th>Date</th>
                    <th>DOC</th>
                   
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
            $('#incoming').DataTable({
                language: {
                "emptyTable":    '<img style=" width: 100%; max-width: 350px; height: auto;" src="{{asset('nodata.jpg')}}" alt="no">'
               },
                order: [
                    [1, "desc"]
                ],
                processing: true,
                serverSide: true,
                ajax: "{!! route('retailpettycash.listingg')!!}",
                columns: [
                    {
                        data: 'action_by'
                    },
                    {
                        data: 'type'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'old_amount'
                    },
                    {
                        data: 'new_amount'
                    },
                   
                    {
                        data: 'date'
                    },
                    {
                        data: 'doc'
                    },
                    
                    {
                        data: 'action'
                    },
               
                   
                 
                ],
                lengthMenu:[[10,25,50,-1],[10,25,50,"all"]],
                dom: 'flBrtip',
                buttons: [
                     'csv', 'excel', 'pdf'
                ]
            });
        });

</script>

<script>
    function ValidateIncomingCash(id, diff) {

        Swal.fire({
  title: 'Are you sure to add amount to your wallet?',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Add Amount!'
}).then((result) => {
  if (result.isConfirmed) {
    const data = JSON.stringify({ 
                      log_id : id,
                       amount:diff
                    });
                const config = {
                    headers: {'Content-Type': 'application/json'}
                }
        axios.post("{{ route('validate.incoming.cash') }}", data,config).then(res => {
                    window.location.reload();                      
        });
    Swal.fire(
      'Great',
      'Petty Cash Has Been Credit Successfully',
      'success'
    )
  }
})
  }
</script>

@endpush