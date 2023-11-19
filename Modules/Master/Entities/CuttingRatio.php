<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CuttingRatio extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'cutting_id',
        'size_id',
        'ratio'
    ];

}
