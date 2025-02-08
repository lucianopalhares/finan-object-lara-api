<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\RecordBankTransactionAudit;
use App\Events\BankTransactionAudited;
use App\Listeners\LogModelChanges;
use Illuminate\Database\Eloquent\Model;
use App\Observers\BankTransactionObserver;
use App\Models\BankTransaction;
use App\Observers\BankAccountObserver;
use App\Models\BankAccount;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            BankTransactionAudited::class,
            RecordBankTransactionAudit::class,
        );

        BankTransaction::observe(BankTransactionObserver::class);
        BankAccount::observe(BankAccountObserver::class);
    }
}
