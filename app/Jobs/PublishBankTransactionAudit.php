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

            $audit = BankTransactionAudit::firstOrCreate([
                'bank_transaction_id' => $transaction->id,
                'action' => 'create'
            ], [
                'user_name' => $transaction->username,
                'payment_method_code' => $transaction->payment_method_code,
                'payment_method_tax_rate' => $transaction->payment_method_tax_rate,
                'bank_account_number' => $transaction->account_number,
                'value' => $transaction->value
            ]);

            if (!$audit->wasRecentlyCreated) {
                return;
            }

            $audit->save();

            Log::info('Registros de auditoria de transações publicados no RabbitMQ com sucesso.');

        } catch (\Exception $e) {
            Log::error('Erro durante a publicação das auditorias no RabbitMQ', [
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
