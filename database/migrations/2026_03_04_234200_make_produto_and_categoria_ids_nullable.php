<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Permite que produto_id e categoria_id sejam null.
     * Necessário para exclusão permanente de produtos/categorias da lixeira,
     * preservando o histórico de vendas e registros de produtos.
     */
    public function up(): void
    {
        // venda_itens: produto_id nullable (para quando excluir produto permanentemente)
        Schema::table('venda_itens', function (Blueprint $table) {
            $table->dropForeign(['produto_id']);
            $table->unsignedBigInteger('produto_id')->nullable()->change();
            $table->foreign('produto_id')->references('id')->on('produtos')->nullOnDelete();
        });

        // produtos: categoria_id nullable (para quando excluir categoria permanentemente)
        Schema::table('produtos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->unsignedBigInteger('categoria_id')->nullable()->change();
            $table->foreign('categoria_id')->references('id')->on('categorias')->nullOnDelete();
        });

        // estoque_movimentacoes: produto_id - trocar restrict por cascade
        Schema::table('estoque_movimentacoes', function (Blueprint $table) {
            $table->dropForeign(['produto_id']);
            $table->foreign('produto_id')->references('id')->on('produtos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venda_itens', function (Blueprint $table) {
            $table->dropForeign(['produto_id']);
            $table->unsignedBigInteger('produto_id')->nullable(false)->change();
            $table->foreign('produto_id')->references('id')->on('produtos')->restrictOnDelete();
        });

        Schema::table('produtos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->unsignedBigInteger('categoria_id')->nullable(false)->change();
            $table->foreign('categoria_id')->references('id')->on('categorias')->restrictOnDelete();
        });

        Schema::table('estoque_movimentacoes', function (Blueprint $table) {
            $table->dropForeign(['produto_id']);
            $table->foreign('produto_id')->references('id')->on('produtos')->restrictOnDelete();
        });
    }
};
