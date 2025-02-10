<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use App\Models\BankTransactionAudit;
use Throwable;

class PublishBankTransactionAudit implements ShouldQueue
{
    use Queueable;

    /**
     * Construtor da classe.
     *
     */
    public function __construct(private string $message) {}

    /**
     * Lógica principal do comando.
     *
     * @param Log $log
     */
    public function handle()
    {
        try {
            $transaction = json_decode($this->message);

            Log::error('Erro durante a publicação dos logs no dddddddddddddddd', [
                'error' => $transaction,
            ]);

            return;

            $audit = BankTransactionAudit::firstOrCreate([
                'bank_transaction_id' => $transaction->id,
                'action' => $transaction->action
            ], [
                'user_name' => empty($transaction->user) === false ? $transaction->user->username : '',
                'payment_method_code' => $transaction->payment_method->code,
                'payment_method_tax_rate' => $transaction->payment_method->tax_rate,
                'bank_account_number' => $transaction->bank_account->account_number,
                'value' => $transaction->value
            ]);

            if (!$audit->wasRecentlyCreated) {
                Log::info('Registros de logs não publicados no RabbitMQ com sucesso.');
                return;
            }

            $audit->save();

            Log::error('Erro durante a publicação dos logs no dddddddddddddddd', [
                'error' => 'ddd',
            ]);

            Log::info('Registros de logs publicados no RabbitMQ com sucesso.');

        } catch (\Exception $e) {
            Log::error('Erro durante a publicação dos logs no RabbitMQ', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Método chamado quando o Job falha.
     *
     * @param Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        // Personalize o que acontece quando o Job falha
        Log::error("Job falhou: " . $exception->getMessage());

        // Se você não quiser registrar na tabela failed_jobs, simplesmente não faça nada aqui
    }
}
