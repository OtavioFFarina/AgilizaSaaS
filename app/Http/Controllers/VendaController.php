<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\VendaItem;
use App\Models\EstoqueMovimentacao;
use App\Models\Produto;
use App\Models\Caixa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class VendaController extends Controller
{
    public function registrar(Request $request)
    {
        $user = Auth::user();

        $caixa = Caixa::where('estabelecimento_id', $user->estabelecimento_id)
            ->where('user_id', $user->id)
            ->where('status', 'aberto')
            ->first();

        if (!$caixa) {
            return response()->json(['sucesso' => false, 'mensagem' => 'Caixa fechado!']);
        }

        try {
            // Validação de Estoque ANTES de processar a venda
            foreach ($request->itens as $item) {
                $produto = Produto::find($item['id']);
                if (!$produto) {
                    return response()->json(['sucesso' => false, 'mensagem' => 'Produto não encontrado.']);
                }

                $entradas = EstoqueMovimentacao::where('produto_id', $produto->id)
                    ->where('estabelecimento_id', $user->estabelecimento_id)
                    ->where('tipo', 'entrada')
                    ->sum('quantidade');
                $saidas = EstoqueMovimentacao::where('produto_id', $produto->id)
                    ->where('estabelecimento_id', $user->estabelecimento_id)
                    ->where('tipo', 'saida')
                    ->sum('quantidade');
                $saldoAtual = $entradas - $saidas;

                if ($saldoAtual < $item['qtd']) {
                    $nomeCompleto = $produto->nome . ($produto->sabor ? ' - ' . $produto->sabor : '');
                    return response()->json([
                        'sucesso' => false,
                        'mensagem' => "Estoque insuficiente para \"{$nomeCompleto}\". Disponível: {$saldoAtual} un, solicitado: {$item['qtd']} un."
                    ]);
                }
            }

            DB::beginTransaction();

            $venda = Venda::create([
                'estabelecimento_id' => $user->estabelecimento_id,
                'caixa_id' => $caixa->id,
                'user_id' => $user->id,
                'valor_total' => $request->total,
                'forma_pagamento' => strtoupper($request->forma_pagamento),
                'status' => 'finalizada'
            ]);

            foreach ($request->itens as $item) {
                $produto = Produto::findOrFail($item['id']);

                VendaItem::create([
                    'venda_id' => $venda->id,
                    'produto_id' => $produto->id,
                    'quantidade' => $item['qtd'],
                    'preco_unitario' => $item['preco'],
                    'subtotal' => $item['qtd'] * $item['preco']
                ]);

                EstoqueMovimentacao::create([
                    'estabelecimento_id' => $user->estabelecimento_id,
                    'produto_id' => $produto->id,
                    'tipo' => 'saida',
                    'quantidade' => $item['qtd'],
                    'motivo' => "Venda #" . $venda->id
                ]);

                $estoqueAtual = EstoqueMovimentacao::where('produto_id', $produto->id)
                    ->selectRaw("SUM(CASE WHEN tipo = 'entrada' THEN quantidade ELSE -quantidade END) as total")
                    ->value('total');

                if ($estoqueAtual <= 5) {
                    try {
                        Http::timeout(2)->post('https://webhook.automaticbot.pro/webhook/94354dcd-32b9-4e30-9a88-e9b6083746eb', [
                            'produto' => $produto->nome,
                            'estoque_atual' => $estoqueAtual,
                            'data_alerta' => now()->toDateTimeString()
                        ]);
                    } catch (\Exception $e) {
                    }
                }
            }

            DB::commit();

            return response()->json([
                'sucesso' => true,
                'mensagem' => 'Venda registrada com sucesso!',
                'id_venda' => $venda->id
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['sucesso' => false, 'mensagem' => 'Erro: ' . $e->getMessage()]);
        }
    }
}