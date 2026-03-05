<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estabelecimento;
use App\Models\EstabelecimentoVinculo;
use Illuminate\Support\Facades\Auth;

class VinculoController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'admin_master' && $user->role !== 'dono') {
            return redirect()->route('vendas.index')->with('error', 'Acesso negado.');
        }

        // Todos os estabelecimentos disponíveis
        $estabelecimentos = Estabelecimento::orderBy('nome', 'asc')->get();

        // Vínculos existentes
        $vinculos = EstabelecimentoVinculo::with(['origem', 'destino'])->get();

        return view('cadastros.vinculos.index', compact('estabelecimentos', 'vinculos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'estabelecimento_origem_id' => 'required|exists:estabelecimentos,id',
            'estabelecimento_destino_id' => 'required|exists:estabelecimentos,id|different:estabelecimento_origem_id',
        ]);

        // Verifica se já existe o vínculo (em qualquer direção)
        $existe = EstabelecimentoVinculo::where(function ($q) use ($request) {
            $q->where('estabelecimento_origem_id', $request->estabelecimento_origem_id)
                ->where('estabelecimento_destino_id', $request->estabelecimento_destino_id);
        })->orWhere(function ($q) use ($request) {
            $q->where('estabelecimento_origem_id', $request->estabelecimento_destino_id)
                ->where('estabelecimento_destino_id', $request->estabelecimento_origem_id);
        })->exists();

        if ($existe) {
            return redirect()->route('vinculos.index')->with('error', 'Esses estabelecimentos já estão vinculados!');
        }

        EstabelecimentoVinculo::create([
            'estabelecimento_origem_id' => $request->estabelecimento_origem_id,
            'estabelecimento_destino_id' => $request->estabelecimento_destino_id,
        ]);

        return redirect()->route('vinculos.index')->with('success', 'Vínculo criado com sucesso! Agora categorias, produtos e fornecedores serão compartilhados.');
    }

    public function destroy($id)
    {
        $vinculo = EstabelecimentoVinculo::findOrFail($id);
        $vinculo->delete();

        return redirect()->route('vinculos.index')->with('success', 'Vínculo removido com sucesso!');
    }
}
