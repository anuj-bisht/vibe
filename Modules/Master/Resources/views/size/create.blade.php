


@extends('layouts.app')

@section('content')
<div class="container">

        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Size</h4>
                            <a class="btn btn-sm global_btn_color" href="{{ url()->previous() }}" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg></a>

                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                <form class="" novalidate method="POST" action="{{route('master.size.store')}}">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-12 col-12 mb-3">

                            <div class="form-group">
                                <label for="basicSelect">Select Type</label>
                                <select class="form-control" id="type" name="type" onchange="clothsize(this)">

                                    <option value="waist">Waist</option>
                                    <option value="top">Top</option>

                                </select>
                                @error('type')
                                <h5 class="alert alert-danger">{{$message}}</h5>
                            @enderror
                            </div>



                            <div class="form-group" id="mls" style="">

                                <label for="validationTooltip01">Mention Size</label>
                                <input type="text" class="form-control" name="size" id="size" placeholder="28,30,32....." required  onkeypress="return onlyNumberKey(event)"/>
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

function clothsize(ele){

  if($(ele).val() === 'waist'){
    $('#size').attr('onkeypress','return onlyNumberKey(event)')
    $('#size').attr('placeholder',"28 30 32");
    $('#size').removeAttr('pattern');
}else{
    $('#size').attr('pattern',"[a-zA-Z]*");
    $('#size').attr('placeholder',"S M L");
    $('#size').removeAttr('onkeypress');


}

}
function onlyNumberKey(evt) {

          // Only ASCII character in that range allowed
          var ASCIICode = (evt.which) ? evt.which : evt.keyCode
          if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
              return false;
          return true;
      }




</script>
