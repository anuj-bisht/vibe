<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductMaster;

class CuttingPlanDetail extends Model
{
    use HasFactory;

    protected $fillable = ['id','cutting_plan_id','season_id','cutting_id','product_id','sum'];
    public function child(){
        return $this->hasMany(CuttingPlanQuantity::class, 'cutting_plan_detail_id');
    }

    public function product(){
      return   $this->belongsTo(ProductMaster::class, 'product_id')->where('check_audit',0);
    }

   
   
    public function color(){
        return   $this->belongsTo(Color::class, 'color_id');

    }

    public function season(){
        return   $this->belongsTo(Season::class, 'season_id');

    }

    public function subChild(){
        return $this->hasMany(CuttingPlanQuantityLeft::class, 'cutting_plan_detail_id');

    }

}
