<?php

namespace App\Application\Controllers;

use App\Models\BankAccount;
use App\Models\BankTransaction;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\BankTransactionAudited;
use Illuminate\Support\Facades\Log;
use App\Domain\Services\BankTransactionService;
use App\Http\Controllers\Controller;

class BankTransactionController extends Controller
{
    protected $bankTransactionService;

    /**
     * Injeção de dependência do construtor.
     *
     * @param BankTransactionService $bankTransactionService
     */
    public function __construct(BankTransactionService $bankTransactionService)
    {
        $this->bankTransactionService = $bankTransactionService;
        $this->bankTransactionService->setDataFromCollection(true);
    }

    public function transact(Request $request)
    {
        $passed = $this->bankTransactionService->validateCreateData($request);

        if ($passed === true)
            $this->bankTransactionService->create($request->all());

        return $this->bankTransactionService->getJsonResponse();
    }
}
