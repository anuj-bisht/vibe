


@extends('layouts.app')

@section('content')
<div class="container">




        <section >
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Gender Master</h4>

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
                                <th>Sno.</th>
                                <th>Name</th>
                                <th>Short Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $gender)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$gender->name}}</td>
                                <td >{{$gender->name == "Gents" ? 'G' : 'L'}}</td>
                                
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

