<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubSubCategory extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name',
        'sub_category_id'

    ];

    protected static function newFactory()
    {
        return \Modules\Master\Database\factories\SubSubCategoryFactory::new();
    }

    public function parent(){
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }
}
