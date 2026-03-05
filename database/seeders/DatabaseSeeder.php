<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Cria o Estabelecimento padrão
        $loja = Estabelecimento::create([
            'nome' => 'AgilizaPDV',
        ]);

        // 2. Cria o Usuário Administrador Master
        User::create([
            'name' => 'Admin',
            'email' => 'admin@agiliza.com',
            'password' => Hash::make('admin098'),
            'role' => 'admin_master',
            'estabelecimento_id' => $loja->id,
        ]);
    }
}