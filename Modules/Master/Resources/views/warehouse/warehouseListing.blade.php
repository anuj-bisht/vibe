


@extends('layouts.app')

@section('content')
<div class="container">
        <section >
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">All Warehouse</h4>
                            <a class="btn global_btn_color" href="{{route('warehouse.create')}}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus mr-25"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>Add</a>

                        </div>

                    </div>
                </div>
            </div>
        </section>
     <!-- Table head options start -->
     <div class="row" id="table-head">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table" id="dataTable" width="100%" cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>Warehouse Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($warehouse as $warehouse_detail)
                            <tr>
                                <td>{{ $warehouse_detail->name }}</td>
                                <td>
                                    @if($warehouse_detail->default_status==0)
                                      <a class="btn btn-sm global_btn_color" href="{{route('changeDefaultStatus',['id'=>$warehouse_detail->id,'status'=>1])}}" type="submit">Set Default</a>
                                     @else
                                     <a class="btn btn-sm btn-primary" href="javascript:void(0)" type="submit">Default</a>
                                     @endif
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
@include('scripts.script')

