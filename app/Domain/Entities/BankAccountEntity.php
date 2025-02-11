<?php

namespace App\Domain\Entities;

use App\Domain\Sellers\Seller;

/**
 * Classe que representa uma conta no domínio do sistema.
 */
class BankAccountEntity
{
    /**
     * Construtor da classe.
     *
     * @param int           $id ID da conta.
     * @param int           $account_number Numero da conta.
     * @param float         $account_balance Saldo da conta.
     * @param string|null   $date Data da conta (opcional). Se não fornecida, será usada a data atual.
     */
    public function __construct(
        public int $id,
        public int $account_number,
        public string $account_balance
    ) {}
}
