<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cutting extends Model
{
    use HasFactory;

    protected $appends = ['child_array'];

    protected $fillable = [
        'id',
        'name'
    ];

    public function child(){
        return $this->hasMany(CuttingRatio::class, 'cutting_id');
    }

    public function getChildArrayAttribute(){
        return $this->child->pluck( "ratio", "size_id");
    }


}
