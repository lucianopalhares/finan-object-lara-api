<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankAccountController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_conta' => 'required|integer|unique:bank_accounts,account_number',
            'saldo' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $data = $request->all();
        $data['account_number'] = $data['numero_conta'];
        $data['account_balance'] = $data['saldo'];

        unset($data['numero_conta'], $data['saldo']);

        $account = BankAccount::create($data);

        return response()->json($account, 201);
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'numero_conta' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $account = BankAccount::where('account_number', $request->input('numero_conta'))->first();

        if (!$account) {
            return response()->json(['message' => 'Numero da conta não encontrado.'], 404);
        }

        return response()->json($account, 200);
    }
}
