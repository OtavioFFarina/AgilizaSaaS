<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Produto;
use App\Models\Caixa;
use Illuminate\Support\Facades\Auth;

class PdvController extends Controller
{
    public function index()
    {
        $estabelecimentoId = Auth::user()->estabelecimento_id;

        // Pega o último caixa aberto por esse usuário (se houver)
        $caixa = Caixa::where('estabelecimento_id', $estabelecimentoId)
            ->where('user_id', Auth::id())
            ->latest()
            ->first();

        $caixaStatus = ($caixa && $caixa->status === 'aberto') ? 'aberto' : 'fechado';

        // Pega apenas as categorias ativas DESSA loja
        $categorias = Categoria::where('estabelecimento_id', $estabelecimentoId)
            ->where('ativo', true)
            ->orderBy('nome')
            ->get();

        // Pega os produtos ativos DESSA loja e já agrupa pela categoria (Mágica do Laravel!)
        $produtos = Produto::where('estabelecimento_id', $estabelecimentoId)
            ->where('ativo', true)
            ->get()
            ->groupBy('categoria_id');

        // Manda tudo pra nossa tela (View)
        return view('pdv.index', compact('categorias', 'produtos', 'caixaStatus'));
    }
}
