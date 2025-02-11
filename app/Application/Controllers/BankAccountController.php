<?php

namespace App\Application\Controllers;

use App\Domain\Services\BankAccountService;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class BankAccountController extends Controller
{
    protected $bankAccountService;

    /**
     * Injeção de dependência do construtor.
     *
     * @param BankAccountService $bankAccountService
     */
    public function __construct(BankAccountService $bankAccountService)
    {
        $this->bankAccountService = $bankAccountService;
        $this->bankAccountService->setDataFromCollection(true);
    }

    /**
     * Criar uma conta bancaria.
     *
     * @param Request $request    Contem os dados da conta.
     * @return JsonResponse
     */
    function create(Request $request): JsonResponse
    {
        $passed = $this->bankAccountService->validateCreateData($request);

        if ($passed === true)
            $this->bankAccountService->create($request->all());

        return $this->bankAccountService->getJsonResponse();
    }

    /**
     * Obter uma conta bancaria.
     *
     * @param Request $request    Contem o numero da conta.
     * @return JsonResponse
     */
    function show(Request $request): JsonResponse
    {
        $passed = $this->bankAccountService->validateShowData($request);

        if ($passed === true)
            $this->bankAccountService->show($request->get('numero_conta'));

        return $this->bankAccountService->getJsonResponse();
    }
}
