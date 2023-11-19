<?php

namespace Modules\Corporate\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\Entities\Commission;
use Modules\Master\Entities\Discount;
use Modules\Order\Entities\OrderMaster;

class CorporateProfile extends Model
{
    use HasFactory;
   protected $table="corporate_profiles";
    protected $fillable = [];

  public function delivery_citys(){
    return $this->belongsTo(City::class,'dcity_id');
  }
  public function billing_citys(){
    return $this->belongsTo(City::class,'bcity_id');
  }
  public function delivery_states(){
    return $this->belongsTo(State::class,'dstate_id');
  }
  public function billing_states(){
    return $this->belongsTo(State::class,'bstate_id');
  }
  public function discounts(){
    return $this->belongsTo(Discount::class,'discount_id');
  }

  public function commissions(){
    return $this->belongsTo(Commission::class,'commission_id');

  }

  public function order_masters(){
    return $this->hasMany(OrderMaster::class,'client_id');

  }
}
