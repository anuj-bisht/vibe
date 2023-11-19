<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FinishedWarehouseQty extends Model
{
    use HasFactory;

    protected $fillable = [];

  protected $table='finished_warehouse_qtys';

  public function size(){
    return $this->belongsTo(Size::class,'size_id');

   }
}
