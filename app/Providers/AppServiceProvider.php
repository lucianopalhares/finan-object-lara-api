<?php

namespace App\Providers;

use App\Domain\Interfaces\BankAccountInterface;
use App\Domain\Interfaces\BankTransactionInterface;
use App\Domain\Interfaces\PaymentMethodInterface;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\RecordBankTransactionAudit;
use App\Events\BankTransactionAudited;
use App\Infrastructure\Persistence\Repositories\BankAccountRepository;
use App\Infrastructure\Persistence\Repositories\BankTransactionRepository;
use App\Infrastructure\Persistence\Repositories\PaymentMethodRepository;
use Illuminate\Database\Eloquent\Model;
use App\Observers\BankTransactionObserver;
use App\Models\BankTransaction;
use App\Observers\BankAccountObserver;
use App\Models\BankAccount;
use Sentry\Laravel\Integration;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            BankAccountInterface::class,
            BankAccountRepository::class
        );

        $this->app->bind(
            BankTransactionInterface::class,
            BankTransactionRepository::class
        );

        $this->app->bind(
            PaymentMethodInterface::class,
            PaymentMethodRepository::class
        );
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

        Model::preventLazyLoading();

        if (app()->isProduction()) {
            Model::handleLazyLoadingViolationUsing(
                Integration::lazyLoadingViolationReporter()
            );
        }
    }
}
