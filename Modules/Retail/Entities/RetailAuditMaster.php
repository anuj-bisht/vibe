<?php

namespace Modules\Retail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RetailAuditMaster extends Model
{
    use HasFactory;

    protected $fillable = [];
    
   
    public function detail(){
        return $this->hasMany(RetailAuditSubMaster::class, 'retail_audit_master_id');
      }

      public function olddetail(){
        return $this->hasMany(OldRetailAuditSubMaster::class, 'retail_audit_master_id');
      }
}
