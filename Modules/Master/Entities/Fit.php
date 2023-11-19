<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fit extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'code'

    ];
    public $timestamps = false;

}
