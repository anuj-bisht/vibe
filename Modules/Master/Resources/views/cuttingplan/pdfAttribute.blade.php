
<div class="container" id="view_attribute">
    <section id="basic-input">
       <div class="row">
          <div class="col-md-12">
             <div class="card">
                <div class="card-header">
                   <h4 class="card-title">Plan Name : {{$cutting_plan->plan_season_code}}</h4>
                   <h4 class="card-title">Cutting Plan Created Date : {{ Carbon\Carbon::parse($cutting_plan->created_at)->format('d-F Y ') }}</h4>
                </div>
             </div>
          </div>
       </div>
 
       <div class="row" id="table-head">
          <div class="col-12">
             <div class="card">
                
                   <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="">
                      <thead class="">
                         <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                            <th >S no.</th>
                            <th>P Code</th>
                            <th >C Code</th>
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
                            <th >Total Qty</th>
                         </tr>
                      </thead>
                      <tbody>
                         @foreach($cutting_plan->detail as $detail)
                         <tr style="text-align:center;">
                            <td >{{$loop->iteration}}</td>
                            <td >{{$detail->product->product_code}}</td>
                            <td>{{$detail->color->color_code}}({{$detail->color->name}})</td>
                            @foreach ($detail->child as $attribute)
                            <td >{{$attribute->qty}}</td>
                            @endforeach
                            <td >{{$detail->sum}}</td>
                         </tr>
                         @endforeach
                      </tbody>
                   </table>
             </div>
             @if($detail->status == 'pending')
             <a class="btn global_btn_color"  type="button" href="{{route('plan.validated',['id'=>$cutting_plan->id])}}">Validate</a>
             @endif
  