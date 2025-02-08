<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankTransactionAudit extends Model
{
    protected $fillable = [
        'bank_transaction_id',
        'user_name',
        'payment_method_code',
        'bank_account_name',
        'action'
    ];
}
