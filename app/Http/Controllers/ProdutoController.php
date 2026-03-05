<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Fornecedor;
use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Auth;

class ProdutoController extends Controller
{
    public function index()
    {
        // Proteção Sênior
        if (Auth::user()->role !== 'admin_master' && Auth::user()->role !== 'dono') {
            return redirect()->route('vendas.index')->with('error', 'Acesso negado.');
        }

        $estabelecimentoId = Auth::user()->estabelecimento_id;

        // Puxa as listas para os campos <select> do formulário
        $categorias = Categoria::where('estabelecimento_id', $estabelecimentoId)->get();
        $fornecedores = Fornecedor::where('estabelecimento_id', $estabelecimentoId)->get();

        // Puxa os produtos trazendo a família junto (Eager Loading)
        $produtos = Produto::with(['categoria', 'fornecedor'])
            ->where('estabelecimento_id', $estabelecimentoId)
            ->orderBy('id', 'desc')
            ->get();

        return view('cadastros.produtos.produtos', compact('produtos', 'categorias', 'fornecedores'));
    }

    public function store(Request $request)
    {
        // Limpando a formatação de R$ (1.000,50 -> 1000.50)
        $preco_venda = str_replace(['R$', '.', ' '], '', $request->preco_venda);
        $preco_venda = str_replace(',', '.', $preco_venda);

        $preco_compra = str_replace(['R$', '.', ' '], '', $request->preco_compra);
        $preco_compra = str_replace(',', '.', $preco_compra);

        $estabelecimento = Estabelecimento::find(Auth::user()->estabelecimento_id);
        $vinculadosIds = $estabelecimento ? $estabelecimento->getVinculadosIds() : [Auth::user()->estabelecimento_id];

        // Cria o produto em todos os estabelecimentos vinculados
        foreach ($vinculadosIds as $estId) {
            // Busca a categoria correspondente nesse estabelecimento (pelo nome)
            $categoriaOrigem = Categoria::find($request->categoria_id);
            $categoriaDestino = Categoria::where('estabelecimento_id', $estId)
                ->where('nome', $categoriaOrigem->nome)
                ->first();

            // Busca o fornecedor correspondente nesse estabelecimento (pelo nome)
            $fornecedorOrigem = Fornecedor::find($request->fornecedor_id);
            $fornecedorDestino = Fornecedor::where('estabelecimento_id', $estId)
                ->where('nome_fornecedor', $fornecedorOrigem->nome_fornecedor)
                ->first();

            Produto::create([
                'estabelecimento_id' => $estId,
                'nome' => $request->nome,
                'sabor' => $request->sabor,
                'categoria_id' => $categoriaDestino ? $categoriaDestino->id : $request->categoria_id,
                'fornecedor_id' => $fornecedorDestino ? $fornecedorDestino->id : $request->fornecedor_id,
                'preco_venda' => (float) $preco_venda,
                'preco_compra' => (float) $preco_compra,
                'ativo' => true
            ]);
        }

        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso em todos os estabelecimentos vinculados!');
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'admin_master' && Auth::user()->role !== 'dono') {
            return redirect()->route('vendas.index')->with('error', 'Acesso negado.');
        }

        $estabelecimentoId = Auth::user()->estabelecimento_id;
        $produto = Produto::where('estabelecimento_id', $estabelecimentoId)->findOrFail($id);
        $categorias = Categoria::where('estabelecimento_id', $estabelecimentoId)->get();
        $fornecedores = Fornecedor::where('estabelecimento_id', $estabelecimentoId)->get();

        return view('cadastros.produtos.edit', compact('produto', 'categorias', 'fornecedores'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'sabor' => 'nullable|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'fornecedor_id' => 'required|exists:fornecedores,id',
            'preco_venda' => 'required|string',
            'preco_compra' => 'required|string',
        ]);

        // Limpando a formatação de R$ (1.000,50 -> 1000.50)
        $preco_venda = str_replace(['R$', '.', ' '], '', $request->preco_venda);
        $preco_venda = str_replace(',', '.', $preco_venda);

        $preco_compra = str_replace(['R$', '.', ' '], '', $request->preco_compra);
        $preco_compra = str_replace(',', '.', $preco_compra);

        $produto = Produto::where('estabelecimento_id', Auth::user()->estabelecimento_id)->findOrFail($id);
        $produto->update([
            'nome' => $request->nome,
            'sabor' => $request->sabor,
            'categoria_id' => $request->categoria_id,
            'fornecedor_id' => $request->fornecedor_id,
            'preco_venda' => (float) $preco_venda,
            'preco_compra' => (float) $preco_compra,
        ]);

        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso!');
    }

    public function destroy($id)
    {
        try {
            $produto = Produto::where('estabelecimento_id', Auth::user()->estabelecimento_id)->findOrFail($id);
            $produto->delete();
            return redirect()->route('produtos.index')->with('success', 'Produto enviado para a lixeira.');
        } catch (\Exception $e) {
            return redirect()->route('produtos.index')->with('error', 'Este produto já possui vendas vinculadas e não pode ser excluído.');
        }
    }

    public function toggleAtivo($id)
    {
        $produto = Produto::where('estabelecimento_id', Auth::user()->estabelecimento_id)->findOrFail($id);
        $produto->update(['ativo' => !$produto->ativo]);

        $status = $produto->ativo ? 'ativado' : 'desativado';
        return redirect()->route('produtos.index')->with('success', "Produto {$status} com sucesso!");
    }
}