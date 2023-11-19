<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\ProductSubMaster;

class Category extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'id',
        'main_category'
    ];
    public function parent(){
        return $this->belongsTo(MainCategory::class, 'main_category', 'id');
    }

    public function products(){
        return   $this->hasMany(ProductSubMaster::class, 'category_id');
    
      }


}
