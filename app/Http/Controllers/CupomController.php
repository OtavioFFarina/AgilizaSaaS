<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venda;
use Illuminate\Support\Facades\Auth;

class CupomController extends Controller
{
    public function imprimir($id)
    {
        $user = Auth::user();

        $venda = Venda::with('itens.produto')
            ->where('id', $id)
            ->where('estabelecimento_id', $user->estabelecimento_id)
            ->firstOrFail();

        // Pega o nome do estabelecimento para o cabeçalho do cupom
        $nomeEstabelecimento = $user->estabelecimento->nome ?? 'AGILIZA PDV';

        return view('pdv.cupom', compact('venda', 'nomeEstabelecimento'));
    }
}
