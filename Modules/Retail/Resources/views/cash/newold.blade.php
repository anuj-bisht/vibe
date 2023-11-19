@extends('retail.layouts.app')

@section('retail_content')
<div class="container">
    <section class="tooltip-validations" id="tooltip-validation">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Cash Transfer</h4>
                    </div>
                </div>
    
            </div>
        </div>
    </section>
</div>

<div class="row match-height" id="customer_cash">
  

</div>
@endsection
@push('scripts')



<script type="module">

import MyComponent from "../Modules/Retail/Resources/js/component/MyComponent.vue";
new Vue({
  el: '#customer_cash',
  components :{
    MyComponent,
  }
})

</script>
@endpush
