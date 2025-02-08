<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class LogModelChanges
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Model $model)
    {
        $action = $model->wasRecentlyCreated ? 'created' : ($model->wasChanged() ? 'updated' : 'deleted');

        Log::channel('daily')->info("Ação: {$action}", [
            'model' => get_class($model),
            'id' => $model->id,
            'data' => $model->toArray(),
            'changes' => $model->getChanges(),
        ]);
    }
}
