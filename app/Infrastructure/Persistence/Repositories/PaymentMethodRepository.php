<?php

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\PaymentMethodEntity;
use App\Domain\Interfaces\PaymentMethodInterface;
use App\Infrastructure\Persistence\Models\PaymentMethod;

class PaymentMethodRepository implements PaymentMethodInterface {

    public function show(string $code): ?PaymentMethodEntity {
        $data = PaymentMethod::where('code', $code)->first();

        return new PaymentMethodEntity(
            id: $data->id,
            code: $data->code,
            name: $data->name,
            tax_rate: $data->tax_rate
        );
    }
}
