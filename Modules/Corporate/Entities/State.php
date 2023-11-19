<?php

namespace Modules\Corporate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Order\Entities\OrderMaster;

class State extends Model
{
    use HasFactory;

    protected $fillable = [];

 public function corporate_profiles(){
    return $this->hasMany(CorporateProfile::class, 'bstate_id');
 }

//  public function order_masters(){
//    return $this->hasMany(OrderMaster::class, 'state_id');
// }

 public function order_masters(){
   return $this->hasMany(OrderMaster::class, 'state_id');
}









}
