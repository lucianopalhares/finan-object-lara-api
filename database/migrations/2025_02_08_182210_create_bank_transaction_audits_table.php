<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bank_transaction_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_transaction_id')->nullable()->constrained();
            $table->string('user_name')->nullable();
            $table->string('payment_method_code');
            $table->string('payment_method_tax_rate');
            $table->string('bank_account_number');
            $table->enum('action', ['created', 'updated', 'deleted']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_transaction_audits');
    }
};
