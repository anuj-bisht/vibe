<?php

namespace Modules\Customer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Master\Entities\Size;

class CustomerInvoice extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table='customer_invoices';
    public function size(){
        return $this->belongsTo(Size::class,'size_id');
    
       }
}
