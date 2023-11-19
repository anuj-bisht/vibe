


@extends('layouts.app')

@section('content')
<div class="container">

        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Invoice Number {{$invoice['invoice_no']}} </h4>
                            <a class="btn btn-sm global_btn_color" href="{{ url()->previous() }}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="card">
                        <div >
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
                                <thead class="">
                                    <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                                        <th>S no.</th>
                                        <th  style="text-align:center;" >P Code</th>
                                        <th  style="text-align:center;" >C Code</th>
                                        @foreach($sizes as $size)
                                        <th  style=" text-align:center;">
                                           <?php
                                           $str=explode('/',$size->size);
                                           
                                           $a=$str[0]??'';
                                           $b=$str[1]??'';
                                           echo "$a<br>$b";
                                            ?>
                                        </th>
                                        @endforeach
                                        <th  style="text-align:center;" >Total Qty</th>
                                        <th  style="text-align:center;" >Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody  style="text-align:center;" >
                                    @foreach($invoice->detail as $detail)
                                    <tr>
                                        <td >{{$loop->iteration}}</td>
                                        <td>{{$detail->product->product_code}}</td>
                                        <td>{{$detail->color->color_code}}({{$detail->color->name}})</td>
                                        @foreach ($detail->child as $attribute)
                                        <td>{{$attribute->qty}}</td>
                                        @endforeach
                                        </td>
                                        <td>{{$detail->qty}}</td>
                                        <td>{{$detail->total}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </section>
</div>
@endsection


