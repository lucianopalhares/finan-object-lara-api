<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\BankTransaction;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Events\BankTransactionAudited;
use Illuminate\Support\Facades\Log;
use App\Cache\RedisCacheService;

class BankTransactionController extends Controller
{
    public function __construct(private RedisCacheService $cacheService) {}

    public function transact(Request $request)
    {
        try {
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
                return response()->json(['message' => 'Conta não encontrada!'], 404);
            }

            $cacheKey = "payment_method_id_" . $request->input('forma_pagamento');

            if ($cachedTasks = $this->cacheService->getWithIdentifier($cacheKey)) {
                $paymentMethod = $cachedTasks;
            } else {
                $paymentMethod = PaymentMethod::whereCode($request->input('forma_pagamento'))->first();

                if (!$paymentMethod) {
                    return response()->json(['message' => 'Forma de pagamento inválida!'], 400);
                }

                $this->cacheService->setWithIdentifier($cacheKey, $paymentMethod, 86400);
            }

            $value = $request->input('valor');
            $tax_rate = $paymentMethod->tax_rate;

            $totalValue = $value + ($value * $tax_rate);

            if ($account->account_balance < $totalValue) {
                return response()->json(['message' => 'Saldo insuficiente'], 404);
            }

            $account->account_balance -= $totalValue;
            $account->save();

            $transaction = array(
                'payment_method_id' => $paymentMethod->id,
                'bank_account_id' => $account->id,
                'value' => $totalValue
            );

            $bankTransaction = BankTransaction::create($transaction);
            $bankTransaction->load('paymentMethod', 'bankAccount', 'user');

            $b = json_encode($bankTransaction);

            $c = json_decode($b);

            $pay = $c->payment_method->tax_rate;

            event(new BankTransactionAudited($bankTransaction, 'created'));

            return response()->json([
                'numero_conta' => $account->account_number,
                'saldo' => $account->account_balance,
            ], 201);
        } catch (\Exception $e) {
            Log::channel('database')->error('Erro ao realizar a transação bancária.', [
                'error_message' => $e->getMessage()
            ]);
        }
    }
}
