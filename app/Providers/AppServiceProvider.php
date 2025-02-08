<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\RecordBankTransactionAudit;
use App\Events\BankTransactionAudited;

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
    }
}
