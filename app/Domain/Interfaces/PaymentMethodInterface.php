<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\PaymentMethodEntity;

/**
 * Interface para manipulação dos métodos de pagamento no domínio do sistema.
 *
 * @package App\Domain\Interfaces
 */
interface PaymentMethodInterface
{
    /**
     * Obtém um método de pagamento associado a um número de conta.
     *
     * @param string $account_number Número da conta bancária associado ao método de pagamento.
     * @return PaymentMethodEntity|null Retorna a entidade do método de pagamento ou null se não encontrado.
     */
    public function show(string $account_number): ?PaymentMethodEntity;
}
