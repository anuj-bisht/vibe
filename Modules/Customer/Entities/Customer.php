<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Corporate\Entities\City;
use Modules\Corporate\Entities\Country;
use Modules\Corporate\Entities\State;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name','email', 'mobile','alter_no','country_id','state_id','city_id'];
    protected $guarded = ['age', 'gender'];
    protected $dates = ['dob', 'aniversary_date'];

    protected $with = ['country'];

    public function country(){
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function state(){
        return $this->belongsTo(State::class, 'state_id');
    }
    public function city(){
        return $this->belongsTo(City::class, 'city_id');
    }
  
}
