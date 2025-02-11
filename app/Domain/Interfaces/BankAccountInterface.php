<?php

namespace App\Domain\Interfaces;

use App\Domain\Entities\BankAccountEntity;


interface BankAccountInterface {


    public function show(int $account_number): ?BankAccountEntity;

    public function create(array $params): ?BankAccountEntity;

    public function updateBalance(int $account_number, float $value): ?BankAccountEntity;
}
