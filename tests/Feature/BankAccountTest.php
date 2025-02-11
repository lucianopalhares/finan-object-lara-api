<?php

namespace Tests\Feature;

use App\Models\BankAccount;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tymon\JWTAuth\Facades\JWTAuth;

class BankAccountTest extends TestCase
{
    /**
     * Testar cadastro de conta bancária na rota /api/conta
     */
    public function test_that_endpoint_create_bank_account_returns_a_successful_response(): void
    {
        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/conta', [
            "numero_conta" => str_pad(fake()->unique()->randomNumber(6, true), 6, '0', STR_PAD_LEFT),
            "saldo" => fake()->randomElement([5, 599, 101, 777, 1058, 59666]),
        ]);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'numero_conta',
            'saldo'
        ]);
    }

    /**
     * Testar a rota de pegar conta atraves de um numero de conta especifico na rota /api/conta
     */
    public function test_that_endpoint_get_a_bank_account_returns_a_successful_response(): void
    {
        $account = BankAccount::factory()->create();

        $user = User::factory()->create();

        $token = JWTAuth::fromUser($user);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->get('/api/conta/?numero_conta=' . $account->account_number);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'numero_conta',
            'saldo'
        ]);
    }

}
