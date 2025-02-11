<?php

namespace App\Application\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class BankAccountRequestCreate
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
            'numero_conta' => 'required|integer|unique:bank_accounts,account_number',
            'saldo' => 'required|numeric|min:0.01'
        ], [
            'numero_conta.required' => 'O numero da conta é obrigatório.',
            'numero_conta.integer' => 'O numero da conta deve ter caracteres válidos.',
            'numero_conta.unique' => 'Já possui uma conta cadastrada com este numero.',
            'saldo.required' => 'O valor de saldo é obrigatório.',
            'saldo.numeric' => 'O valor de saldo deve ser numerico.',
            'saldo.min' => 'Valor de saldo invalido.',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
