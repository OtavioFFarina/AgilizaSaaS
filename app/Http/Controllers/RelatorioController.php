<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caixa;
use Illuminate\Support\Facades\Auth;

class RelatorioController extends Controller
{
    public function caixa(Request $request)
    {
        $user = Auth::user();
        $query = Caixa::with(['user', 'vendas.itens.produto'])
            ->where('estabelecimento_id', $user->estabelecimento_id)
            ->where('status', 'fechado');
        if ($user->role !== 'admin_master' && $user->role !== 'dono') {
            $query->where('user_id', $user->id)->whereDate('data_fechamento', today());
            $dataFiltro = today()->format('Y-m');
        } else {
            $dataFiltro = $request->data;
            if ($dataFiltro) {
                // $dataFiltro format is expected to be "YYYY-MM" (e.g., "2026-03")
                $ano = substr($dataFiltro, 0, 4);
                $mes = substr($dataFiltro, 5, 2);
                $query->whereYear('data_fechamento', $ano)->whereMonth('data_fechamento', $mes);
            } else {
                // Padrão: Mês atual
                $dataFiltro = now()->format('Y-m');
                $query->whereYear('data_fechamento', now()->year)->whereMonth('data_fechamento', now()->month);
            }
        }

        $fechamentos = $query->latest('data_fechamento')->get();
        $faturamentoTotal = 0;
        $custoTotal = 0;

        foreach ($fechamentos as $caixa) {
            $caixa->total_dinheiro = $caixa->vendas->where('forma_pagamento', 'DINHEIRO')->sum('valor_total');
            $caixa->total_credito = $caixa->vendas->where('forma_pagamento', 'CRÉDITO')->sum('valor_total');
            $caixa->total_debito = $caixa->vendas->where('forma_pagamento', 'DÉBITO')->sum('valor_total');
            $caixa->total_pix = $caixa->vendas->where('forma_pagamento', 'PIX')->sum('valor_total');

            $caixa->faturamento = $caixa->vendas->sum('valor_total');

            $caixa->custo = $caixa->vendas->flatMap->itens->sum(function ($item) {
                return $item->quantidade * ($item->produto->preco_compra ?? 0);
            });

            $sangrias = \App\Models\CaixaSangria::where('caixa_id', $caixa->id)->sum('valor');
            $caixa->total_sangrias = $sangrias;

            $caixa->esperado_gaveta = $caixa->valor_abertura + $caixa->total_dinheiro - $sangrias;

            $caixa->lucro_liquido = $caixa->faturamento - $caixa->custo;

            $faturamentoTotal += $caixa->faturamento;
            $custoTotal += $caixa->custo;
        }

        $lucroTotal = $faturamentoTotal - $custoTotal;

        $tipo_usuario = $user->role;

        return view('relatorios.caixa', compact('fechamentos', 'tipo_usuario', 'faturamentoTotal', 'custoTotal', 'lucroTotal', 'dataFiltro'));
    }
}