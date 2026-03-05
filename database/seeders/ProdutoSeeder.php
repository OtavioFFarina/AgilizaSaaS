<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Estabelecimento;

class ProdutoSeeder extends Seeder
{
    public function run(): void
    {
        // Pega o Atacadão do Sorvete que já criamos no banco
        $loja = Estabelecimento::first();

        if (!$loja) {
            $this->command->error('Nenhuma loja encontrada! Rode o DatabaseSeeder primeiro.');
            return;
        }

        // 1. Criando as Categorias
        $catBebida = Categoria::create(['estabelecimento_id' => $loja->id, 'nome' => 'Bebida', 'ativo' => true]);
        $catPicole = Categoria::create(['estabelecimento_id' => $loja->id, 'nome' => 'Picolé - Slechi', 'ativo' => true]);
        $catPote = Categoria::create(['estabelecimento_id' => $loja->id, 'nome' => 'Pote 2.5L Trufado', 'ativo' => true]);

        // 2. Criando os Produtos e amarrando nas categorias e na loja
        Produto::create([
            'estabelecimento_id' => $loja->id,
            'categoria_id' => $catBebida->id,
            'nome' => 'Água',
            'sabor' => 'Com Gás',
            'preco_venda' => 3.00,
            'preco_compra' => 0.75,
            'ativo' => true
        ]);

        Produto::create([
            'estabelecimento_id' => $loja->id,
            'categoria_id' => $catPicole->id,
            'nome' => 'Picolé',
            'sabor' => 'Leite Condensado',
            'preco_venda' => 2.50,
            'preco_compra' => 0.50,
            'ativo' => true
        ]);

        Produto::create([
            'estabelecimento_id' => $loja->id,
            'categoria_id' => $catPote->id,
            'nome' => 'Pote 2.5L',
            'sabor' => 'Morango Trufado',
            'preco_venda' => 42.00,
            'preco_compra' => 20.00,
            'ativo' => true
        ]);

        Produto::create([
            'estabelecimento_id' => $loja->id,
            'categoria_id' => $catPote->id,
            'nome' => 'Pote 2.5L',
            'sabor' => 'Ninho Trufado',
            'preco_venda' => 42.00,
            'preco_compra' => 20.00,
            'ativo' => true
        ]);
    }
}