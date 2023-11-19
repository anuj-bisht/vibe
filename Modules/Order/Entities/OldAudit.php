<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OldAudit extends Model
{
    use HasFactory;

    protected $fillable = [];
    
 protected $table="old_audits";
}
