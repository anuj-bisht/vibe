<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\ProductMaster;
use Modules\Product\Entities\ProductSubMaster;

class UnfinishedMaster extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected $table = 'unfinished_master';

    public function child(){
        return   $this->hasMany(Unfinished::class, 'unfinished_master_id');
      }


      public function product(){
        return $this->belongsTo(ProductMaster::class,'product_master_id');
    
       }
    
       public function color(){
        return $this->belongsTo(Color::class,'color_id');
    
       }

       public function productsubmaster()
       {
           return $this->belongsTo(ProductSubMaster::class,  'product_master_id', $this->product_master_id,'color_id', $this->color_id);
       }
      
 
}
