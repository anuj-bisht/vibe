<div class="container" id="view_attribute">
   <section id="basic-input">
      <div class="row">
         <div class="col-md-12">
            <div class="card">
               <h4>Client Name : {{$picklist->corporate_profiles->name}}</h4>
               <h4>Client Address: {{$picklist->corporate_profiles->billing_address}}</h4>
            </div>
         </div>
      </div>

      <div class="row" id="table-head">
         <div class="col-12">
            <div class="card">
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="">
                  <thead class="">
                     <tr style="background-color: rgb(50, 173, 137) !important; color: white !impotant;">
                        <th>S no.</th>
                        <th>P Code</th>
                        <th>C Code</th>
                        @foreach($sizes as $size)
                        <th style=" text-align:center;">
                           <?php
                              $str=explode('/',$size->size);
                              $a=$str[0]??'';
                              $b=$str[1]??'';
                              echo "$a<br>$b";
                               ?>
                        </th>
                        @endforeach
                        <th>Total Qty</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($picklist->detail as $detail)
                     <tr style="text-align:center;">
                        <td>{{$loop->iteration}}</td>
                        <td>{{$detail->product->product_code}}</td>
                        <td>{{$detail->color->color_code}}</td>
                        @foreach ($detail->child as $attribute)
                        <td>{{$attribute->qty}}</td>
                        @endforeach
                        <td>{{$detail->total}}</td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>

            </div>

         </div>
      </div>
</div>
</section>
</div>