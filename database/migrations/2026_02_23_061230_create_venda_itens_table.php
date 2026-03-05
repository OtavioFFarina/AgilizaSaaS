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
        Schema::create('estoque_movimentacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('estabelecimento_id')->constrained('estabelecimentos')->cascadeOnDelete();
            $table->foreignId('produto_id')->constrained('produtos')->cascadeOnDelete();

            $table->enum('tipo', ['entrada', 'saida']);
            $table->integer('quantidade'); // Ex: 10, 50 (Sempre positivo, o 'tipo' diz se entrou ou saiu)
            $table->string('motivo')->nullable(); // Ex: 'Venda #102', 'Reposição de Fornecedor', 'Vencido'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venda_itens');
    }
};