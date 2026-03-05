<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Auth;

class EstabelecimentoController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin_master' && Auth::user()->role !== 'dono') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado.');
        }

        $estabelecimentos = Estabelecimento::orderBy('nome', 'asc')->get();

        return view('cadastros.estabelecimentos.estabelecimentos', compact('estabelecimentos'));
    }

    public function store(Request $request)
    {
        Estabelecimento::create([
            'nome' => $request->nome_estabelecimento,
            'cep' => $request->cep,
            'rua' => $request->rua,
            'bairro' => $request->bairro,
            'cidade' => $request->cidade,
            'estado' => $request->estado,
        ]);

        return redirect()->route('estabelecimentos.index')->with('success', 'Nova filial cadastrada com sucesso!');
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'admin_master' && Auth::user()->role !== 'dono') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado.');
        }

        $estabelecimento = Estabelecimento::findOrFail($id);

        return view('cadastros.estabelecimentos.edit', compact('estabelecimento'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cep' => 'required|string|max:9',
            'rua' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:2',
        ]);

        $estabelecimento = Estabelecimento::findOrFail($id);
        $estabelecimento->update($request->only(['nome', 'cep', 'rua', 'bairro', 'cidade', 'estado']));

        return redirect()->route('estabelecimentos.index')->with('success', 'Estabelecimento atualizado com sucesso!');
    }

    public function destroy($id)
    {
        try {
            $estabelecimento = Estabelecimento::findOrFail($id);
            $estabelecimento->delete();
            return redirect()->route('estabelecimentos.index')->with('success', 'Estabelecimento enviado para a lixeira!');
        } catch (\Exception $e) {
            return redirect()->route('estabelecimentos.index')->with('error', 'Não é possível excluir. Existem usuários ou vendas vinculadas a esta loja.');
        }
    }

    public function toggleAtivo($id)
    {
        $estabelecimento = Estabelecimento::findOrFail($id);
        $estabelecimento->update(['ativo' => !$estabelecimento->ativo]);

        $status = $estabelecimento->ativo ? 'ativado' : 'desativado';
        return redirect()->route('estabelecimentos.index')->with('success', "Estabelecimento {$status} com sucesso!");
    }
}