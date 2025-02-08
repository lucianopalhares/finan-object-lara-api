<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class LogObserver
{
    /**
     * Log the action performed on the model.
     *
     * @param string $action
     * @param Model $model
     * @return void
     */
    public function logAction(string $action, Model $model): void
    {
        $table = (string) $model->getTable();
        $alias = $model->logAlias ?? $table;

        Log::channel('database')->info($action . " " . $alias, [
            'table' => $table,      // Nome da tabela
            'model' => get_class($model),       // Nome da classe do modelo
            'alias' => $alias,                  // Alias customizado
            'id' => $model->id,                 // ID do modelo
            'data' => $model->toArray(),        // Dados do modelo
            'original' => $model->getOriginal(),
            'changes' => $model->getChanges(),  // Alterações (útil para "updated")
        ]);
    }
}
