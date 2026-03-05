<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     * Adiciona softDeletes e ativo nas tabelas que ainda não possuem.
     */
    public function up(): void
    {
        // Users: adicionar softDeletes e ativo
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('ativo')->default(true)->after('role');
            $table->softDeletes();
        });

        // Fornecedores: adicionar softDeletes (ativo já existe)
        Schema::table('fornecedores', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('ativo');
            $table->dropSoftDeletes();
        });

        Schema::table('fornecedores', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
};
