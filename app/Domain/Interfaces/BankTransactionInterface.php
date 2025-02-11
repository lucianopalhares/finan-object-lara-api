<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\BankTransactionEntity;

interface BankTransactionInterface {

    public function create(array $params): ?BankTransactionEntity;
}
