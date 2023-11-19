<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\ProductMaster;
use Modules\Product\Entities\ProductSubMaster;

class Season extends Model
{
    use HasFactory;

    protected $fillable = [];

   public function product_sub_masters(){
    return $this->hasMany(ProductSubMaster::class,'season_id');
   }


}
