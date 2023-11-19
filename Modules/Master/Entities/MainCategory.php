<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Entities\ProductSubMaster;

class MainCategory extends Model
{
    use HasFactory;
    protected $table= 'main_categories';

    protected $guarded = [];
    public $timestamps = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'id'
    ];

    public function product_sub_masters(){
        return $this->hasMany(ProductSubMaster::class, 'main_category_id');
      }


}
