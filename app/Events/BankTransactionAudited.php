<?php

namespace App\Events;

use App\Models\BankTransaction;
use Illuminate\Queue\SerializesModels;

class BankTransactionAudited
{
    use SerializesModels;

    public $bankTransaction;
    public $action;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\BankTransaction  $bankTransaction
     * @param  string  $action
     * @return void
     */
    public function __construct(BankTransaction $bankTransaction, $action)
    {
        $this->bankTransaction = $bankTransaction;
        $this->action = $action;
    }
}
