@extends('layouts.app')
@section('content')
<div class="container">
        <section >
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Cutting Plans</h4>
                            <a class="btn global_btn_color" href="{{route('master.cuttingplan')}}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>Add</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
     <!-- Table head options start -->
     <div class="row" id="table-head">
        <div class="col-12">
            @if($errors->any())
            <p class="alert alert-danger alert-heading">{{$errors->first()}}</p>
            @endif
            @if(Session::has('message'))
            <p class="alert alert-success alert-heading">{{ Session::get('message') }}</p>
            @endif
            <div class="card">
                <div class="table-responsive">
                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr style="text-align:center;">
                                <th>S no.</th>
                                <th>Cutting Plan No.</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody style="text-align:center;">
                            @foreach ($cutting_plan as $plan)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$plan->plan_season_code}}</td>
                                <td>{{ \Carbon\Carbon::parse($plan->created_at)->format('d-M-Y')}}</td>
                                <td>
                                    <a class="btn btn-sm global_btn_color" href="{{route('plan.detail',['id'=>$plan->id])}}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
                                    <a class="btn btn-sm btn-primary" href="{{route('cutting.pdf',['id'=>$plan->id])}}">PDF</a>
                                    {{-- <a href="{{route('cutting.status.change',['id'=>$plan->id,'status'=>$plan->status])}}" class="{{$plan->status == 0 ? 'btn btn-sm btn-danger' : 'btn btn-sm btn-success'}}">{{$plan->status == 0 ? "Pending" : "Processed"}}</a> --}}
                                    <a href="javascript:void(0)" class="{{$plan->status == 0 ? 'btn btn-sm btn-danger' : 'btn btn-sm btn-success'}}">{{$plan->status == 0 ? "Pending" : "Processed"}}</a>

                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Table head options end -->
</div>


@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush

