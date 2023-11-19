<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnfinishedWarehouseQty extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'unfinished_warehouse_qtys';

    
   
}
