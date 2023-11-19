@extends('layouts.app')

@section('content')
<div class="container">

    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Unfinished Warehouse</h4>

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
                                <tr >
                                    <th>S no</th>
                                    <th style='text-align:center;'>P Code</th>
                                    <th style='text-align:center;'>C Code</th>
                                    @foreach($sizes as $size)
                                    <th style="text-align:center;">
                                        <?php
                                           $str=explode('/',$size->size);
                                           $a=$str[0]??'';
                                           $b=$str[1]??'';
                                           echo "$a<br>$b";
                                            ?>
                                    </th>
                                    @endforeach
                                    <th style="text-align:center;">Rate</th>
                                    <th style="text-align:center;">Total Qty</th>
                                    <th style="text-align:center;">Total Mrp</th>
                                </tr>
                            </thead>
                            <tbody>


                                @foreach ($data as $unfinished)
                                <tr align="center">

                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$unfinished->product->product_code}}</td>
                                    <td>{{$unfinished->color->color_code}}</td>
                                    @foreach ($unfinished->child as $attribute)
                                    <td style="text-align:center;">{{$attribute->qty}}</td>
                                    @endforeach
                                    <td>{{(int)$unfinished->productsubmaster->mrp}}</td>
                                    <td>{{$unfinished->sum}}</td>
                                    <td>{{(int)$unfinished->productsubmaster->mrp * (int)$unfinished->sum}}</td>


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
@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
@endpush
