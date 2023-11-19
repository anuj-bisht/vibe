@extends('layouts.app')
@section('content')
<div class="container" id="view_attribute">
   <section id="basic-input">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <div class="card-header">
                  <h4 class="card-title">Quantities</h4>
                  <a href="{{route('warehouse.index')}}" class="btn btn-sm" style="background-color: #009973; color:white;"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a>
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
                      
                           @foreach($size as $size)
                           <th  style=" text-align:center;">
                              <?php
                              $str=explode('/',$size->size);
                              $a=$str[0]??'';
                              $b=$str[1]??'';
                              echo "$a<br>$b";
                               ?>
                           </th>
                           @endforeach
                        </tr>
                     </thead>
                     <tbody>
                        <tr style="text-align:center;">
                           
                           @foreach ($qtys as $attribute)
                           <td >{{$attribute->qty}}</td>
                           @endforeach
                         
                          
                        </tr>
                     </tbody>
                
                  </table>

            </div>
          
         </div>
      </div>
</div>
</section>
</div>


 
@endsection

