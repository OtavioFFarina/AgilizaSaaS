<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Estabelecimento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        // Proteção Sênior
        if (Auth::user()->role !== 'admin_master' && Auth::user()->role !== 'dono') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado.');
        }

        // Puxa as lojas para o select
        $estabelecimentos = Estabelecimento::orderBy('nome', 'asc')->get();

        // Puxa todos os usuários do sistema e a qual loja eles pertencem
        $usuarios = User::with('estabelecimento')->orderBy('name', 'asc')->get();

        return view('cadastros.usuarios.usuarios', compact('usuarios', 'estabelecimentos'));
    }

    public function store(Request $request)
    {
        // Validação rápida
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:caixa,dono,admin_master',
            'estabelecimento_id' => 'required|exists:estabelecimentos,id'
        ]);

        // Criando o usuário no banco de dados nativo do Laravel
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Criptografia Sênior!
            'role' => $request->role,
            'estabelecimento_id' => $request->estabelecimento_id,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuário criado com sucesso!');
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'admin_master' && Auth::user()->role !== 'dono') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado.');
        }

        $usuario = User::findOrFail($id);
        $estabelecimentos = Estabelecimento::orderBy('nome', 'asc')->get();

        return view('cadastros.usuarios.edit', compact('usuario', 'estabelecimentos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:caixa,dono,admin_master',
            'estabelecimento_id' => 'required|exists:estabelecimentos,id',
            'password' => 'nullable|min:8',
        ]);

        $usuario = User::findOrFail($id);

        $dados = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'estabelecimento_id' => $request->estabelecimento_id,
        ];

        // Senha só atualiza se o campo foi preenchido
        if ($request->filled('password')) {
            $dados['password'] = Hash::make($request->password);
        }

        $usuario->update($dados);

        return redirect()->route('usuarios.index')->with('success', 'Usuário atualizado com sucesso!');
    }

    public function destroy($id)
    {
        // Trava de segurança: O dono não pode excluir a si mesmo acidentalmente!
        if ($id == Auth::id()) {
            return redirect()->route('usuarios.index')->with('error', 'Operação bloqueada: Você não pode excluir o seu próprio usuário logado!');
        }

        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuário enviado para a lixeira!');
    }

    public function toggleAtivo($id)
    {
        if ($id == Auth::id()) {
            return redirect()->route('usuarios.index')->with('error', 'Você não pode desativar o seu próprio usuário!');
        }

        $usuario = User::findOrFail($id);
        $usuario->update(['ativo' => !$usuario->ativo]);

        $status = $usuario->ativo ? 'ativado' : 'desativado';
        return redirect()->route('usuarios.index')->with('success', "Usuário {$status} com sucesso!");
    }
}