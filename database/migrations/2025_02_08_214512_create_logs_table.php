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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->string('level'); // Nível do log (ex: info, error)
            $table->text('message'); // Mensagem do log
            $table->json('context')->nullable(); // Dados adicionais (ex: exceções, contexto)
            $table->timestamp('created_at')->useCurrent(); // Data e hora do log
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
