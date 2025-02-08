<?php

namespace App\Observers;

use App\Models\BankAccount;
use App\Observers\LogObserver;

class BankAccountObserver extends LogObserver
{
    /**
     * Handle the BankAccount "created" event.
     *
     * @param BankAccount $model
     * @return void
     */
    public function created(BankAccount $model): void
    {
        $this->logAction('cadastrar', $model);
    }

    /**
     * Handle the BankAccount "updated" event.
     *
     * @param BankAccount $model
     * @return void
     */
    public function updated(BankAccount $model): void
    {
        $this->logAction('editar', $model);
    }

    /**
     * Handle the BankAccount "deleted" event.
     *
     * @param BankAccount $model
     * @return void
     */
    public function deleted(BankAccount $model): void
    {
        $this->logAction('excluir', $model);
    }
}
