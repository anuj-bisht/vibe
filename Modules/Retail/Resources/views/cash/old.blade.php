@extends('retail.layouts.app')

@section('retail_content')
<div class="container">
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Cash Transfer</h4>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<div class="row" style="justify-content: end;">
    <div class="col-md-3 col-12" style="display: flex; justify-content: end; padding:0 10px 10px;">
        <a href="{{ route('retail.cash.deposit')}}"  class="btn btn-sm btn-primary">
           Cash Deposit History
        </a>
    </div>
</div>
<div class="row match-height" id="customer_cash">
    <!-- Company Table Card -->
    <div class="col-lg-8 col-12">
        <div class="card card-company-table">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr class="text-center">
                                <th class="text-left">Action</th>
                                <th>Date</th>
                                <th>Cash</th>
                            </tr>
                        </thead>
                        <tbody>
                         
                            <tr class="text-center" v-for="(data, v) in cashData" :key = "v">
                               <td >
                                    <input type="checkbox" class="form-control" style="width:15px;" v-model = "cashData[v].check">
                                </td>
                              
                                <td class="text-nowrap">
                                    <div class="">
                                        <span class=""> @{{data.date}}</span>
                                    </div>
                                </td>
                                <td>
                                    <div class="">
                                        <span class="">@{{data.total}}</span>
                                    </div>
                                </td>
                            </tr>          
                        </tbody>
                        <tbody>
                            <tr class="" >
                               <td class="text-nowrap"  style= "display: flex; align-items: center;" >
                                <span v-if="pending > 0"><input type="checkbox" class="form-control" style="width:15px;" v-model = "pendingCheck"></span>
                                  &nbsp;&nbsp; <span> Pending : @{{pending}} </span>
                                </td>
                            </tr>    
                            <tr class="" >
                                <td class="text-nowrap"  style= "display: flex; align-items: center;" >
                                 <span style="">Last Debited Date : {{$last_date->date ?? ''}}</span>
                                 </td>
                             </tr>      
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--/ Company Table Card -->

    
    <div class="col-lg-4 col-md-6 col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Total Cash</h4>
                <i data-feather="help-circle" class="font-medium-3 text-muted cursor-pointer"></i>
            </div>
            <div class="card-body p-0" >
                <div id="goal-overview-radial-bar-chart" class="my-2"></div>
                <div class="row border-top text-center mx-0">
                    <div class="col-12 border-right py-1">
                        <p class="card-text text-muted mb-0">Pending</p>

                        <h3 class="font-weight-bolder mb-0">@{{totalCash}}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-2 ">
        <div class="card">
                 <button class="btn btn-sm global_btn_color" style="background-color: #009973; color:white; border-radius: 10px" @@click = "showpopup">Deposit Cash</button>
        </div>
    </div>
    <form id="grnformm" method="post" action="{{ route('transferCash') }}">
        @csrf
        <input type="hidden" id="grndataa" name="data">
     </form>
</div>

@endsection
@push('scripts')


<script>
var app = new Vue({
    el: '#customer_cash',
     data: {
       cashData : @json($cash),
       pending : "{{(int)$pending->pending}}",
       pendingCheck:false,
       deposit:0,
       formData:"",
       calculativeAmount : 0,
    },

    methods: {
        submitData() {
          var vm = this;
          var formData = {};
          formData.cashData=vm.cashData;
          formData.deposit=vm.deposit;
          formData.pending=vm.pending;
          formData.pendingCheck=vm.pendingCheck;
          vm.formData = JSON.stringify(formData);
          document.getElementById("grndataa").value = vm.formData;
          document.getElementById("grnformm").submit();
      },
    
     showpopup(){
        vm = this;
        vm.calculativeAmount = 0
        for(var i=0; i < vm.cashData.length; i++){
            if(vm.cashData[i].check == true){
            vm.calculativeAmount += parseInt(vm.cashData[i].total);
            }
        }
        if(vm.pendingCheck == true){
            vm.calculativeAmount = vm.calculativeAmount + (+vm.pending) ;
        }

        if(vm.calculativeAmount  == 0 ){
                        return toastr['success']('Please select the amount', '', {
                            closeButton: true,
                            tapToDismiss: false,
                            progressBar: true,
                        });
                }        
        
        Swal.fire({
            title: `Deposit Cash =  ${vm.calculativeAmount}`,
            html: `<input  type="number" placeholder="Enter Amount" id="my-input" value=0 class="swal2-input">`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Deposit Cash!',
            inputPlaceholder: "Enter Amount"
            
            }).then((result) => {
            if (result.isConfirmed) {
                vm.deposit = document.getElementById("my-input").value;
               if(vm.pendingCheck == false){
                if(this.totalCash < vm.deposit){
                        return toastr['success']('Please Enter  Less Amount Than Total Amount', '', {
                            closeButton: true,
                            tapToDismiss: false,
                            progressBar: true,
                        });
                        }
               }else{
                if(this.totalCash + (+vm.pending) < vm.deposit){
                        return toastr['success']('Please Enter  Less Amount Than Total Amount', '', {
                            closeButton: true,
                            tapToDismiss: false,
                            progressBar: true,
                        });
                        }
               }
              
                if(vm.deposit  == 0 ){
                        return toastr['success']('Please Fill Some Amount', '', {
                            closeButton: true,
                            tapToDismiss: false,
                            progressBar: true,
                        });
                }        
                        this.submitData();

                Swal.fire(
                'Deposit!',
                'Your Cash Has Been Deposited.',
                'success'
                )
            
            }else{
                Swal.fire(
                'Not Deposit!',
                'Safe.',
                'success'
                )
            }
            })

     },
    },
    computed: {
    totalCash() {
        vm=this;
      return vm.cashData.reduce((acc, item) => acc + parseInt(item.total), 0);
    }
},


})
</script>
@endpush
