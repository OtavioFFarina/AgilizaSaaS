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
        Schema::create('assinaturas', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('estabelecimento_id')->constrained('estabelecimentos')->cascadeOnDelete();
            $table->foreignId('plano_id')->constrained('planos')->restrictOnDelete();
            $table->enum('status', ['ativa', 'atrasada', 'cancelada'])->default('ativa');
            $table->date('data_vencimento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assinaturas');
    }
};