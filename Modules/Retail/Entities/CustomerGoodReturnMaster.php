<?php

namespace Modules\Retail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Customer\Entities\Customer;

class CustomerGoodReturnMaster extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    public function customers(){
        return   $this->belongsTo(Customer::class, 'customer_id');
    }

    
    public function detail(){
        return $this->hasMany(CustomerGoodReturnSubMaster::class, 'cgood_return_master_id');
      }


}
