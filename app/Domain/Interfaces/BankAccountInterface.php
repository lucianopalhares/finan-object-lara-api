<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\BankAccountEntity;

/**
 * Interface para manipulação de contas bancárias no domínio do sistema.
 *
 * @package App\Domain\Interfaces
 */
interface BankAccountInterface
{
    /**
     * Obtém os detalhes de uma conta bancária pelo número da conta.
     *
     * @param int $account_number Número da conta bancária.
     * @return BankAccountEntity|null Retorna a entidade da conta bancária ou null se não encontrada.
     */
    public function show(int $account_number): ?BankAccountEntity;

    /**
     * Cria uma nova conta bancária com os parâmetros fornecidos.
     *
     * @param array $params Parâmetros necessários para criar a conta bancária.
     * @return BankAccountEntity|null Retorna a entidade da conta bancária criada ou null em caso de falha.
     */
    public function create(array $params): ?BankAccountEntity;

    /**
     * Atualiza o saldo da conta bancária com base no número da conta e no valor informado.
     *
     * @param int $account_number Número da conta bancária.
     * @param float $value Valor a ser adicionado ou removido do saldo da conta.
     * @return BankAccountEntity|null Retorna a entidade da conta bancária atualizada ou null em caso de falha.
     */
    public function updateBalance(int $account_number, float $value): ?BankAccountEntity;
}
