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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('estabelecimento_id')->constrained('estabelecimentos')->cascadeOnDelete();
            $table->foreignId('categoria_id')->constrained('categorias')->restrictOnDelete(); // Restrict: não deixa apagar categoria se tiver produto nela

            $table->string('nome');
            $table->string('sabor')->nullable();
            $table->decimal('preco_venda', 10, 2);
            $table->decimal('preco_compra', 10, 2)->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};