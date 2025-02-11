<?php

namespace App\Domain\Entities;

use App\Domain\Sellers\Seller;

/**
 * Classe que representa uma conta bancária no domínio do sistema.
 *
 * @package App\Domain\Entities
 */
class BankAccountEntity
{
    /**
     * Identificador único da conta bancária.
     *
     * @var int
     */
    public int $id;

    /**
     * Número da conta bancária.
     *
     * @var int
     */
    public int $account_number;

    /**
     * Saldo disponível na conta bancária.
     *
     * @var string
     */
    public string $account_balance;

    /**
     * Construtor da classe BankAccountEntity.
     *
     * @param int    $id              Identificador único da conta bancária.
     * @param int    $account_number  Número da conta bancária.
     * @param string $account_balance Saldo disponível na conta bancária.
     */
    public function __construct(
        int $id,
        int $account_number,
        string $account_balance
    ) {
        $this->id = $id;
        $this->account_number = $account_number;
        $this->account_balance = $account_balance;
    }
}
