<?php

namespace App\Domain\Entities;

/**
 * Classe que representa um método de pagamento no domínio do sistema.
 *
 * @package App\Domain\Entities
 */
class PaymentMethodEntity
{
    /**
     * Identificador único do método de pagamento.
     *
     * @var int
     */
    public int $id;

    /**
     * Código do método de pagamento.
     *
     * @var string
     */
    public string $code;

    /**
     * Nome do método de pagamento.
     *
     * @var string
     */
    public string $name;

    /**
     * Taxa aplicada ao método de pagamento.
     *
     * @var float
     */
    public float $tax_rate;

    /**
     * Construtor da classe PaymentMethodEntity.
     *
     * @param int    $id        Identificador único do método de pagamento.
     * @param string $code      Código do método de pagamento.
     * @param string $name      Nome do método de pagamento.
     * @param float  $tax_rate  Taxa aplicada ao método de pagamento.
     */
    public function __construct(
        int $id,
        string $code,
        string $name,
        float $tax_rate
    ) {
        $this->id = $id;
        $this->code = $code;
        $this->name = $name;
        $this->tax_rate = $tax_rate;
    }
}
