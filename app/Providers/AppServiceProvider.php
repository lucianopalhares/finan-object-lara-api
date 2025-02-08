<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\RecordBankTransactionAudit;
use App\Events\BankTransactionAudited;
use App\Listeners\LogModelChanges;
use Illuminate\Database\Eloquent\Model;

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

        Model::created([LogModelChanges::class, 'handle']);
        Model::updated([LogModelChanges::class, 'handle']);
        Model::deleted([LogModelChanges::class, 'handle']);
    }
}
