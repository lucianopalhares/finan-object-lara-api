<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\BankAccount;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class BankTransactionTest extends TestCase
{
    /**
     * Testar realizar transação bancária na rota /api/transacao
     */
    public function test_that_endpoint_create_bank_transaction_returns_a_successful_response(): void
    {
        $account = BankAccount::factory()->create();

        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/transacao', [
            "forma_pagamento" => ['D', 'C', 'P'][array_rand(['D', 'C', 'P'])],
            "numero_conta" => $account->account_number,
            "valor" => 5
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'numero_conta',
            'saldo'
        ]);
    }
}
