<?php

namespace App\Domain\Services;

use App\Infrastructure\Services\ServiceResponse;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Application\Resources\BankAccountResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Application\Requests\BankTransactionRequestCreate;
use App\Application\Resources\BankTransactionResource;
use App\Domain\Interfaces\BankAccountInterface;
use App\Domain\Interfaces\BankTransactionInterface;
use App\Domain\Interfaces\PaymentMethodInterface;

class BankTransactionService extends ServiceResponse {
    public function __construct(
        private BankTransactionInterface $repository,
        private PaymentMethodInterface $paymentMethodInterface,
        private BankAccountInterface $bankAccountInterface
    ) {}

    /**
     * Método para pegar unica tarefa pelo id.
     *
     * @param int $id ID da tarefa.
     * @return bool
     */
    public function create(array $params): bool
    {
        try {
            $paymentMethodEntity = $this->paymentMethodInterface->show($params['forma_pagamento']);

            $value = $params['valor'];
            $tax_rate = $paymentMethodEntity->tax_rate;

            $totalValue = $value + ($value * $tax_rate);

            $bankAccountEntity = $this->bankAccountInterface->updateBalance($params['numero_conta'], $totalValue);

            $transaction = array(
                'user_id' => auth('api')->user()->id,
                'payment_method_id' => $paymentMethodEntity->id,
                'bank_account_id' => $bankAccountEntity->id,
                'value' => $totalValue
            );

            $create = $this->repository->create($transaction);

            $this->setStatus(Response::HTTP_CREATED);
            $this->setMessage('Transação bancária cadastrada com sucesso!');
            $this->setCollectionItem($create);
            $this->setResource(BankTransactionResource::class);

            return true;

        } catch (Exception $e) {
            $this->setStatus($e->getCode());
            $this->setMessage('Erro ao salvar conta. Tente novamente mais tarde.');
            $this->setError($e->getMessage());
            $this->saveLog();
        }

        return false;
    }


    /**
     * Validar nova transação.
     *
     * @param Request $request Dados para salvar.
     * @return bool
     */
    function validateCreateData(Request $request): bool
    {
        try {
            $dataRequest = new BankTransactionRequestCreate();
            $dataRequest->validate($request);

            return true;
        } catch (ValidationException $e) {
            $this->handleValidation($e);
            return false;
        }
    }
}
