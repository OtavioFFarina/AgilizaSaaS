<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('estabelecimento_vinculos', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('estabelecimento_origem_id')->constrained('estabelecimentos')->cascadeOnDelete();
            $table->foreignUuid('estabelecimento_destino_id')->constrained('estabelecimentos')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['estabelecimento_origem_id', 'estabelecimento_destino_id'], 'vinculo_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estabelecimento_vinculos');
    }
};
