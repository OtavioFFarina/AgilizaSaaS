<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use App\Models\VendaItem;
use App\Models\EstoqueMovimentacao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HistoricoVendaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $estabelecimentoId = $user->estabelecimento_id;

        // Filtros de data (padrão: mês atual)
        $data_inicio = $request->query('data_inicio', now()->startOfMonth()->format('Y-m-d'));
        $data_fim = $request->query('data_fim', now()->endOfMonth()->format('Y-m-d'));

        $vendas = Venda::with('itens.produto')
            ->where('estabelecimento_id', $estabelecimentoId)
            ->whereIn('status', ['finalizada', 'cancelada'])
            ->whereDate('created_at', '>=', $data_inicio)
            ->whereDate('created_at', '<=', $data_fim)
            ->orderByDesc('created_at')
            ->get();

        return view('historico.historico_vendas', compact('vendas', 'data_inicio', 'data_fim'));
    }

    public function cancelar($id)
    {
        $user = Auth::user();

        $venda = Venda::where('id', $id)
            ->where('estabelecimento_id', $user->estabelecimento_id)
            ->where('status', 'finalizada')
            ->firstOrFail();

        DB::beginTransaction();

        try {
            // Devolve os itens ao estoque
            foreach ($venda->itens as $item) {
                EstoqueMovimentacao::create([
                    'estabelecimento_id' => $user->estabelecimento_id,
                    'produto_id' => $item->produto_id,
                    'tipo' => 'entrada',
                    'quantidade' => $item->quantidade,
                    'motivo' => "Estorno Venda #" . $venda->id,
                ]);
            }

            $venda->update(['status' => 'cancelada']);

            DB::commit();

            return response()->json(['sucesso' => true, 'mensagem' => 'Venda cancelada e estoque devolvido!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['sucesso' => false, 'mensagem' => 'Erro: ' . $e->getMessage()]);
        }
    }
}
