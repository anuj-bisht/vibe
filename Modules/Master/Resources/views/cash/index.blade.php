@extends('layouts.app')

@section('content')

<div class="container">
        <section class="tooltip-validations" id="tooltip-validation">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Transaction History</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        


        <section id="">
            <div class="row">
             <div class="card">
                 <div class="card-header">
               <div class="col-md-4">
                         <label> From Date</label>
                         <input type="text" id="from_date" class="form-control flatpickr-basic" name="start_date" placeholder="mm-dd-yyyy" />
               </div>
               <div class="col-md-4">
                         <label> To Date</label>
                         <input type="text" id="to_date" class="form-control flatpickr-basic" name="start_date" placeholder="mm-dd-yyyy" />
               </div>
               <div class="col-md-4">
                <label>Retailer</label>
                <select class="form-control" name="retail_id" id="retail_id">
                    <option  disabled selected value = "0"> Select Retailer</option>
                    @foreach($retail as $retailer)
                    <option value="{{$retailer->id}}">{{$retailer->name}}</option>
                    @endforeach
                </select>
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


        <div class="card-datatable">
            <table class="table table-bordered" id="admincashhistory" width="100%" cellspacing="0" style="">
                <thead class="">
                   <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                        <th>Deposit By</th>
                        <th>Deposit Amount</th>
                        {{-- <th>Date</th> --}}
                        <th>Deposit Date</th>
                        
                        
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

function load_data(from_date = '', to_date = '', retail_id = ''){
    var table = $('#admincashhistory').DataTable({
       
                order: [
                    [1, "desc"]
                ],
                processing: true,
                serverSide: true,
                ajax: {
                  url:"{!! route('cash.transfer.datatable')!!}",
                  data:{
                    from_date:$('#from_date').val(), 
                    to_date:$('#to_date').val(),
                    retail_id : $('#retail_id').find(":selected").val(),

                }

                },
                columns: [
                    {
                        data: 'retail'
                    },
                    {
                        data: 'deposit_amount'
                    },
                    // {
                    //     data: 'cash_date'
                    // },
                    {
                        data: 'deposit_date'
                    },
                  
                    
                   
                 
                ],
                lengthMenu:[[10,25,50,-1],[10,25,50,"all"]],
                dom: 'flBrtip',
                buttons: [
                     'csv', 'excel', 'pdf'
                ]
            });
        }


            $('#filter').click(function(){
          
          var from_date = $('#from_date').val();
          var to_date = $('#to_date').val();
          var retail_id = $('#retail_id').find(":selected").val();


          if(from_date != '' &&  to_date != '' && retail_id != ''){
              $('#admincashhistory').DataTable().destroy();
              load_data(from_date, to_date, retail_id);
          } else{
              alert('Both Date is required');
          }

      });

      $('#refresh').click(function(){
            $('#from_date').val('');
            $('#to_date').val('');
            $('#retail_id').val('');
            $('#admincashhistory').DataTable().destroy();
            load_data();
        });
        });

</script>    

@endpush

