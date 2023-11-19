<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuditMaster extends Model
{
    use HasFactory;

    protected $fillable = [];
    public function detail(){
        return $this->hasMany(AuditSubMaster::class, 'audit_master_id');
      }

      public function olddetail(){
        return $this->hasMany(OldAuditSubMaster::class, 'audit_master_id');
      }
}
