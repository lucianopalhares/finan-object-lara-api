<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PaymentMethod;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentMethod::create([
            'code' => 'P',
            'name' => 'Pix',
            'tax_rate' => 0.00,
        ]);

        PaymentMethod::create([
            'code' => 'C',
            'name' => 'Cartão de Crédito',
            'tax_rate' => 0.05,
        ]);

        PaymentMethod::create([
            'code' => 'D',
            'name' => 'Cartão de Débito',
            'tax_rate' => 0.03,
        ]);
    }
}
