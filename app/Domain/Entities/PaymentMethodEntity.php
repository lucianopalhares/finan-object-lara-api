<?php

namespace App\Domain\Entities;

/**
 * Classe que representa uma conta no domínio do sistema.
 */
class PaymentMethodEntity
{

    public function __construct(
        public int $id,
        public string $code,
        public string $name,
        public float $tax_rate,
    ) {}
}
