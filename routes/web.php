<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdvController;
use App\Http\Controllers\CaixaController;
use App\Http\Controllers\VendaController;
use App\Http\Controllers\EstoqueController;
use App\Http\Controllers\RelatorioController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\FornecedorController;
use App\Http\Controllers\ProdutoController;
use App\Http\Controllers\EstabelecimentoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\HistoricoVendaController;
use App\Http\Controllers\HistoricoEntradaController;
use App\Http\Controllers\CupomController;
use App\Http\Controllers\LixeiraController;
use App\Http\Controllers\VinculoController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Rotas do Caixa
    Route::post('/caixa/abrir', [CaixaController::class, 'abrir'])->name('caixa.abrir');
    Route::post('/caixa/fechar', [CaixaController::class, 'fechar'])->name('caixa.fechar');
    Route::post('/caixa/sangria', [CaixaController::class, 'sangria'])->name('caixa.sangria');
    Route::get('/estoque', [EstoqueController::class, 'index'])->name('estoque.index');
    Route::post('/estoque/entrada', [EstoqueController::class, 'store'])->name('estoque.store');
    Route::get('/estoque/sabores/{id_categoria}', [EstoqueController::class, 'getSabores'])->name('estoque.sabores');
    Route::get('/relatorios/caixa', [RelatorioController::class, 'caixa'])->name('relatorio.caixa');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/pdv/registrar-venda', [VendaController::class, 'registrar'])->name('venda.registrar');
    Route::get('/categorias', [CategoriaController::class, 'index'])->name('categorias.index');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::get('/categorias/{id}/edit', [CategoriaController::class, 'edit'])->name('categorias.edit');
    Route::put('/categorias/{id}', [CategoriaController::class, 'update'])->name('categorias.update');
    Route::delete('/categorias/{id}', [CategoriaController::class, 'destroy'])->name('categorias.destroy');
    Route::patch('/categorias/{id}/toggle', [CategoriaController::class, 'toggleAtivo'])->name('categorias.toggle');
    Route::get('/fornecedores', [FornecedorController::class, 'index'])->name('fornecedores.index');
    Route::post('/fornecedores', [FornecedorController::class, 'store'])->name('fornecedores.store');
    Route::get('/fornecedores/{id}/edit', [FornecedorController::class, 'edit'])->name('fornecedores.edit');
    Route::put('/fornecedores/{id}', [FornecedorController::class, 'update'])->name('fornecedores.update');
    Route::delete('/fornecedores/{id}', [FornecedorController::class, 'destroy'])->name('fornecedores.destroy');
    Route::patch('/fornecedores/{id}/toggle', [FornecedorController::class, 'toggleAtivo'])->name('fornecedores.toggle');
    Route::get('/produtos', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::post('/produtos', [ProdutoController::class, 'store'])->name('produtos.store');
    Route::get('/produtos/{id}/edit', [ProdutoController::class, 'edit'])->name('produtos.edit');
    Route::put('/produtos/{id}', [ProdutoController::class, 'update'])->name('produtos.update');
    Route::delete('/produtos/{id}', [ProdutoController::class, 'destroy'])->name('produtos.destroy');
    Route::patch('/produtos/{id}/toggle', [ProdutoController::class, 'toggleAtivo'])->name('produtos.toggle');
    Route::get('/estabelecimentos', [EstabelecimentoController::class, 'index'])->name('estabelecimentos.index');
    Route::post('/estabelecimentos', [EstabelecimentoController::class, 'store'])->name('estabelecimentos.store');
    Route::get('/estabelecimentos/{id}/edit', [EstabelecimentoController::class, 'edit'])->name('estabelecimentos.edit');
    Route::put('/estabelecimentos/{id}', [EstabelecimentoController::class, 'update'])->name('estabelecimentos.update');
    Route::delete('/estabelecimentos/{id}', [EstabelecimentoController::class, 'destroy'])->name('estabelecimentos.destroy');
    Route::patch('/estabelecimentos/{id}/toggle', [EstabelecimentoController::class, 'toggleAtivo'])->name('estabelecimentos.toggle');
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    Route::patch('/usuarios/{id}/toggle', [UsuarioController::class, 'toggleAtivo'])->name('usuarios.toggle');

    // Rotas da Lixeira Centralizada
    Route::get('/lixeira', [LixeiraController::class, 'index'])->name('lixeira.index');
    Route::post('/lixeira/{tipo}/{id}/restaurar', [LixeiraController::class, 'restaurar'])->name('lixeira.restaurar');
    Route::delete('/lixeira/{tipo}/{id}/force-delete', [LixeiraController::class, 'forceDelete'])->name('lixeira.forceDelete');

    // Rotas de Vínculo de Estabelecimentos
    Route::get('/vinculos', [VinculoController::class, 'index'])->name('vinculos.index');
    Route::post('/vinculos', [VinculoController::class, 'store'])->name('vinculos.store');
    Route::delete('/vinculos/{id}', [VinculoController::class, 'destroy'])->name('vinculos.destroy');

    // Rotas do Histórico
    Route::get('/historico/vendas', [HistoricoVendaController::class, 'index'])->name('historico.vendas');
    Route::post('/historico/vendas/{id}/cancelar', [HistoricoVendaController::class, 'cancelar'])->name('historico.vendas.cancelar');
    Route::get('/historico/entradas', [HistoricoEntradaController::class, 'index'])->name('historico.entradas');

    // Rota do Cupom
    Route::get('/cupom/{id}', [CupomController::class, 'imprimir'])->name('cupom.imprimir');
    Route::get('/pdv/imprimir-cupom/{id}', [CupomController::class, 'imprimir'])->name('cupom.pdv');

    // Rotas principais (PDV e Dashboard) - dentro do auth middleware
    Route::get('/vendas', [PdvController::class, 'index'])->name('vendas.index');
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/relatorio-estoque-baixo', [AdminController::class, 'relatorioEstoqueBaixo'])->name('dashboard.relatorio.estoque');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
