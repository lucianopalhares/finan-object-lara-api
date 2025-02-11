<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\BankTransactionEntity;
use App\Domain\Interfaces\BankTransactionInterface;
use App\Infrastructure\Persistence\Models\BankTransaction;

class BankTransactionRepository implements BankTransactionInterface {

    public function create(array $params): ?BankTransactionEntity
    {
        $data = BankTransaction::create($params)->load(['bankAccount']);

        return new BankTransactionEntity(
            id: $data->id,
            user_id: $data->user_id,
            payment_method_id: $data->payment_method_id,
            bank_account_id: $data->bank_account_id,
            value: $data->value,
            account_number: $data->bankAccount->account_number,
            account_balance: $data->bankAccount->account_balance
        );
    }
}
