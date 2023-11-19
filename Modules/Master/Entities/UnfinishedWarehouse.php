<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\ProductMaster;

class UnfinishedWarehouse extends Model
{
    use HasFactory;

    protected $fillable = [];
    
  
    
    public function product(){
        return   $this->belongsTo(ProductMaster::class, 'product_master_id');
      }
    
      public function color(){
          return   $this->belongsTo(Color::class, 'color_id');
    
      }
    
      public function child(){
        return   $this->hasMany(UnfinishedWarehouseQty::class, 'unfinished_warehouse_id');
    
      }
}
