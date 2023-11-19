<?php

namespace Modules\Master\Entities;

use Attribute as GlobalAttribute;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;



class Warehouse extends Model
{
    use HasFactory;
    public const ID = 'id';
    protected $fillable = [];


  
  
    
  
    public function child(){
        return   $this->hasMany(FinishedWarehouse::class, 'warehouse_id');
      }

      public function sizes(){
        return Size::pluck('size','id');
      }

   public function scopeGetWarehouse($query){
        return $query->select(Warehouse::ID,'name','default_status');
   }   

   protected function name():Attribute {
        return Attribute::make(
          get: fn($value) => strtoupper($value),
        );
   }
}
