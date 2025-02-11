<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\BankTransactionEntity;

/**
 * Interface para manipulação de transações bancárias no domínio do sistema.
 *
 * @package App\Domain\Interfaces
 */
interface BankTransactionInterface
{
    /**
     * Cria uma nova transação bancária com os parâmetros fornecidos.
     *
     * @param array $params Parâmetros necessários para criar a transação bancária.
     * @return BankTransactionEntity|null Retorna a entidade da transação criada ou null em caso de falha.
     */
    public function create(array $params): ?BankTransactionEntity;
}
