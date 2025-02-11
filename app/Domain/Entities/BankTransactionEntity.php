<?php

namespace App\Domain\Entities;

/**
 * Classe que representa uma transação bancária no domínio do sistema.
 *
 * @package App\Domain\Entities
 */
class BankTransactionEntity
{
    /**
     * Identificador único da transação bancária.
     *
     * @var int
     */
    public int $id;

    /**
     * Identificador do usuário que realizou a transação.
     *
     * @var int
     */
    public int $user_id;

    /**
     * Identificador do método de pagamento utilizado.
     *
     * @var int
     */
    public int $payment_method_id;

    /**
     * Identificador da conta bancária associada à transação.
     *
     * @var int
     */
    public int $bank_account_id;

    /**
     * Valor da transação bancária.
     *
     * @var float
     */
    public float $value;

    /**
     * Número da conta bancária relacionada à transação.
     *
     * @var int
     */
    public int $account_number;

    /**
     * Saldo da conta bancária após a transação (pode ser nulo).
     *
     * @var float|null
     */
    public float $account_balance;

    /**
     * Metodo de pagamento: D,P ou C.
     *
     * @var string
     */
    public string $payment_method_code;

    /**
     * Taxa do metodo de pagamento.
     *
     * @var float|null
     */
    public float $payment_method_tax_rate;

    /**
     * Nome do usuario.
     *
     * @var string
     */
    public string $username;

    /**
     * Construtor da classe BankTransactionEntity.
     *
     * @param int        $id                      Identificador único da transação bancária.
     * @param int        $user_id                 Identificador do usuário que realizou a transação.
     * @param int        $payment_method_id       Identificador do método de pagamento utilizado.
     * @param int        $bank_account_id         Identificador da conta bancária associada à transação.
     * @param float      $value                   Valor da transação bancária.
     * @param int        $account_number          Número da conta bancária relacionada à transação.
     * @param float|null $account_balance         Saldo da conta bancária após a transação (pode ser nulo).
     * @param string     $payment_method_code     Metodo de pagamento: D,P ou C.
     * @param float      $payment_method_tax_rate Taxa do metodo de pagamento.
     * @param string|null $username               Nome usuario. (pode ser nulo).
     */
    public function __construct(
        int $id,
        int $user_id,
        int $payment_method_id,
        int $bank_account_id,
        float $value,
        int $account_number,
        float $account_balance,
        string $payment_method_code,
        float $payment_method_tax_rate,
        string $username
    ) {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->payment_method_id = $payment_method_id;
        $this->bank_account_id = $bank_account_id;
        $this->value = $value;
        $this->account_number = $account_number;
        $this->account_balance = $account_balance;
        $this->payment_method_code = $payment_method_code;
        $this->payment_method_tax_rate = $payment_method_tax_rate;
        $this->username = $username;
    }
}
