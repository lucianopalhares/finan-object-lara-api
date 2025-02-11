<?php

namespace App\Application\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BankAccountRequestShow
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
            'numero_conta' => 'required|integer',
        ], [
            'numero_conta.required' => 'O numero da conta é obrigatório.',
            'numero_conta.integer' => 'O numero da conta deve ter caracteres válidos.',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
