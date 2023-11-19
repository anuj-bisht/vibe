<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ean extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;


    protected static function newFactory()
    {
        return \Modules\Master\Database\factories\EanFactory::new();
    }
}
