<?php

namespace Modules\Retail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CashDepositHistory extends Model
{
    use HasFactory;

    protected $fillable = [];
    protected $table = 'cash_deposit_history';
}
