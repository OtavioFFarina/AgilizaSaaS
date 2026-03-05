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
        Schema::create('plano_modulo', function (Blueprint $table) {
            // Ligação com o Plano
            $table->foreignId('plano_id')->constrained('planos')->cascadeOnDelete();
            // Ligação com o Módulo
            $table->foreignId('modulo_id')->constrained('modulos')->cascadeOnDelete();

            // Evita que a gente cadastre o mesmo módulo duas vezes no mesmo plano
            $table->unique(['plano_id', 'modulo_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plano_modulo');
    }
};