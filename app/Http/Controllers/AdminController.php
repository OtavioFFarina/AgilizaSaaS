<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\Produto;
use App\Models\Estabelecimento;
use App\Models\EstoqueMovimentacao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Proteção de Rota: Só o dono/admin acessa os gráficos de dinheiro!
        if ($user->role !== 'admin_master' && $user->role !== 'dono') {
            return redirect()->route('vendas.index')->with('error', 'Acesso restrito a administradores.');
        }

        $estabelecimentoId = $user->estabelecimento_id;
        $mesAtual = now()->month;
        $anoAtual = now()->year;

        // A. Faturamento do Dia
        $faturamentoDia = Venda::where('estabelecimento_id', $estabelecimentoId)
            ->whereDate('created_at', today())
            ->where('status', 'finalizada')
            ->sum('valor_total');

        // B. Faturamento do Mês (Bruto)
        $faturamentoMes = Venda::where('estabelecimento_id', $estabelecimentoId)
            ->whereMonth('created_at', $mesAtual)
            ->whereYear('created_at', $anoAtual)
            ->where('status', 'finalizada')
            ->sum('valor_total');

        // Calcular Custo Total dos Produtos Vendidos no Mês
        $custoMes = DB::table('venda_itens')
            ->join('vendas', 'venda_itens.venda_id', '=', 'vendas.id')
            ->join('produtos', 'venda_itens.produto_id', '=', 'produtos.id')
            ->where('vendas.estabelecimento_id', $estabelecimentoId)
            ->whereMonth('vendas.created_at', $mesAtual)
            ->whereYear('vendas.created_at', $anoAtual)
            ->where('vendas.status', 'finalizada')
            ->sum(DB::raw('venda_itens.quantidade * produtos.preco_compra'));

        $faturamentoLiquidoMes = $faturamentoMes - $custoMes;

        // C. Estoque Baixo por Estabelecimento (Calculado em tempo real!)
        $estabelecimento = Estabelecimento::find($estabelecimentoId);
        $estabelecimentoIds = $estabelecimento ? $estabelecimento->getVinculadosIds() : [$estabelecimentoId];
        $estabelecimentosVinculados = Estabelecimento::whereIn('id', $estabelecimentoIds)->orderBy('nome')->get();

        $produtosBaixoEstoquePorEstabelecimento = [];
        $qtdBaixoEstoque = 0;

        foreach ($estabelecimentosVinculados as $est) {
            $produtosEst = Produto::with('categoria')
                ->where('estabelecimento_id', $est->id)
                ->where('ativo', true)
                ->get();

            $itens = [];
            foreach ($produtosEst as $prod) {
                $entradas = EstoqueMovimentacao::where('produto_id', $prod->id)
                    ->where('estabelecimento_id', $est->id)
                    ->where('tipo', 'entrada')
                    ->sum('quantidade');
                $saidas = EstoqueMovimentacao::where('produto_id', $prod->id)
                    ->where('estabelecimento_id', $est->id)
                    ->where('tipo', 'saida')
                    ->sum('quantidade');
                $saldo = $entradas - $saidas;

                if ($saldo <= 5) {
                    $itens[] = [
                        'produto' => $prod->nome,
                        'sabor' => $prod->sabor ?? '-',
                        'tipo' => $prod->categoria->nome ?? 'Geral',
                        'saldo_final' => $saldo
                    ];
                }
            }

            $produtosBaixoEstoquePorEstabelecimento[] = [
                'estabelecimento_id' => $est->id,
                'estabelecimento_nome' => $est->nome,
                'itens' => $itens
            ];
            $qtdBaixoEstoque += count($itens);
        }

        // D. Gráfico 1: Evolução de Vendas (Dias do Mês)
        $vendasMes = Venda::where('estabelecimento_id', $estabelecimentoId)
            ->whereMonth('created_at', $mesAtual)
            ->whereYear('created_at', $anoAtual)
            ->where('status', 'finalizada')
            ->selectRaw('DATE(created_at) as dia, SUM(valor_total) as total')
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        // Puxando apenas os dias e totais para jogar no JavaScript
        $labelsGrafico = $vendasMes->pluck('dia')->map(fn($d) => \Carbon\Carbon::parse($d)->format('d/m'))->toArray();
        $valoresGrafico = $vendasMes->pluck('total')->toArray();

        // E. Gráfico 2: Vendas por Categoria (Rosca)
        $vendasPorCategoria = DB::table('venda_itens')
            ->join('vendas', 'venda_itens.venda_id', '=', 'vendas.id')
            ->join('produtos', 'venda_itens.produto_id', '=', 'produtos.id')
            ->join('categorias', 'produtos.categoria_id', '=', 'categorias.id')
            ->where('vendas.estabelecimento_id', $estabelecimentoId)
            ->whereMonth('vendas.created_at', $mesAtual)
            ->whereYear('vendas.created_at', $anoAtual)
            ->where('vendas.status', 'finalizada')
            ->selectRaw('categorias.nome as categoria, SUM(venda_itens.quantidade) as qtd')
            ->groupBy('categorias.nome')
            ->get();

        $labelsCat = $vendasPorCategoria->pluck('categoria')->toArray();
        $valoresCat = $vendasPorCategoria->pluck('qtd')->toArray();

        // F. Gráfico 3: Vendas por Pagamento (Barras)
        $vendasPorPagamento = Venda::where('estabelecimento_id', $estabelecimentoId)
            ->whereMonth('created_at', $mesAtual)
            ->whereYear('created_at', $anoAtual)
            ->where('status', 'finalizada')
            ->selectRaw('forma_pagamento, SUM(valor_total) as total')
            ->groupBy('forma_pagamento')
            ->get();

        $labelsPag = $vendasPorPagamento->pluck('forma_pagamento')->toArray();
        $valoresPag = $vendasPorPagamento->pluck('total')->toArray();

        // Empacota tudo e manda pro Blade!
        return view('admin.dashboard', compact(
            'faturamentoDia',
            'faturamentoLiquidoMes',
            'produtosBaixoEstoquePorEstabelecimento',
            'qtdBaixoEstoque',
            'labelsGrafico',
            'valoresGrafico',
            'labelsCat',
            'valoresCat',
            'labelsPag',
            'valoresPag'
        ));
    }

    /**
     * Gera o relatório de reposição de estoque para impressão.
     */
    public function relatorioEstoqueBaixo()
    {
        $user = Auth::user();

        if ($user->role !== 'admin_master' && $user->role !== 'dono') {
            return redirect()->route('vendas.index')->with('error', 'Acesso restrito.');
        }

        $estabelecimentoId = $user->estabelecimento_id;
        $estabelecimento = Estabelecimento::find($estabelecimentoId);
        $estabelecimentoIds = $estabelecimento ? $estabelecimento->getVinculadosIds() : [$estabelecimentoId];
        $estabelecimentosVinculados = Estabelecimento::whereIn('id', $estabelecimentoIds)->orderBy('nome')->get();

        $dados = [];
        $totalItens = 0;

        foreach ($estabelecimentosVinculados as $est) {
            $produtosEst = Produto::with('categoria')
                ->where('estabelecimento_id', $est->id)
                ->where('ativo', true)
                ->get();

            $itens = [];
            foreach ($produtosEst as $prod) {
                $entradas = EstoqueMovimentacao::where('produto_id', $prod->id)
                    ->where('estabelecimento_id', $est->id)
                    ->where('tipo', 'entrada')
                    ->sum('quantidade');
                $saidas = EstoqueMovimentacao::where('produto_id', $prod->id)
                    ->where('estabelecimento_id', $est->id)
                    ->where('tipo', 'saida')
                    ->sum('quantidade');
                $saldo = $entradas - $saidas;

                if ($saldo <= 5) {
                    $itens[] = [
                        'produto' => $prod->nome,
                        'sabor' => $prod->sabor ?? '-',
                        'tipo' => $prod->categoria->nome ?? 'Geral',
                        'saldo_final' => $saldo
                    ];
                }
            }

            $dados[] = [
                'estabelecimento_nome' => $est->nome,
                'itens' => $itens
            ];
            $totalItens += count($itens);
        }

        return view('admin.relatorio_estoque_baixo', compact('dados', 'totalItens'));
    }
}