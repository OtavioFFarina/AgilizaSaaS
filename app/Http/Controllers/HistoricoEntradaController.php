<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EstoqueMovimentacao;
use Illuminate\Support\Facades\Auth;

class HistoricoEntradaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $estabelecimentoId = $user->estabelecimento_id;

        $query = EstoqueMovimentacao::with('produto')
            ->where('estabelecimento_id', $estabelecimentoId)
            ->orderByDesc('created_at');

        // Filtro por produto/sabor
        if ($request->filled('produto')) {
            $busca = $request->query('produto');
            $query->whereHas('produto', function ($q) use ($busca) {
                $q->where('nome', 'LIKE', "%{$busca}%")
                    ->orWhere('sabor', 'LIKE', "%{$busca}%");
            });
        }

        // Filtros de data
        if ($request->filled('data_inicial')) {
            $query->whereDate('created_at', '>=', $request->query('data_inicial'));
        }
        if ($request->filled('data_final')) {
            $query->whereDate('created_at', '<=', $request->query('data_final'));
        }

        $entradas = $query->get();

        return view('historico.entradas', compact('entradas'));
    }
}
