<?php

namespace App\Application\Controllers;

use App\Models\BankAccount;
use App\Models\BankTransaction;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\BankTransactionAudited;
use Illuminate\Support\Facades\Log;
use App\Cache\RedisCacheService;
use App\Models\BankTransactionAudit;
use App\Http\Controllers\Controller;

class BankTransactionAuditController extends Controller
{
    public function __construct(
        private RedisCacheService $cacheService,
        private BankTransactionAudit $bankTransactionAudit
    ) {}

    public function index(Request $request)
    {
        try {
            $cacheKey = "audits";
            $lastDataDate = null;
            $dataCache = [];
            $transacao = null;

            if ($request->has('transacao') === true) {
                $transacao = $request->get('transacao');
                $cacheKey .= "_$transacao";
            }

            if ($cache = $this->cacheService->getWithIdentifier($cacheKey)) {
                $dataCache = is_array($cache) ? $cache : [];
                $lastDataDate = \Carbon\Carbon::parse($dataCache[0]['created_at'])->addSecond();
            }

            $query = $this->bankTransactionAudit::orderBy('created_at', 'desc');

            if (!is_null($lastDataDate)) {
                $query->whereBetween('created_at', [$lastDataDate, now()]);
            }

            if (is_null($transacao) === false) {
                $query->whereBankTransactionId($transacao);
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
            Log::channel('database')->error('Erro ao pegar auditorias das transações.', [
                'error_message' => $e->getMessage()
            ]);
        }
    }
}
