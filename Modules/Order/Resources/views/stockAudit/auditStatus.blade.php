@extends('layouts.app')

@section('content')
<div class="container" id="status_section">
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Prodcut Audit Status</h4>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Table head options start -->
    <div class="">
        <table class="table" id="dataTable" width="100%" cellspacing="0">
            <tbody>
                <thead class="">
                    <tr>
                        <th>Sno.</th>
                        <th>Warehouse</th>
                        <th>Product Code</th>
                        <th>Color Code</th>
                        <th>Actions</th>
                    </tr>
                    @foreach ($products as $data)
                    <tr >
                        <td>{{$loop->iteration}}</td>
                        <td>{{$data->warehouses->name}}</td>
                        <td>{{$data->product_masters->product_code}}</td>
                        <td>{{$data->color->color_code}}</td>
                        <td><button class="btn btn-danger" id="auditButton" data-index="7" > @if($data->check_audit==1) Disable @endif</button></td>

                    </tr>
                    @endforeach
                </thead>
            </tbody>
        </table>
    </div>
    <!-- Table head options end -->
</div>



@endsection
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.2.1/axios.min.js" integrity="sha512-zJYu9ICC+mWF3+dJ4QC34N9RA0OVS1XtPbnf6oXlvGrLGNB8egsEzu/5wgG90I61hOOKvcywoLzwNmPqGAdATA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script>
    var app = new Vue({
        el: '#status_section',
        data: {
            
          

        },

        methods: {
              handleClick:function(){
                vm=this;
                axios.get(`{{ url('/getAllProduct') }}/${vm.warehouse_id}`).then(res => {
                
                })
              },
            
          
        
            
          

        },
       
         computed: {
            // buttonStatus: function() {
            //     vm = this;
            //     if (vm.audit == 0) {
            //         vm.buttonText = "Enable";
            //     } else {
            //         vm.buttonText = "Disable";
            //     }
            //     return (vm.audit == 0) ? 'btn btn-success' : 'btn btn-danger ';
            // },
          

        }
        , watch: {

        }
    })



   



@endsection
