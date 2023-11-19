@extends('layouts.app')

@section('content')
<div class="container">
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Corporate Master</h4>
                        <a class="btn global_btn_color" href="{{route('corporate.create')}}" type="submit"><svg
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
    @if(Session::has('message'))
    <p class="alert alert-success alert-heading">{{ Session::get('message') }}</p>
    @endif

    <div class="container-fluid">
        <section id="">
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <div class="col-md-12">
                            <label> State</label>
                            <select class="form-control " id="state" name="state">
                                <option disabled data-set="1" selected>Select State</option>
                                @foreach($states as $state)
                                <option value={{$state->id}}>{{$state->name}}</option>
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
    </div>
    <div class="table-responsive">
        <table class="table" id="clientlisting" width="100%" cellspacing="0">
            <tbody>
                <thead class="">
                    <tr>
                        <th>Client Name</th>
                        <th>State</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>

                </thead>
            </tbody>
        </table>
    </div>
    <!-- Table head options end -->
</div>
@endsection
@push('scripts')
<script>
    $(function() {
        load_data();

        function load_data(){
            var table = $('#clientlisting').DataTable({
                order: [
                    [1, "desc"]
                ],
                processing: true,
                serverSide: true,
                ajax: {
                  url:"{!! route('corporate.listing')!!}",
                  data:{
                    state_id:$('#state').val(), 
                }

                },
                columns: [
                 
                    {
                        data: 'name'
                    },
                    {
                        data: 'billing_state_name'
                    },
                    {
                        data: 'status'
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

  
        $('#filter').click(function() {
            var state = $('#state').find(':selected').val();
            if (state != 'Select State' && state != null) {
                $('#clientlisting').DataTable().destroy();
                load_data();
            } else {
                alert('Select State');
            }

        });
        $('#refresh').click(function() {
            $('#state').val('');
            $('#clientlisting').DataTable().destroy();
            load_data();
        });
        });
</script>
@endpush
{{--
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>
    function deleteProduct(id){

            swal({

        text: "Are You Want to Delete This Product!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
                })
                .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        method:'GET',
                        url:"{{URL::to('product/delete')}}/"+id,
                        success:function(response){
                            $('#product'+id).remove();
                        }
                    });
                    swal("Category has been deleted!", {
                    icon: "success",
                    });
                } else {
                    swal("Safe!");
                }
                });
             }
</script> --}}