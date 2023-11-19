<?php

namespace Modules\Retail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\Entities\Color;
use Modules\Order\Entities\Invoice;
use Modules\Product\Entities\ProductMaster;

class InvoiceDifferenceSubMaster extends Model
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
        return   $this->hasMany(InvoiceDifference::class,'invoice_difference_sub_master_id');
    
      }
}
