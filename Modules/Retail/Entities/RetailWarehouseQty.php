<?php

namespace Modules\Retail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\Entities\Size;

class RetailWarehouseQty extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'retail_warehouse_qtys';
    public function size(){
        return $this->belongsTo(Size::class,'size_id');
    
       }

 
}
