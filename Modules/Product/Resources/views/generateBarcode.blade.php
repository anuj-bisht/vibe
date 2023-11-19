<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <style>
       
    </style>

</head>
<body >
<div class="container-fluid" id="content" style="">
    <div class="row">



    <div class="col-4 pb-3">
        <div class="row">
            <h6>COMMODITY: READYMADE GARMENTS 1 UNIT</h6>
        </div>
        <div class="row">
            Manufacturing Date: {!! date('M-d-Y', strtotime($detail->created_at)) !!}
        </div>
        <div class="row">
            @php
            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
            @endphp
            <div class="col-6"><img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($detail->sub_parent->hsn->value. $detail->ean_code, $generatorPNG::TYPE_EAN_13,1,40)) }}"></div>
            <div class="col-3">{{ $detail->sub_parent->parent->product_code }}</div>
        </div>
        <div class="row">
        {{ $detail->sub_parent->hsn->value }}{{ $detail->ean_code}}
        </div>
        <div class="row">
         STONE EMBELISHED CO-ORDS
        </div>
        <div class="row">
            <h6>M.R.P RS: {{ $detail->sub_parent->mrp }}</h6>
        </div>
        <div class="row">
           (INCLUSIVE OF ALL TAXES)
        </div>
    </div>
    <br>
    <hr>

    

    <div class="col-4">
        <div class="row">
            <h6>COMMODITY: READYMADE GARMENTS 1 UNIT</h6>
        </div>
        <div class="row">
            <h6>Manufacturing Date: {!! date('M-d-Y', strtotime($detail->created_at)) !!}</h6>
        </div>
        <div class="row">
            @php
            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
            @endphp
            <div class="col-6"><img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($detail->sub_parent->hsn->value. $detail->ean_code, $generatorPNG::TYPE_EAN_13,2,40)) }}"></div>
            <div class="col-3">{{ $detail->sub_parent->parent->product_code }}</div>
        </div>
        <div class="row">
        {{ $detail->sub_parent->hsn->value }}{{ $detail->ean_code}}
        </div>
        <div class="row">
         STONE EMBELISHED CO-ORDS
        </div>
        <div class="row">
            <h6>M.R.P RS: {{ $detail->sub_parent->mrp }}</h6>
        </div>
        <div class="row">
           (INCLUSIVE OF ALL TAXES)
        </div>
    </div>
    <br>
    <hr>

    <div class="col-4">
        <div class="row">
            <h6>COMMODITY: READYMADE GARMENTS 1 UNIT</h6>
        </div>
        <div class="row">
            <h6>Manufacturing Date: {!! date('M-d-Y', strtotime($detail->created_at)) !!}</h6>
        </div>
        <div class="row">
            @php
            $generatorPNG = new Picqer\Barcode\BarcodeGeneratorPNG();
            @endphp
            <div class="col-6"><img src="data:image/png;base64,{{ base64_encode($generatorPNG->getBarcode($detail->sub_parent->hsn->value. $detail->ean_code, $generatorPNG::TYPE_EAN_13,2,40)) }}"></div>
            <div class="col-3">{{ $detail->sub_parent->parent->product_code }}</div>
        </div>
        <div class="row">
        {{ $detail->sub_parent->hsn->value }}{{ $detail->ean_code}}
        </div>
        <div class="row">
         STONE EMBELISHED CO-ORDS
        </div>
        <div class="row">
            <h6>M.R.P RS: {{ $detail->sub_parent->mrp }}</h6>
        </div>
        <div class="row">
           (INCLUSIVE OF ALL TAXES)
        </div>
    </div>
    </div>

  
</div>



</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

</html>









