<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Queue\RabbitMQQueue;
use Illuminate\Support\Facades\Config;

class PublishLogs extends Command
{
    protected $signature = 'logs:publish';
    protected $description = 'Publica os registros de logs no RabbitMQ';

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
     * Lógica principal do comando.
     *
     * @param Log $log
     */
    public function handle(Log $log)
    {
        try {

            $message = json_encode($log);

            $queue = Config::get('services.rabbitmq.queue');

            $this->RabbitMQQueue->publishMessage($queue, $message);

            $this->info('Registros de logs publicados no RabbitMQ com sucesso.');

        } catch (\Exception $e) {
            Log::error('Erro durante a publicação dos logs no RabbitMQ', [
                'error' => $e->getMessage(),
            ]);

            $this->error('Falha ao publicar registros de logs no RabbitMQ. Verifique os logs para mais detalhes.');
        }
    }
}
