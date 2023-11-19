<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Master\Entities\UnfinishedWarehouse;
use Modules\Master\Entities\Warehouse;

class GoodMaster extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table="goods_masters";
    public function client(){
        return $this->belongsTo(CorporateProfile::class, 'client_id');
      }

      public function warehouse(){
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
      }

      public function detail(){
        return $this->hasMany(GoodSubMaster::class, 'goods_master_id');
      }

      // public function unfinished_warehouses(){
      //   return $this->hasMany(UnfinishedWarehouse::class, 'good_master_id');
      // }

      public function defective_goods_sub_masters(){
        return $this->hasMany(DefectiveGoodSubMaster::class, 'goods_master_id');
      }



}
