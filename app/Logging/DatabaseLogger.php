<?php

namespace App\Logging;

use Monolog\Handler\AbstractProcessingHandler;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Monolog\LogRecord;

class DatabaseLogger extends AbstractProcessingHandler
{
    /**
     * Escreve o registro no banco de dados.
     *
     * @param array $record
     * @return void
     */
    protected function write(LogRecord $record): void
    {
        try {
            // Verifica se a tabela 'logs' existe antes de tentar inserir
            if (DB::getSchemaBuilder()->hasTable('logs')) {
                DB::table('logs')->insert([
                    'level' => $record['level_name'],
                    'message' => $record['message'],
                    'context' => json_encode($record['context'] ?? []),
                    'created_at' => now(),
                ]);
            } else {
                Log::error('Tabela de logs não encontrada no banco de dados.');
            }
        } catch (Exception $e) {
            Log::error('Erro ao salvar log no banco de dados: ' . $e->getMessage());
        }
    }
}
