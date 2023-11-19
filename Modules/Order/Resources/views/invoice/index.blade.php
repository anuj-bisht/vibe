@extends('layouts.app')

@section('content')
<div class="container">
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Invoice Listing</h4>
                        <span>
                            
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid" id="basic-inputt">
        <section id="">
           <div class="row">
            <div class="card">
                <div class="card-header">
              <div class="col-md-6">
                        <label> From Date</label>
                        <input type="text" id="from_date" class="form-control flatpickr-basic" name="start_date" placeholder="mm-dd-yyyy" value="{{$start_date}}"/>
              </div>
              <div class="col-md-6">
                        <label> To Date</label>
                        <input type="text" id="to_date" class="form-control flatpickr-basic" name="start_date" placeholder="mm-dd-yyyy" value="{{$end_date}}"/>
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
    
    <!-- Table head options start -->
     <div class="row" id="table-head">
        <div class="col-12">
            @if(Session::has('message'))
            <p class="alert alert-success alert-heading">{{ Session::get('message') }}</p>
            @endif
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-bordered" id="invoiceListing" width="100%" cellspacing="0" >
                        <thead class="">
                            <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                                <th>Invoice No</th>
                                <th>Client Name</th>
                                <th>Total Pcs</th>
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
        load_data();

        function load_data(from_date = '', to_date = ''){
           $('#invoiceListing').DataTable({
            // initComplete:function(){
            //         this.api().columns().every( function(){
            //             var column = this;
            //             var select = $('<select><option value=""></option></select>')
            //             .appendTo( $(column.header()).empty())
            //             .on('change', function() {
            //                 var val = $.fn.dataTable.util.escapeRegex(
            //                     $(this).val()
            //                 );

            //                 column
            //                 .search( val ? '^'+val+'$' : '', true, false)
            //                 .draw();
            //             });

            //             column.data().unique().sort().each(function(d,j) {
            //                 select.append('<option value="'+d+'">'+d+'</option>')
            //             }  );
            //         });
            //     },


                processing: true,
                serverSide: true,
                searchable : true,
                ajax: {
                  url:"{!! route('picklist.invoice.listing')!!}",
                  data:{
                    from_date:$('#from_date').val(), 
                    to_date:$('#to_date').val()}

                },

                columns: [
                    // {
                    //     data: 'DT_RowIndex'
                    // },
                    {
                        data: 'invoice_no'
                    },
                    {
                        data: 'corporate_name'
                    },
                   
                    {
                        data: 'total_pcs'
                    },
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
        }

            // $('#search-button').on('click',function(){
            //     table.search($('#search-input').val()).draw();
            // });
            $('#filter').click(function(){
          
          var from_date = $('#from_date').val();
          var to_date = $('#to_date').val();

          if(from_date != '' &&  to_date != ''){
              $('#invoiceListing').DataTable().destroy();
              load_data(from_date, to_date);
          } else{
              alert('Both Date is required');
          }

      });

      $('#refresh').click(function(){
            $('#from_date').val('');
            $('#to_date').val('');
            $('#invoiceListing').DataTable().destroy();
            load_data();
        });
        });

 


</script>    

@endpush
