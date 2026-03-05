<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;
use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Auth;

class FornecedorController extends Controller
{
    public function index()
    {
        // Proteção: Apenas dono ou admin_master
        if (Auth::user()->role !== 'admin_master' && Auth::user()->role !== 'dono') {
            return redirect()->route('vendas.index')->with('error', 'Acesso negado.');
        }

        $fornecedores = Fornecedor::where('estabelecimento_id', Auth::user()->estabelecimento_id)
            ->orderBy('nome_fornecedor', 'asc')
            ->get();

        return view('cadastros.fornecedores.fornecedores', compact('fornecedores'));
    }

    public function store(Request $request)
    {
        $estabelecimento = Estabelecimento::find(Auth::user()->estabelecimento_id);
        $vinculadosIds = $estabelecimento ? $estabelecimento->getVinculadosIds() : [Auth::user()->estabelecimento_id];

        // Cria o fornecedor em todos os estabelecimentos vinculados
        foreach ($vinculadosIds as $estId) {
            Fornecedor::create([
                'estabelecimento_id' => $estId,
                'nome_fornecedor' => $request->nome_fornecedor,
                'cnpj' => $request->cnpj,
                'telefone' => $request->telefone,
                'email' => $request->email,
                'endereco' => $request->endereco,
                'ativo' => true
            ]);
        }

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor cadastrado com sucesso em todos os estabelecimentos vinculados!');
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'admin_master' && Auth::user()->role !== 'dono') {
            return redirect()->route('vendas.index')->with('error', 'Acesso negado.');
        }

        $fornecedor = Fornecedor::where('estabelecimento_id', Auth::user()->estabelecimento_id)->findOrFail($id);

        return view('cadastros.fornecedores.edit', compact('fornecedor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nome_fornecedor' => 'required|string|max:255',
            'cnpj' => 'nullable|string|max:18',
            'telefone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'endereco' => 'nullable|string|max:500',
        ]);

        $fornecedor = Fornecedor::where('estabelecimento_id', Auth::user()->estabelecimento_id)->findOrFail($id);
        $fornecedor->update($request->only(['nome_fornecedor', 'cnpj', 'telefone', 'email', 'endereco']));

        return redirect()->route('fornecedores.index')->with('success', 'Fornecedor atualizado com sucesso!');
    }

    public function destroy($id)
    {
        try {
            $fornecedor = Fornecedor::where('estabelecimento_id', Auth::user()->estabelecimento_id)->findOrFail($id);
            $fornecedor->delete();
            return redirect()->route('fornecedores.index')->with('success', 'Fornecedor enviado para a lixeira!');
        } catch (\Exception $e) {
            return redirect()->route('fornecedores.index')->with('error', 'Não é possível excluir. Existem produtos vinculados a este fornecedor.');
        }
    }

    public function toggleAtivo($id)
    {
        $fornecedor = Fornecedor::where('estabelecimento_id', Auth::user()->estabelecimento_id)->findOrFail($id);
        $fornecedor->update(['ativo' => !$fornecedor->ativo]);

        $status = $fornecedor->ativo ? 'ativado' : 'desativado';
        return redirect()->route('fornecedores.index')->with('success', "Fornecedor {$status} com sucesso!");
    }
}