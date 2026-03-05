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
        Schema::create('vendas', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('estabelecimento_id')->constrained('estabelecimentos')->cascadeOnDelete();
            $table->foreignId('caixa_id')->nullable()->constrained('caixas')->restrictOnDelete(); // Venda fica ligada ao turno do caixa
            $table->foreignId('user_id')->constrained('users'); // Qual garçom/caixa vendeu

            $table->decimal('valor_total', 10, 2)->default(0.00);
            $table->enum('forma_pagamento', ['DINHEIRO', 'DEBITO', 'CREDITO', 'PIX'])->nullable();
            $table->enum('status', ['pendente', 'preparo', 'finalizada', 'cancelada'])->default('pendente');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendas');
    }
};