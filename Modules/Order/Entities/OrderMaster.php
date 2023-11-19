<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Corporate\Entities\State;
use Modules\Master\Entities\Agent;

class OrderMaster extends Model
{
    use HasFactory;

    protected $fillable = [];

 public function agents(){
    return $this->belongsTo(Agent::class,'client_id');
 }


 public function states(){
    return $this->belongsTo(State::class,'state_id');
 }


 public function detail(){
   return $this->hasMany(OrderSubMaster::class, 'order_id');
 }

 public function corporate_profiles(){
   return $this->belongsTo(CorporateProfile::class,'client_id');
}



}
