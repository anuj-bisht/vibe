<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\Entities\Category;
use Modules\Master\Entities\Collection;
use Modules\Master\Entities\Color;
use Modules\Master\Entities\Composition;
use Modules\Master\Entities\Ean;
use Modules\Master\Entities\Fabric;
use Modules\Master\Entities\Fit;
use Modules\Master\Entities\Gender;
use Modules\Master\Entities\Hsn;
use Modules\Master\Entities\MainCategory;
use Modules\Master\Entities\Season;
use Modules\Master\Entities\Style;
use Modules\Master\Entities\SubCategory;
use Modules\Master\Entities\SubSubCategory;

class ProductSubMaster extends Model
{
    use HasFactory;


    protected $fillable = [
        'id','product_master_id','gender_id','fabric_id','style_id','color_id','composition_id','margin_id','ean_id','hsn_id','main_category_id','category_id',
        'sub_category_id','sub_sub_category_id','season_id','cost_price','mrp','fit','desciption','type',
    ];



    public function parent() {
        return $this->belongsTo(ProductMaster::class,'product_master_id');
    }

    public function ean() {
        return $this->belongsTo(Ean::class,'ean_id');
    }
    public function hsn() {
        return $this->belongsTo(Hsn::class,'hsn_id');
    }
    public function composition() {
        return $this->belongsTo(Composition::class,'composition_id');
    }
    // public function products() {
    //     return $this->hasMany( Product::class, 'product_master_id' );
    // }

    public function category() {
        return $this->belongsTo(MainCategory::class ,'main_category_id');
    }
    public function main_child() {
        return $this->belongsTo(Category::class,'category_id');
    }

    public function main_child_sub_child() {
        return $this->belongsTo(SubCategory::class,'sub_category_id');
    }

    public function main_child_sub_sub_child() {
        return $this->belongsTo(SubSubCategory::class,'sub_sub_category_id');
    }

    public function gender() {
        return $this->belongsTo(Gender::class,'gender_id');
    }

    public function fabric() {
        return $this->belongsTo(Fabric::class,'fabric_id');
    }
    public function style() {
        return $this->belongsTo(Style::class,'style_id');
    }
    public function color() {
        return $this->belongsTo(Color::class,'color_id');
    }
    public function season() {
        return $this->belongsTo(Season::class,'season_id');
    }
    public function fit() {
        return $this->belongsTo(Fit::class,'fit_id');
    }

    public function child() {
        return $this->hasMany(Product::class,'product_sub_master_id');
    }
}
