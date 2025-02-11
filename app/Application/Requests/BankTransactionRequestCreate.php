<?php

namespace App\Application\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BankTransactionRequestCreate
{
    /**
     * Valida os dados de entrada para a criação de uma conta.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'forma_pagamento' => 'required|in:P,C,D',
            'numero_conta' => 'required|integer',
            'valor' => 'required|numeric|min:0.01'
        ], [
            'forma_pagamento.required' => 'Selecione uma forma de pagamento.',
            'forma_pagamento.in' => 'Formas de pagamentos válidas: P,C ou D.',
            'numero_conta.required' => 'O numero da conta é obrigatório.',
            'numero_conta.integer' => 'O numero da conta deve ter caracteres válidos.',
            'valor.required' => 'O valor de saldo é obrigatório.',
            'valor.numeric' => 'O valor de saldo deve ser numerico.',
            'valor.min' => 'Valor de saldo invalido.',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
