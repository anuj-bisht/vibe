


@extends('layouts.app')

@section('content')
<div class="container">

        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Order Number {{$order['ord_id']}} </h4>
                            <a href="{{route('order.index')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="table-head">
                <div class="col-12">
                    <div class="card">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" >
                                <thead class="">
                                    <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">

                                        <th style="text-align:center;">S no.</th>
                                        <th style="text-align:center;">P Code</th>
                                        <th style="text-align:center;">C Code</th>
                                       
                                        @foreach($sizes as $size)
                                        <th  style="text-align:center;">
                                            <?php
                                            $str=explode('/',$size->size);
                                            
                                            $a=$str[0]??'';
                                            $b=$str[1]??'';
                                            echo "$a<br>$b";
                                            ?>
                                        </th>
                                        @endforeach
                                        <th style="text-align:center;">Total Qty</th>
                                        {{-- <th style="text-align:center;">Total Amount</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->detail as $detail)
                                    <tr>
                                        <td  style="text-align:center;">{{$loop->iteration}}</td>
                                        <td style="text-align:center;">{{$detail->product->product_code}}</td>
                                        <td style="text-align:center;">{{$detail->color->color_code}}({{$detail->color->name}})</td>
                                        @foreach ($detail->child as $attribute)
                                        <td style="text-align:center;">{{$attribute->qty}}</td>
                                        @endforeach
                                        </td>
                                        <td style="text-align:center;">{{$detail->total}}</td>
                                        {{-- <td style="text-align:center;">{{$detail->total_amount}}</td> --}}
                                        <td>
                                            <a class="btn btn-sm global_btn_color" data-toggle="modal" data-target="#xlarge{{$detail->id}}" href="{{route('plan.detail.edit',['id'=>$detail->id])}}">
                                               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                  <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                  <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                               </svg>
                                            </a>
                                         </td>
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



@foreach($order->detail as $detail)
<div class="modal fade text-left" id="xlarge{{$detail->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
       <div class="modal-content">
           <div class="modal-header">
               <h4 class="modal-title" id="myModalLabel16">Edit</h4>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
               </button>
           </div>
           <div class="modal-body">
            <form class="table-responsive" action="{{route('update.orderAttribute', ['id' => $detail->id]) }}" method="post">
               @csrf
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: smaller;">
                   <thead class="">
                       <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant; text-align:center;">
                           @foreach($sizes as $size)
                           <th style="padding:0.75rem !important;">
                               <?php
                                $str=explode('/',$size->size);
                                
                                $a=$str[0]??'';
                                $b=$str[1]??'';
                                echo "$a<br>$b";
                                 ?>
                           </th>
                           @endforeach
                           {{-- <th style="padding:0.75rem !important;">Total Qty</th> --}}
                       </tr>
                   </thead>
                   <tbody>
                     <tr style="text-align:center;">
                        @foreach ($detail->child as $attribute)
                        <td><input type="number" onchange='updateTotal();' id="cutting_ratios" value="{{$attribute->qty}}" name="cutting_qtys[{{ $attribute->size_id }}]" class="form-control input"></td>
                        @endforeach
                     </tr>
                   
                   </tbody>
               </table>
               <button class="btn global_btn_color" type="submit">Submit</button>
           </form>
           </div>
          
       </div>
   </div>
</div>
@endforeach
@endsection

