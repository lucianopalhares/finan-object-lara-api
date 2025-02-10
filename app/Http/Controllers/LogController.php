<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log as LogModel;
use Illuminate\Support\Facades\Log;
use App\Cache\RedisCacheService;

class LogController extends Controller
{
    public function __construct(
        private RedisCacheService $cacheService,
        private LogModel $log
    ) {}

    public function index(Request $request)
    {
        try {
            $cacheKey = "logs";
            $lastLogDate = null;
            $dataCache = [];

            if ($cache = $this->cacheService->getWithIdentifier($cacheKey)) {
                $dataCache = is_array($cache) ? $cache : [];
                $lastLogDate = \Carbon\Carbon::parse($dataCache[0]['created_at'])->addSecond();
            }

            $query = $this->log::orderBy('created_at', 'desc');

            if (!is_null($lastLogDate)) {
                $query->whereBetween('created_at', [$lastLogDate, now()]);
            }

            $data = $query->get();

            $dataArray = $data->toArray();

            if (!empty($dataCache)) {
                $dataCacheArray = array_map(function ($item) {
                    return (array) $item;
                }, $dataCache);
            } else {
                $dataCacheArray = [];
            }

            $dataMerged = array_merge($dataArray, $dataCacheArray);

            $this->cacheService->setWithIdentifier($cacheKey, $dataMerged, 86400);
            return response()->json(['count' => count($dataMerged), 'data' => $dataMerged]);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao pegar logs.', [
                'error_message' => $e->getMessage()
            ]);
        }
    }
}
