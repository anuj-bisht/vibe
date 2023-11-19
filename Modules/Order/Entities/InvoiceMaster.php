<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Corporate\Entities\CorporateProfile;
use Modules\Master\Entities\Tax;
use Modules\Master\Entities\Warehouse;
use Modules\Retail\Entities\InvoiceDifferenceSubMaster;

class InvoiceMaster extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    public function detail(){
        return $this->hasMany(InvoiceSubMaster::class, 'invoice_master_id');
      }

      public function tax(){
        return $this->belongsTo(Tax::class, 'tax_id');
      }

      public function client(){
        return $this->belongsTo(CorporateProfile::class, 'client_id');
      }

      public function warehouse(){
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
      }

      public function invoiceDifferenceSubMaster(){
        return $this->hasMany(InvoiceDifferenceSubMaster::class, 'invoice_master_id');
      }
    
   
}
