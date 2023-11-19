<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\ProductSubMaster;

class SubCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'category_id'

    ];
    protected $guarded = [];
   

    public function parent(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function products(){
        return   $this->hasMany(ProductSubMaster::class, 'sub_category_id');
    
      }

   
}
