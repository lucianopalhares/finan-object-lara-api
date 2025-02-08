<?php

namespace App\Listeners;

use App\Events\BankTransactionAudited;
use App\Models\BankTransactionAudit;

class RecordBankTransactionAudit
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\BankTransactionAudited  $event
     * @return void
     */
    public function handle(BankTransactionAudited $event)
    {
        $transaction = $event->bankTransaction;

        $audit = BankTransactionAudit::firstOrCreate([
            'bank_transaction_id' => $transaction->id,
            'action' => $event->action
        ], [
            'user_name' => $transaction->username(),
            'payment_method_code' => $transaction->paymentMethod->code,
            'payment_method_tax_rate' => $transaction->paymentMethod->tax_rate,
            'bank_account_number' => $transaction->bankAccount->account_number,
            'value' => $transaction->value
        ]);

        if (!$audit->wasRecentlyCreated) {
            return;
        }

        $audit->save();
    }
}
