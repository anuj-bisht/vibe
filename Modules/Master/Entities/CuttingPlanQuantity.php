<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CuttingPlanQuantity extends Model
{
    use HasFactory;

    protected $fillable = ['id','cutting_plan_detail_id','size_id','qty'];
protected $table='cutting_plan_quantaties';
}
