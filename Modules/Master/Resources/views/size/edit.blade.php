


@extends('layouts.app')

@section('content')
<div class="container">

        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Size</h4>
                            <a class="btn btn-sm global_btn_color" href="{{ url()->previous() }}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg></a>

                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <form class="" novalidate method="POST" action="{{route('master.size.update', ['id'=>$size->id])}}">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12 col-12 mb-3">

                            <div class="form-group">
                                <label for="basicSelect">Select Type</label>
                                <select class="form-control" id="type" name="type" onchange="clothsize(this)">

                                    <option @if ($size->type === 'waist') selected @endif value="waist">Waist</option>
                                    <option @if ($size->type === 'top') selected @endif value="top">Top</option>

                                </select>
                                @error('type')
                                <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                            </div>



                            <div class="form-group" id="mls" style="">

                                <label for="validationTooltip01">Mention Size</label>
                                <input type="text" class="form-control" name="size" placeholder="M,L,S....." required  value="{{$size->size}}"/>
                                @error('size')
                                <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                            </div>
                        </div>



                    </div>
                    <button class="btn global_btn_color" type="submit">Submit</button>
                </form>
            </div>
                </div>
            </div>
        </section>

</div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script>

function clothsize(val){

    if($('#type').val() === "number"){
        $('#clothnumber').keypress(function (e) {

var charCode = (e.which) ? e.which : event.keyCode

if (String.fromCharCode(charCode).match(/[^0-9]/g))

    return false;

});
    }

}



</script>
