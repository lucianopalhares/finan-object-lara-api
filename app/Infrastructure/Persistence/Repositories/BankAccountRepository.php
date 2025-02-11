<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\BankAccountEntity;
use App\Domain\Interfaces\BankAccountInterface;
use App\Infrastructure\Persistence\Models\BankAccount;

class BankAccountRepository implements BankAccountInterface {

    public function show(int $account_number): ?BankAccountEntity {
        $data = BankAccount::where('account_number', $account_number)->firstOrFail();

        return new BankAccountEntity(
            id: $data->id,
            account_number: $data->account_number,
            account_balance: $data->account_balance
        );
    }

    public function create(array $params): ?BankAccountEntity
    {
        $data = BankAccount::create($params);

        return new BankAccountEntity(
            id: $data->id,
            account_number: $data->account_number,
            account_balance: $data->account_balance
        );
    }

    public function updateBalance(int $account_number, float $value): ?BankAccountEntity
    {
        $data = BankAccount::where('account_number', $account_number)->firstOrFail();

        if ($data->account_balance >= $value) {
            $data->account_balance -= $value;
            $data->save();
        } else {
            throw new \Exception("Saldo indisponivel", 404);
        }

        return new BankAccountEntity(
            id: $data->id,
            account_number: $data->account_number,
            account_balance: $data->account_balance
        );
    }
}
