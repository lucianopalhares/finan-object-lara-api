<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'bank_accounts';

    /**
     * Custom alias for logging.
     *
     * @var string
     */
    public $logAlias = 'Conta Bancária';

    protected $fillable = [
        'account_number',
        'account_balance'
    ];
}
