<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BankAccount; // Importação do modelo

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BankAccount>
 */
class BankAccountFactory extends Factory
{
    /**
     * Define o modelo associado à factory.
     */
    protected $model = BankAccount::class;

    /**
     * Define o estado padrão do modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "account_number" => str_pad(fake()->unique()->randomNumber(6, true), 6, '0', STR_PAD_LEFT),
            "account_balance" => fake()->randomElement([5, 599, 101, 777, 1058, 59666]),
        ];
    }
}
