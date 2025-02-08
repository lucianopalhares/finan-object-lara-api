<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BankTransactionController extends Controller
{
    public function transact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'forma_pagamento' => 'required|in:P,C,D',
            'numero_conta' => 'required|integer',
            'valor' => 'required|numeric|min:0.01'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $account = BankAccount::where('account_number', $request->input('numero_conta'))->first();

        if (!$account) {
            return response()->json(['message' => 'Account not found'], 404);
        }

        $paymentMethod = PaymentMethod::whereCode($request->input('forma_pagamento'));

        if (!$paymentMethod) {
            return response()->json(['message' => 'Invalid payment method'], 400);
        }

        $value = $request->input('valor');
        $tax_rate = $paymentMethod->tax_rate;

        $totalValue = $value + ($value * $tax_rate);

        if ($account->account_balance < $totalValue) {
            return response()->json(['message' => 'Saldo insuficiente'], 404);
        }

        $account->account_balance -= $totalValue;
        $account->save();

        return response()->json($account, 200);
    }
}
