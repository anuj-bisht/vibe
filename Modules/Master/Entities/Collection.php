<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Collection extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'code'

    ];
    protected static function newFactory()
    {
        return \Modules\Master\Database\factories\CollectionFactory::new();
    }
}
