@extends('layouts.app')

@section('content')
<div class="container">
    <section id="basic-input">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Cutting Ratios</h4>
                        <a class="btn btn-sm global_btn_color" href="{{ route('master.cutting') }}" type="submit"><svg
                                xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevrons-left">
                                <polyline points="11 17 6 12 11 7"></polyline>
                                <polyline points="18 17 13 12 18 7"></polyline>
                            </svg></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <form class="table-responsive" action="{{route('master.cutting.store')}}" method="post">
                    @csrf
                    <div class="col-md-12 col-12 mb-3">

                        <label for="validationTooltip01">Name</label>
                        <input type="text" class="form-control" name="name" placeholder="Name" required  autofocus oninput="this.value = this.value.toUpperCase()"/>
                        @error('name')
                        <h5 class="alert alert-danger">{{$message}}</h5>
                        @enderror
                    </div>
                    <table class="title-form">
                        <tbody>
                            <tr>
                                @foreach($sizes as $size)
                                <td style="text-align:center;">
                                    <?php
                                           $str=explode('/',$size->size);
                                           $a=$str[0]??'';
                                           $b=$str[1]??'';
                                           echo "$a<br>$b";
                                            ?>
                                </td>
                                @endforeach
                                <td>Total = <Span style="color:black; font-weight:900;">100</Span></td>
                                <td></td>
                            </tr>
                            <tr>
                                @foreach($sizes as $size)
                                <td><input type="number" onchange='updateTotal();' id="cutting_ratios{{$size->id}}"
                                        name="cutting_ratios[{{$size->id}}]" class="form-control input">
                                    @endforeach
                                <td><input type="number" readonly="" name="sum" id="total" class="form-control">
                                </td>
                                @error('sum')
                                Total Should be equal to 100
                                @enderror
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

<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>
    function updateTotal() {
    var total = 0;//
    var list = document.getElementsByClassName("input");

    var values = [];

    for(var i = 0; i < list.length; ++i) {


        values.push(list[i].value);
    }

sub(values);
}

function sub(arr){
   var values= $.grep(arr, n => n ==  ' ' || n)
   var total = 0;
   console.log(values);
   console.log(values.length);
for (var i in values) {
  total += parseInt(values[i]);
}
    document.getElementById("total").value = total;
    $('#total').attr('value',total);
}
</script>
@endsection