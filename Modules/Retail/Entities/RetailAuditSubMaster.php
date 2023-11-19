<?php

namespace Modules\Retail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\Entities\Color;
use Modules\Product\Entities\ProductMaster;

class RetailAuditSubMaster extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    public function product(){
        return   $this->belongsTo(ProductMaster::class, 'product_id');
      }
    
      public function color(){
          return   $this->belongsTo(Color::class, 'color_id');
    
      }
    
      public function child(){
        return   $this->hasMany(RetailAudit::class, 'retail_audit_sub_master_id');
    
      }
}
