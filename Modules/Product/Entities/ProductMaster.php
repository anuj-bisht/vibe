<?php

namespace Modules\Product\Entities;

use Modules\Master\Entities\Fit;
use Modules\Master\Entities\Color;
use Modules\Master\Entities\Style;
use Modules\Master\Entities\Fabric;
use Modules\Master\Entities\Gender;
use Modules\Master\Entities\Category;
use Modules\Product\Entities\Product;
use Illuminate\Database\Eloquent\Model;
use Modules\Master\Entities\Collection;
use Modules\Master\Entities\SubCategory;
use Modules\Master\Entities\MainCategory;
use Modules\Master\Entities\SubSubCategory;
use Modules\Product\Entities\ProductSubMaster;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','product_code'
    ];


    public function subproduct(){
       return $this->hasMany(ProductSubMaster::class);
    }

    public function singleproduct(){
        return $this->belongsTo(ProductSubMaster::class);
     }



}
