<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;

use App\Domain\Entities\BankTransactionEntity;

class BankTransactionAudited
{
    use SerializesModels;

    public $bankTransaction;

    /**
     * Create a new event instance.
     *
     * @param  BankTransactionEntity  $bankTransaction
     * @param  string  $action
     * @return void
     */
    public function __construct(BankTransactionEntity $bankTransaction)
    {
        $this->bankTransaction = $bankTransaction;
    }
}
