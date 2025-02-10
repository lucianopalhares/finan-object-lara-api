<?php

namespace App\Listeners;

use App\Events\BankTransactionAudited;
use App\Jobs\PublishBankTransactionAudit;
use Illuminate\Support\Facades\Log;
use function Sentry\captureException;


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
        try {

            $transaction = json_encode($event->bankTransaction);
            PublishBankTransactionAudit::dispatch($transaction)->onQueue('rabbitmq');

        } catch (\Exception $e) {
            captureException($e);
            Log::error('Erro ao gravar auditoria da transação bancária: ' . $e->getMessage());
        }
    }
}
