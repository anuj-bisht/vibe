


@extends('layouts.app')

@section('content')
<div class="container">

        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"> Good Return </h4>
                            <a href="{{route('goods.returns.index')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h6 >Warehouse Name : {{$good_return_detail['warehouse']['name']}} </h6>
                            <h6 >Client Name : {{$good_return_detail['client']['name']}} </h6>
                            {{-- <h6 >Return Date : {{ \Carbon\Carbon::parse($gsm_time)->format('d-M-Y')}} </h6> --}}
                            

                        </div>
                    </div>
                </div>
            </div>
            @if(count($good_return_detail->detail) > 0)
            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"> UnDefective Product </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: smaller;">
                                <thead class="">
                                    <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">

                                        <th style="padding:0.75rem !important;">S no.</th>
                                        <th style="padding:0.75rem !important;">P CODE</th>
                                        <th style="padding:0.75rem !important;">C CODE</th>
                                       

                                        @foreach($sizes as $size)
                                        <th  style="padding:0.75rem !important; text-align:center;">
                                           <?php
                                           $str=explode('/',$size->size);
                                           
                                           $a=$str[0]??'';
                                           $b=$str[1]??'';
                                           echo "$a<br>$b";
                                            ?>
                                        </th>
                                        @endforeach
                                        <th style="padding:0.75rem !important;">Total Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($good_return_detail->detail as $detail)
                                    <tr>
                                        <td  style="padding:0.75rem !important;">{{$loop->iteration}}</td>
                                        <td style="padding:0.75rem !important;">{{$detail->product->product_code}}</td>
                                        <td style="padding:0.75rem !important;">{{$detail->color->color_code}}({{$detail->color->name}})</td>
                                        @foreach ($detail->child as $attribute)
                                        <td style="padding:0.75rem !important;">{{$attribute->qty}}</td>
                                        @endforeach
                                        <td style="padding:0.75rem !important;">{{$detail->total}}</td>


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(count($good_return_detail->defective_goods_sub_masters) > 0)
            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title"> Defective Product </h4>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: smaller;">
                                <thead class="">
                                    <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">

                                        <th style="padding:0.75rem !important;">S no.</th>
                                        <th style="padding:0.75rem !important;">P Code</th>
                                        <th style="padding:0.75rem !important;">C Code</th>
                                        @foreach($sizes as $size)
                                        <th  style="padding:0.75rem !important; text-align:center;">
                                            <?php
                                            $str=explode('/',$size->size);
                                            
                                            $a=$str[0]??'';
                                            $b=$str[1]??'';
                                            echo "$a<br>$b";
                                            ?>
                                        </th>
                                        @endforeach
                                        <th style="padding:0.75rem !important;">Total Qty</th>

                                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($good_return_detail->defective_goods_sub_masters as $det)
                                    <tr>
                                        <td  style="padding:0.75rem !important;">{{$loop->iteration}}</td>
                                        <td style="padding:0.75rem !important;">{{$det->product->product_code}}</td>
                                        <td style="padding:0.75rem !important;">{{$det->color->color_code}}({{$det->color->name}})</td>
                                        @foreach ($det->child as $attribute)
                                        <td style="padding:0.75rem !important;">{{$attribute->qty}}</td>
                                        @endforeach
                                        <td style="padding:0.75rem !important;">{{$det->total}}</td>


                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        </section>

</div>
@endsection


