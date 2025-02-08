<?php

namespace App\Observers;

use App\Models\BankTransaction;
use App\Observers\LogObserver;

class BankTransactionObserver extends LogObserver
{
    /**
     * Handle the BankTransaction "created" event.
     *
     * @param BankTransaction $model
     * @return void
     */
    public function created(BankTransaction $model): void
    {
        $this->logAction('cadastrar', $model);
    }

    /**
     * Handle the BankTransaction "updated" event.
     *
     * @param BankTransaction $model
     * @return void
     */
    public function updated(BankTransaction $model): void
    {
        $this->logAction('editar', $model);
    }

    /**
     * Handle the BankTransaction "deleted" event.
     *
     * @param BankTransaction $model
     * @return void
     */
    public function deleted(BankTransaction $model): void
    {
        $this->logAction('excluir', $model);
    }
}
