<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\ProductMaster;
use Modules\Product\Entities\ProductSubMaster;

class FinishedWarehouse extends Model
{

  // protected $primaryKey = 'id';

    protected $fillable = [
      "id",
      "check_audit",
      "warehouse_id",
      "product_master_id",
      "color_id",
      "sum",
      "date",
      "created_at",
      "updated_at"
    ];
  protected $table="finished_warehouses";
   public function child(){

        return $this->hasMany(FinishedWarehouseQty::class, 'finished_warehouse_id');

   }

   public function parent(){
    return $this->belongsTo(Warehouse::class,'warehouse_id');

   }

   public function color(){
    return $this->belongsTo(Color::class,'color_id');

   }

   public function cutting_plans(){
    return $this->belongsTo(CuttingPlan::class,'cutting_plan_id');

   }

   public function product_masters(){
    return $this->belongsTo(ProductMaster::class,'product_master_id');

   }

   public function productSubMaster(){
    return $this->hasOne(ProductSubMaster::class, 'product_master_id', 'product_master_id');
   }

   public function warehouses(){
     return $this->belongsTo(Warehouse::class,'warehouse_id');
 
    }


}
