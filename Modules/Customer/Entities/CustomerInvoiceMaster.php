<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerInvoiceMaster extends Model
{
    use HasFactory;

    protected $fillable = [];
     
    public function customer(){
        return $this->belongsTo(Customer::class, 'customer_id');
      }
   
      public function detail(){
        return $this->hasMany(CustomerInvoiceSubMaster::class, 'customer_invoice_master_id');
      }
}
