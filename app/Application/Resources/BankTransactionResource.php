<?php

namespace App\Application\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BankTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'numero_conta' => $this->account_number,
            'saldo' => $this->account_balance,
        ];
    }
}
