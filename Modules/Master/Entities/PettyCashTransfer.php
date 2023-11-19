<?php

namespace Modules\Master\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Corporate\Http\Controllers\CorporateController;

class PettyCashTransfer extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected $table = "petty_cash_transfers";
    
    public function corporate_profile(){
        return $this->belongsTo(CorporateProfile::class, 'retail_id');
    }
}
