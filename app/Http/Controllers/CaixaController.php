<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Caixa;
use App\Models\Venda;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CaixaController extends Controller
{
    public function abrir(Request $request)
    {
        $estabelecimentoId = Auth::user()->estabelecimento_id;
        $valorFundo = str_replace(['R$', '.', ' '], '', $request->valor_abertura);
        $valorFundo = str_replace(',', '.', $valorFundo);

        Caixa::create([
            'estabelecimento_id' => $estabelecimentoId,
            'user_id' => Auth::id(),
            'status' => 'aberto',
            'valor_abertura' => (float) $valorFundo,
            'data_abertura' => now(),
        ]);

        return redirect()->route('vendas.index')->with('success', 'Caixa aberto com sucesso!');
    }

    public function sangria(Request $request)
    {
        if (Auth::user()->role !== 'dono' && Auth::user()->role !== 'admin_master') {
            return redirect()->back()->with('error', 'Apenas o proprietário pode realizar Sangrias.');
        }

        if (!\Illuminate\Support\Facades\Hash::check($request->password_sangria, Auth::user()->password)) {
            return redirect()->back()->with('error', 'Senha incorreta. Sangria não autorizada.');
        }

        $caixa = Caixa::where('estabelecimento_id', Auth::user()->estabelecimento_id)
            ->where('status', 'aberto')
            ->first();

        if (!$caixa) {
            return redirect()->back()->with('error', 'Nenhum caixa aberto para sangria.');
        }

        // Limpa a formatação
        $valor = str_replace(['R$', '.', ' '], '', $request->valor_sangria);
        $valor = str_replace(',', '.', $valor);

        \App\Models\CaixaSangria::create([
            'caixa_id' => $caixa->id,
            'valor' => (float) $valor,
            'observacao' => 'Retirada solicitada pelo Dono'
        ]);

        return redirect()->route('vendas.index')->with('success', 'Sangria registrada com sucesso!');
    }

    public function fechar(Request $request)
    {
        $caixa = Caixa::where('estabelecimento_id', Auth::user()->estabelecimento_id)
            ->where('user_id', Auth::id())
            ->where('status', 'aberto')
            ->first();

        if (!$caixa) {
            return redirect()->route('relatorio.caixa');
        }

        $caixa->update([
            'status' => 'fechado',
            'data_fechamento' => now()
        ]);

        return redirect()->route('relatorio.caixa');
    }
}