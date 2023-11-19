<?php

namespace Modules\Master\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Corporate\Entities\CorporateProfile;

class WalletHistoryLog extends Model
{
    use HasFactory;

    protected $fillable = [];
    
  
    public function user(){
        return   $this->belongsTo(User::class, 'user_id');
    }
    public function retail(){
        return   $this->belongsTo(CorporateProfile::class, 'retail_id');
    }

    public function wallet(){
        return   $this->belongsTo(Wallet::class, 'retail_id');
    }
}
