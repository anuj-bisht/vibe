


@extends('layouts.app')

@section('content')
<div class="container">




        <section class="tooltip-validations" id="tooltip-validation">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Publish Picklist</h4>
                        </div>

                    </div>
                </div>
            </div>
        </section>




     <!-- Table head options start -->
     <div class="table-responsive">
        <table class="table" id="dataTable" width="100%" cellspacing="0">
            <tbody>
                <thead class="" >
                    <tr>
                        <th>Sno.</th>
                        <th>Picklist No.</th>
                        <th>State</th>
                        <th>Client Name</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                    @foreach ($data as $publish_picklist)
                    <tr id="listing{{$publish_picklist->id}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$publish_picklist->picklist_validator_no}}</td>
                        <td>{{$publish_picklist->states->name}}</td>
                        <td>{{$publish_picklist->corporate_profiles->name}}</td>
                        <td>{{$publish_picklist->order_master->ord_id}}</td>

                        <td><a class="btn btn-sm global_btn_color" href="{{route('publish.picklist.view',['id'=>$publish_picklist->id])}}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
                    </tr>
                    @endforeach
                      

                </thead>

            </tbody>
        </table>
    </div>
    <!-- Table head options end -->
</div>



@endsection
@include('scripts.script')



