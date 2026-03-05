<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends Controller
{
    public function index()
    {
        // Proteção de Administrador
        if (Auth::user()->role !== 'admin_master' && Auth::user()->role !== 'dono') {
            return redirect()->route('vendas.index')->with('error', 'Acesso negado.');
        }

        $categorias = Categoria::where('estabelecimento_id', Auth::user()->estabelecimento_id)
            ->orderBy('nome', 'asc')
            ->get();

        return view('cadastros.categorias.categorias', compact('categorias'));
    }

    public function store(Request $request)
    {
        $estabelecimento = Estabelecimento::find(Auth::user()->estabelecimento_id);
        $vinculadosIds = $estabelecimento ? $estabelecimento->getVinculadosIds() : [Auth::user()->estabelecimento_id];

        // Cria a categoria em todos os estabelecimentos vinculados
        foreach ($vinculadosIds as $estId) {
            Categoria::create([
                'estabelecimento_id' => $estId,
                'nome' => $request->nome,
                'ativo' => true
            ]);
        }

        return redirect()->route('categorias.index')->with('success', 'Categoria cadastrada com sucesso em todos os estabelecimentos vinculados!');
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'admin_master' && Auth::user()->role !== 'dono') {
            return redirect()->route('vendas.index')->with('error', 'Acesso negado.');
        }

        $categoria = Categoria::where('estabelecimento_id', Auth::user()->estabelecimento_id)->findOrFail($id);

        return view('cadastros.categorias.edit', compact('categoria'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
        ]);

        $categoria = Categoria::where('estabelecimento_id', Auth::user()->estabelecimento_id)->findOrFail($id);
        $nomeAntigo = $categoria->nome;
        $categoria->update(['nome' => $request->nome]);

        // Atualiza categorias com o mesmo nome nos estabelecimentos vinculados
        $estabelecimento = Estabelecimento::find(Auth::user()->estabelecimento_id);
        if ($estabelecimento) {
            $outrosIds = $estabelecimento->getOutrosVinculadosIds();
            if (!empty($outrosIds)) {
                Categoria::whereIn('estabelecimento_id', $outrosIds)
                    ->where('nome', $nomeAntigo)
                    ->update(['nome' => $request->nome]);
            }
        }

        return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso!');
    }

    public function destroy($id)
    {
        try {
            $categoria = Categoria::where('estabelecimento_id', Auth::user()->estabelecimento_id)->findOrFail($id);
            $nomeCategoria = $categoria->nome;
            $categoria->delete();

            // Remove categorias com o mesmo nome nos vinculados
            $estabelecimento = Estabelecimento::find(Auth::user()->estabelecimento_id);
            if ($estabelecimento) {
                $outrosIds = $estabelecimento->getOutrosVinculadosIds();
                if (!empty($outrosIds)) {
                    Categoria::whereIn('estabelecimento_id', $outrosIds)
                        ->where('nome', $nomeCategoria)
                        ->delete();
                }
            }

            return redirect()->route('categorias.index')->with('success', 'Categoria enviada para a lixeira!');
        } catch (\Exception $e) {
            return redirect()->route('categorias.index')->with('error', 'Não é possível excluir. Existem produtos usando esta categoria.');
        }
    }

    public function toggleAtivo($id)
    {
        $categoria = Categoria::where('estabelecimento_id', Auth::user()->estabelecimento_id)->findOrFail($id);
        $categoria->update(['ativo' => !$categoria->ativo]);

        $status = $categoria->ativo ? 'ativada' : 'desativada';
        return redirect()->route('categorias.index')->with('success', "Categoria {$status} com sucesso!");
    }
}
