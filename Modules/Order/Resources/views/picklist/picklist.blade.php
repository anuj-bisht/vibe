


@extends('layouts.app')

@section('content')
<div class="container">

        


        @if(Session::has('message'))
        <p class="alert alert-success alert-heading">{{ Session::get('message') }}</p>
        @endif
        <div class="container-fluid" id="basic-inputt">
            <section id="">
               <div class="row">
                <div class="card">
                    <div class="card-header">
                  <div class="col-md-6">
                            <label> From Date</label>
                            <input type="text" id="from_date" class="form-control flatpickr-basic" name="start_date" placeholder="mm-dd-yyyy" value="{{ $start_date }}"/>
                  </div>
                  <div class="col-md-6">
                            <label> To Date</label>
                            <input type="text" id="to_date" class="form-control flatpickr-basic" name="start_date" placeholder="mm-dd-yyyy" value="{{ $end_date }}"/>
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
        <table class="table table-bordered" id="picklisting" width="100%" cellspacing="0" style="">
            <thead class="">
               <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                    <th>Picklist No</th>
                    <th>State</th>
                    <th>Client</th>
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
            var table = $('#picklisting').DataTable({
                order: [
                    [1, "desc"]
                ],
                processing: true,
                serverSide: true,
                ajax: {
                  url:"{!! route('picklist.listing')!!}",
                  data:{
                    from_date:$('#from_date').val(), 
                    to_date:$('#to_date').val()}

                },
                columns: [
                 
                    {
                        data: 'picklist_no'
                    },
                    {
                        data: 'state_name'
                    },
                    {
                        data: 'corporate_name'
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

          if(from_date != '' &&  to_date != ''){
              $('#picklisting').DataTable().destroy();
              load_data(from_date, to_date);
          } else{
              alert('Both Date is required');
          }

      });

      $('#refresh').click(function(){
            $('#from_date').val('');
            $('#to_date').val('');
            $('#picklisting').DataTable().destroy();
            load_data();
        });
        });
</script>    

@endpush




