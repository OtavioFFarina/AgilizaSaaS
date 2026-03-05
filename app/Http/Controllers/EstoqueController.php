<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Estabelecimento;
use App\Models\EstoqueMovimentacao;
use Illuminate\Support\Facades\Auth;

class EstoqueController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $tipo_usuario = $user->role;

        // Se for admin/dono, pode selecionar qual estabelecimento ver
        if ($tipo_usuario === 'admin_master' || $tipo_usuario === 'dono') {
            $estabelecimento = Estabelecimento::find($user->estabelecimento_id);
            $estabelecimentosDisponiveis = Estabelecimento::whereIn('id', $estabelecimento->getVinculadosIds())
                ->orderBy('nome')
                ->get();

            // Usa o estabelecimento selecionado via query string, ou o padrão do usuário
            $estabelecimentoSelecionado = $request->query('estabelecimento_id', $user->estabelecimento_id);

            // Valida que o ID selecionado está entre os permitidos
            if (!$estabelecimentosDisponiveis->contains('id', $estabelecimentoSelecionado)) {
                $estabelecimentoSelecionado = $user->estabelecimento_id;
            }
        } else {
            $estabelecimentoSelecionado = $user->estabelecimento_id;
            $estabelecimentosDisponiveis = collect();
        }

        // Pega as categorias para o select de Nova Entrada
        $categorias = Categoria::where('estabelecimento_id', $estabelecimentoSelecionado)
            ->where('ativo', true)
            ->orderBy('nome')
            ->get();

        // Puxa todos os produtos ativos e já calcula o estoque na hora!
        $produtos = Produto::with('categoria')
            ->where('estabelecimento_id', $estabelecimentoSelecionado)
            ->where('ativo', true)
            ->get();

        // Cálculo de entradas e saídas
        foreach ($produtos as $prod) {
            $entradas = EstoqueMovimentacao::where('produto_id', $prod->id)
                ->where('estabelecimento_id', $estabelecimentoSelecionado)
                ->where('tipo', 'entrada')
                ->sum('quantidade');
            $saidas = EstoqueMovimentacao::where('produto_id', $prod->id)
                ->where('estabelecimento_id', $estabelecimentoSelecionado)
                ->where('tipo', 'saida')
                ->sum('quantidade');

            $prod->estoque_atual = $entradas - $saidas;

            $ultimaMovimentacao = EstoqueMovimentacao::where('produto_id', $prod->id)
                ->where('estabelecimento_id', $estabelecimentoSelecionado)
                ->latest()
                ->first();
            $prod->ultima_data = $ultimaMovimentacao ? $ultimaMovimentacao->created_at : null;
        }

        return view('estoque.estoque', compact(
            'produtos',
            'categorias',
            'tipo_usuario',
            'estabelecimentosDisponiveis',
            'estabelecimentoSelecionado'
        ));
    }

    // Função que recebe o formulário de "Nova Entrada" (Só para o Dono)
    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role !== 'dono' && $user->role !== 'admin_master') {
            return redirect()->back()->with('error', 'Apenas administradores podem dar entrada no estoque.');
        }

        // Usa o estabelecimento selecionado (vem do formulário oculto)
        $estabelecimentoId = $request->estabelecimento_id ?? $user->estabelecimento_id;

        // Registra a entrada na nossa tabela blindada
        EstoqueMovimentacao::create([
            'estabelecimento_id' => $estabelecimentoId,
            'produto_id' => $request->produto_id,
            'tipo' => 'entrada',
            'quantidade' => $request->quantidade,
            'motivo' => 'Compra de Fornecedor'
        ]);

        // Atualiza o custo de compra do produto
        $produto = Produto::find($request->produto_id);
        if ($produto && $request->valor_custo) {
            $custo = str_replace(['R$', '.', ' '], '', $request->valor_custo);
            $custo = str_replace(',', '.', $custo);
            $produto->update(['preco_compra' => (float) $custo]);
        }

        return redirect()->route('estoque.index', ['estabelecimento_id' => $estabelecimentoId])->with('success', 'Entrada de estoque registrada!');
    }

    // AJAX para buscar sabores filtrado por estabelecimento
    public function getSabores($id_categoria, Request $request)
    {
        $estabelecimentoId = $request->query('estabelecimento_id', Auth::user()->estabelecimento_id);

        $sabores = Produto::where('categoria_id', $id_categoria)
            ->where('estabelecimento_id', $estabelecimentoId)
            ->where('ativo', true)
            ->select('id', 'nome', 'sabor')
            ->orderBy('nome')
            ->get();

        return response()->json($sabores);
    }
}