@extends('layouts.app') 
@include('styles.style')
 @section('content') 
 <link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">
 @include('styles.style')
 <style>
     .table-bordered{
        border-color:black !important;
    }
    .tp{
        padding:0px !important;
    }
      .vs--searchable .vs__dropdown-toggle{
        height:38px;
      }
 </style>
  <div class="container" id="picklist">
        <section id="">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title" style="color:black; ">Pickist</h4>
                <span>
                  <a href="javascript:void(0)" class="btn btn-sm" style="background-color: #009973; color:white;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
                      <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                      <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                  </a>
                </span>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section  >
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-4 col-12">
                    <div class="form-group">
                      <label for="city-column" style="color:black; ">State  </label>
                   
                         <input type="text" readonly class="form-control" id="state" name="state" data-index="1" v-model="stateSelected" >
                      
                    </div>
                  </div>
                  <div class="col-md-4 col-12">
                    <div class="form-group">
                      <label for="city-column" style="color:black; ">Client</label>
                      <input type="text" readonly class="form-control" id="state" name="client" data-index="1"  v-model="clientSelected" >

                    </div>
                  </div>
                  <div class="col-md-4 col-12">
                    <div class="form-group">
                      <label for="city-column" style="color:black; ">Order No</label>
                      <input type="text" readonly class="form-control" id="order" name="order" data-index="1"  v-model="orderSelected" >

                    </div>
                  </div>
                
                  
                  

                  {{-- <div class="col-md-4 col-4">
                    <select id="warehouse" class="form-control" name="order" v-model="warehouse"  v-select2  >
                      <option disabled value="">Select Warehouse</option>
                      <option v-for="warehouse in warehouses" :value="warehouse"> @{{warehouse.name}} </option>
                   </select>
                  </div> --}}
                  <div class="col-md-1 col-1"> <button class="btn global_btn_color" @@click="generatePicklist" >Get</button></div>

                  <div class="col-md-7 col-7 " style="text-align:last;"> <button class="btn global_btn_color" data-toggle="modal" data-target="#xlargeshowDetail">Order Detail</button></div>


                </div>
              </div>
            </div>
          </div>
        </div>
      </section>



        <div class="modal fade text-left" id="xlargeshowDetail" tabindex="-1" role="dialog" aria-labelledby="myModalLabel16" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel16">View Order Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                  <table class="table" id="ordertable" width="100%" cellspacing="0">
                    <thead class="" >
                        <tr>
                            <th style='text-align:center;'>P Code</th>
                            <th style='text-align:center;'>C Code</th>
                            @foreach($sizes as $size)
                                        <th  style="text-align:center; text-align:center;">
                                           <?php
                                           $str=explode('/',$size->size);
                                           
                                           $a=$str[0]??'';
                                           $b=$str[1]??'';
                                           echo "$a<br>$b";
                                            ?>
                                        </th>
                                        @endforeach
                            <th style='text-align:center;'>Total</th>
                        </tr>
                    </thead>
                    
                     <tbody id="orderdata">

                      <tr id="" v-for="c in orderData" >
                         <td style='text-align:center;' class="tp" > @{{ c.product.product_code}} </td>
                        <td style='text-align:center;' class="tp"> @{{ c.color.color_code}}</td>
                        <td style='text-align:center;' v-for="ochild in c.child">@{{ochild.qty}}</td>
                        <td style='text-align:center;'>@{{c.total}}</td>
                      </tr>


                    </tbody>
                </table>
                 
                </div>
               
            </div>
        </div>
    </div>  



    




     

  </div>


   @endsection



@push('scripts')
  <script>

  Vue.directive('select2',{
      inserted(el){
          $(el).on('select2:select', ()=>{
              const event = new Event('change', {bubbles:true, cancelable:true});
              el.dispatchEvent(event);
          });

          $(el).on('select2:unselect', ()=>{
              const event = new Event('change', {bubbles:true, cancelable:true});
              el.dispatchEvent(event);
          });
      }
  });


  var app = new Vue({
              el: '#picklist',
              data: {
                m:@json($picklist_data),
                sizes:@json($sizes),
                orderData:@json($picklist_data->detail),
                autoGeneratePicklistNo:{{ $picklistNumber }},
                stateSelected:@json($picklist_data->states->name),
                stateSelected_id:@json($picklist_data->states->id),
                clientSelected:@json($picklist_data->corporate_profiles->name),
                clientSelected_id:@json($picklist_data->corporate_profiles->id),
                orderSelected:@json($picklist_data->ord_id),
                orderSelected_id:@json($picklist_data->id),

     
              },

            });
 

  </script>
 

<script>



</script>

@endpush
