@extends('layouts.app')

@section('content')
<div class="container">
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Audit Listing</h4>
                        <a class="btn global_btn_color" href="{{route('stock.audit')}}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>Audit Listing Form</a>

                    </div>
                </div>
            </div>
        </div>
    </section>
    @if(Session::has('message'))
    <p class="alert alert-success alert-heading">{{ Session::get('message') }}</p>
    @endif
    <!-- Table head options start -->
    <div class="">
        <table class="table" id="dataTable" width="100%" cellspacing="0">
            <tbody>
                <thead class="">
                    <tr>
                        <th>Sno.</th>
                        <th>Audit Number</th>
                        <th>Actions</th>
                    </tr>
                    @foreach ($data as $audit)
                    <tr id="order{{$audit->id}}">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$audit->audit_no}}</td>
                        <td><a class="btn btn-sm global_btn_color" href="{{route('stock.audit.view',['id'=>$audit->id])}}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                    <circle cx="12" cy="12" r="3"></circle>
                                </svg></a></td>

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
