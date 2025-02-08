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
            'account_number' => 'required|integer|unique:bank_accounts',
            'account_balance' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $account = BankAccount::create($request->all());

        return response()->json($account, 201);
    }

    public function show(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account_number' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $account = BankAccount::where('account_number', $request->input('account_number'))->first();

        if (!$account) {
            return response()->json(['message' => 'Numero da conta não encontrado.'], 404);
        }

        return response()->json($account, 200);
    }
}
