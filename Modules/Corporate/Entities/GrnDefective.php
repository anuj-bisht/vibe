<?php

namespace Modules\Corporate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GrnDefective extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Corporate\Database\factories\GrnDefectiveFactory::new();
    }
}
