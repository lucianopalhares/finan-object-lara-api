<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Queue\RabbitMQQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Config;
use App\Mail\SendEmailSales;

/**
 * Comando para consumir mensagens da fila RabbitMQ .
 */
class ConsumeLogs extends Command
{
    /**
     * O nome e assinatura do comando do console.
     *
     * @var string
     */
    protected $signature = 'logs:consume';

    /**
     * A descrição do comando.
     *
     * @var string
     */
    protected $description = 'Consome mensagens de logs';

    /**
     * Serviço de integração com RabbitMQ.
     *
     * @var RabbitMQQueue
     */
    protected $RabbitMQQueue;

    /**
     * Construtor da classe.
     *
     * @param RabbitMQQueue $RabbitMQQueue
     */
    public function __construct(RabbitMQQueue $RabbitMQQueue)
    {
        parent::__construct();
        $this->RabbitMQQueue = $RabbitMQQueue;
    }

    /**
     * Manipula a execução do comando.
     *
     */
    public function handle()
    {
        try {
            $exchange = Config::get('services.rabbitmq.exchange');
            $queue = Config::get('services.rabbitmq.queue');
            $bind = Config::get('services.rabbitmq.bind');

            $this->RabbitMQQueue->declareExchangeQueueBind($exchange, $queue, $bind);

            $this->RabbitMQQueue->consumeMessage($queue, function ($message) {
                $sales = json_decode($message->body, true);

                if (!$sales) {
                    Log::error('Mensagem inválida recebida do RabbitMQ', ['message' => $message->body] );
                    return;
                }

                try {


                } catch (\Exception $e) {
                    Log::error('Erro ao consumir logs do rabitMQ', ['message' => $e->getMessage()] );
                }
            });

        } catch (\Exception $e) {
            Log::error('Erro ao consumir mensagens do RabbitMQ', [
                'error' => $e->getMessage(),
            ]);
            $this->error('Falha ao consumir mensagens. Verifique os logs para mais detalhes.');
        }
    }
}
