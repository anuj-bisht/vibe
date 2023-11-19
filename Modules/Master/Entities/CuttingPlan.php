<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CuttingPlan extends Model
{
    use HasFactory;

    protected $fillable = ['id','name'];

    public function detail(){
        return $this->hasMany(CuttingPlanDetail::class, 'cutting_plan_id');
    }




}
