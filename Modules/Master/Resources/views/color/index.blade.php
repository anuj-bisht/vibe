@extends('layouts.app')

@section('content')
<div class="container">

    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Color Master</h4>
                        <a class="btn global_btn_color" href="{{route('master.color.create')}}" type="submit"><svg
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
                        <thead>
                            <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                                <th>Sno.</th>
                                <th>Name</th>
                                <th>Code</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $color)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$color->name}}</td>
                                <td>{{$color->color_code}}</td>
                                <td><a class="btn btn-sm global_btn_color"
                                        href="{{route('master.color.edit',['id'=>$color->id])}}" type="submit"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                        </svg></a></td>
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

@include('scripts.script')