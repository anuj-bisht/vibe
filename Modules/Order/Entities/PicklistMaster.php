<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Corporate\Entities\State;
use Modules\Master\Entities\Warehouse;

class PicklistMaster extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'picklist_masters';
    public function states(){
        return $this->belongsTo(State::class,'state_id');
     }
    
   
     public function corporate_profiles(){
       return $this->belongsTo(CorporateProfile::class,'client_id');
    }

    public function warehouse(){
      return $this->belongsTo(Warehouse::class,'warehouse_id');
   }

    public function order_master(){
        return $this->belongsTo(OrderMaster::class,'order_id');
     }

     public function detail(){
        return $this->hasMany(PicklistSubMaster::class, 'picklist_master_id');
      }
    
   
}
