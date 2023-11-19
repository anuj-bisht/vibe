<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unfinished extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'unfinished';

    
    public function size(){
        return $this->belongsTo(Size::class,'size_id');
    
       }
  
}
