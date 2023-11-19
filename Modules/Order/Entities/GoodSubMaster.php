<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\Entities\Color;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductMaster;

class GoodSubMaster extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $table="goods_sub_masters";

    public function child(){
        return $this->hasMany(Good::class, 'goods_sub_master_id');
      }

      
        public function product(){
            return   $this->belongsTo(ProductMaster::class, 'product_id');
        }

        public function color(){
            return   $this->belongsTo(Color::class, 'color_id');

        }

}
