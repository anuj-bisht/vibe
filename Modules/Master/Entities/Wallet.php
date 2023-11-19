<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Corporate\Entities\CorporateProfile;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    public function retail(){
        return   $this->belongsTo(CorporateProfile::class, 'retail_id');
    }
}
