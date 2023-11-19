<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\Entities\Size;

class Picklist extends Model
{
    use HasFactory;

    protected $fillable = [];
    public function size(){
        return $this->belongsTo(Size::class,'size_id');
    
       }
}
