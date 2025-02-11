<?php

namespace App\Domain\Services;

use App\Domain\Interfaces\BankAccountInterface;
use App\Infrastructure\Services\ServiceResponse;
use Illuminate\Http\Response;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use App\Application\Resources\BankAccountResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Application\Requests\BankAccountRequestCreate;
use App\Application\Requests\BankAccountRequestShow;

class BankAccountService extends ServiceResponse {
    public function __construct(private BankAccountInterface $repository) {}

    public function show(int $account_number): bool
    {
        try {
            $data = $this->repository->show($account_number);

            $this->setStatus(Response::HTTP_CREATED);
            $this->setMessage('Contas bancárias listadas com sucesso!');
            $this->setCollectionItem($data);
            $this->setResource(BankAccountResource::class);

            return true;
        } catch (ModelNotFoundException $e) {
            $this->setStatus(Response::HTTP_NOT_FOUND);
            $this->setMessage('Conta bancária não encontrada.');
            $this->setError($e->getMessage());
            $this->saveLog();
        } catch (Exception $e) {
            $this->setStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
            $this->setMessage('Erro ao listar contas.Tente novamente mais tarde.');
            $this->setError($e->getMessage());
            $this->saveLog();
        }

        return false;
    }

    /**
     * Método para pegar unica tarefa pelo id.
     *
     * @param int $id ID da tarefa.
     * @return bool
     */
    public function create(array $params): bool
    {
        try {
            $data = $params;
            $data['account_number'] = $data['numero_conta'];
            $data['account_balance'] = $data['saldo'];

            unset($data['numero_conta'], $data['saldo']);

            $create = $this->repository->create($data);

            $this->setStatus(Response::HTTP_CREATED);
            $this->setMessage('Conta bancária cadastrada com sucesso!');
            $this->setCollectionItem($create);
            $this->setResource(BankAccountResource::class);

            return true;

        } catch (Exception $e) {
            $this->setStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
            $this->setMessage('Erro ao salvar conta. Tente novamente mais tarde.');
            $this->setError($e->getMessage());
            $this->saveLog();
        }

        return false;
    }


    /**
     * Validar nova conta.
     *
     * @param Request $request Dados para salvar.
     * @return bool
     */
    function validateCreateData(Request $request): bool
    {
        try {
            $dataRequest = new BankAccountRequestCreate();
            $dataRequest->validate($request);

            return true;
        } catch (ValidationException $e) {
            $this->handleValidation($e);
            return false;
        }
    }

    /**
     * Validar exibir conta.
     *
     * @param Request $request Dados para buscar.
     * @return bool
     */
    function validateShowData(Request $request): bool
    {
        try {
            $dataRequest = new BankAccountRequestShow();
            $dataRequest->validate($request);

            return true;
        } catch (ValidationException $e) {
            $this->handleValidation($e);
            return false;
        }
    }
}
