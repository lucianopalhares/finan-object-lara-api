<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\PaymentMethodEntity;


interface PaymentMethodInterface {


    public function show(string $account_number): ?PaymentMethodEntity;
}
