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
        Schema::create('caixas', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('estabelecimento_id')->constrained('estabelecimentos')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users'); // Quem abriu o caixa

            $table->enum('status', ['aberto', 'fechado'])->default('fechado');
            $table->decimal('valor_abertura', 10, 2)->default(0.00);
            $table->decimal('valor_fechamento', 10, 2)->nullable();
            $table->dateTime('data_abertura')->useCurrent();
            $table->dateTime('data_fechamento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caixas');
    }
};