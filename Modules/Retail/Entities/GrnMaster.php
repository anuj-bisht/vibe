<?php

namespace Modules\Retail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Corporate\Entities\GrnDefectiveSubMaster;
use Modules\Corporate\Entities\GrnUndefectiveSubMaster;

class GrnMaster extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    public function corporate_profile(){
        return   $this->belongsTo(CorporateProfile::class, 'retail_id');
      }


      public function detail(){
        return $this->hasMany(GrnSubMaster::class, 'grn_master_id');
      }

      public function undefective(){
        return $this->hasMany(GrnUndefectiveSubMaster::class, 'grn_master_id');
      }

      public function defective(){
        return $this->hasMany(GrnDefectiveSubMaster::class, 'grn_master_id');
      }
}
