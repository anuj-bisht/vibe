@extends('layouts.app')
@section('content')
<div class="container">
        <section class="tooltip-validations" id="tooltip-validation">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Order Listing</h4>
                            <a class="btn global_btn_color" href="{{route('order.create')}}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        @if(Session::has('message'))
        <p class="alert alert-success alert-heading">{{ Session::get('message') }}</p>
        @endif
        <div class="container-fluid" >
            <section id="">
               <div class="row">
                <div class="card">
                    <div class="card-header">
                  <div class="col-md-4">
                            <label> From Date</label>
                            <input type="text" id="from_date" class="form-control flatpickr-basic" name="start_date" placeholder="mm-dd-yyyy" value="{{$start_date}}" />
                  </div>
                  <div class="col-md-4">
                            <label> To Date</label>
                            <input type="text" id="to_date" class="form-control flatpickr-basic" name="start_date" placeholder="mm-dd-yyyy" value="{{ $end_date }}"/>
                  </div>
                  <div class="col-md-4">
                    <label> Client</label>
                    <input type="text" id="search_client" class="form-control" name="search_client" placeholder="Search..." />
          </div>
                </div>
            </div>
                  <div class="col-md-3">
                    
                        <div class="card-header" style="background: #F8F8F8; border: none;">
                            <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                            <button type="button" name="refresh" id="refresh" class="btn btn-primary">Reset</button>
                        </div>
                    
                  </div>
               </div>
            </section>
        </div>

          
    <div class="card-datatable">
        <table class="table table-bordered" id="orderlisting" width="100%" cellspacing="0" style="">
            <thead class="">
               <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                    <th>Order Type</th>
                    <th>Order No</th>
                    <th>Client Name</th>
                    <th>State</th>
                    <th>Date</th>
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
        load_data();

        function load_data(from_date = '', to_date = ''){
            var table = $('#orderlisting').DataTable({
                order: [
                    [1, "desc"]
                ],
                processing: true,
                serverSide: true,
                ajax: {
                  url:"{!! route('order.listing')!!}",
                  data:{
                    from_date:$('#from_date').val(), 
                    to_date:$('#to_date').val(),
                    client:$('#search_client').val(),


                }

                },
                columns: [
                 
                    {
                        data: 'check_order'
                    },
                    {
                        data: 'ord_id'
                    },
                    {
                        data: 'corporate_name'
                    },
                    {
                        data: 'state_name'
                    },
                    {
                        data: 'date'
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
        }

  
    $('#filter').click(function(){
          
          var from_date = $('#from_date').val();
          var to_date = $('#to_date').val();
          var client = $('#search_client').val();


          if(from_date != '' &&  to_date != '' && client != ''){
            $('#orderlisting').DataTable().destroy();
              load_data(from_date, to_date, client);
          }else if(from_date != '' &&  to_date != ''){
            $('#orderlisting').DataTable().destroy();
              load_data(from_date, to_date);
          } else{
              alert('Both Date is required');
          }

      });

      $('#refresh').click(function(){
            $('#from_date').val('');
            $('#to_date').val('');
            $('#search_client').val('');
            $('#orderlisting').DataTable().destroy();
            load_data();
        });
        });
</script>    

@endpush


