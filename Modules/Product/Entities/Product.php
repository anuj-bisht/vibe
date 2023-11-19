<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\Entities\Size;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function sizes() {
        return $this->belongsTo(Size::class,'size');
    }

    public function sub_parent() {
        return $this->belongsTo(ProductSubMaster::class,'product_sub_master_id');
    }


}
