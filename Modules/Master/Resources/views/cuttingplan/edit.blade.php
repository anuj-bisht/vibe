@extends('layouts.app')

@section('content')
<div class="container">
    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Edit Cutting Plan Attribute</h4>
                        <a class="btn btn-sm global_btn_color" href="{{ url()->previous() }}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left">
                                <polyline points="11 17 6 12 11 7"></polyline>
                                <polyline points="18 17 13 12 18 7"></polyline>
                            </svg></a>
                    </div>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form class="table-responsive" action="{{ route('update.planAttribute', ['id' => $ratios->id]) }}" method="post">
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
                                <th style="padding:0.75rem !important;">Total Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                @php
                                $child = $ratios->child->pluck('qty', 'size_id');
                                @endphp

                                @foreach ($sizes as $size)
                                <td><input type="number" onchange='updateTotal();' id="cutting_ratios{{ $size->id }}" value="{{ isset($child[$size->id]) ? $child[$size->id] : '' }}" name="cutting_qtys[{{ $size->id }}]" class="form-control input">
                                    @endforeach
                                </td>
                                <td><input type="number" readonly="" id="total" name="sum" value="{{ $ratios->sum }}" class="form-control"></td>
                            </tr>

                        </tbody>
                    </table>
                    <button class="btn global_btn_color" type="submit">Submit</button>
                </form>
            </div>
        </div>
</div>
</section>

</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>
    function updateTotal() {
        var total = 0; //
        var list = document.getElementsByClassName("input");

        var values = [];

        for (var i = 0; i < list.length; ++i) {


            values.push(list[i].value);
        }
        sub(values);
    }

    function sub(arr) {
        var values = $.grep(arr, n => n == ' ' || n)
        var total = 0;
        console.log(values);
        console.log(values.length);
        for (var i in values) {
            total += parseInt(values[i]);
        }
        document.getElementById("total").value = total;
    }

</script>
@endsection
