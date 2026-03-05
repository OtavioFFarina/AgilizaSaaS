<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Fornecedor;
use App\Models\Estabelecimento;
use App\Models\User;

class LixeiraController extends Controller
{
    /**
     * Mapeamento dos tipos permitidos para seus respectivos Models.
     */
    private function getModelMap(): array
    {
        return [
            'produtos' => Produto::class,
            'categorias' => Categoria::class,
            'fornecedores' => Fornecedor::class,
            'estabelecimentos' => Estabelecimento::class,
            'usuarios' => User::class,
        ];
    }

    /**
     * Retorna o nome de exibição do item na lixeira.
     */
    private function getNomeItem($item, string $tipo): string
    {
        return match ($tipo) {
            'fornecedores' => $item->nome_fornecedor,
            'usuarios' => $item->name,
            default => $item->nome,
        };
    }

    /**
     * Exibe a lixeira centralizada com abas por tipo.
     */
    public function index()
    {
        // Proteção de Administrador
        if (Auth::user()->role !== 'admin_master' && Auth::user()->role !== 'dono') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado.');
        }

        $estabelecimentoId = Auth::user()->estabelecimento_id;

        // Buscar todos os soft-deleted filtrados pelo estabelecimento_id
        $produtos = Produto::onlyTrashed()
            ->where('estabelecimento_id', $estabelecimentoId)
            ->orderBy('deleted_at', 'desc')
            ->get();

        $categorias = Categoria::onlyTrashed()
            ->where('estabelecimento_id', $estabelecimentoId)
            ->orderBy('deleted_at', 'desc')
            ->get();

        $fornecedores = Fornecedor::onlyTrashed()
            ->where('estabelecimento_id', $estabelecimentoId)
            ->orderBy('deleted_at', 'desc')
            ->get();

        $estabelecimentos = Estabelecimento::onlyTrashed()
            ->orderBy('deleted_at', 'desc')
            ->get();

        $usuarios = User::onlyTrashed()
            ->where('estabelecimento_id', $estabelecimentoId)
            ->orderBy('deleted_at', 'desc')
            ->get();

        return view('cadastros.lixeira.index', compact(
            'produtos',
            'categorias',
            'fornecedores',
            'estabelecimentos',
            'usuarios'
        ));
    }

    /**
     * Restaura um item da lixeira.
     */
    public function restaurar(string $tipo, $id)
    {
        $map = $this->getModelMap();

        if (!isset($map[$tipo])) {
            return redirect()->route('lixeira.index')->with('error', 'Tipo inválido.');
        }

        $model = $map[$tipo];
        $item = $model::onlyTrashed()->findOrFail($id);

        // Trava de segurança multi-tenant (exceto estabelecimentos que não tem estabelecimento_id)
        if ($tipo !== 'estabelecimentos') {
            $estabelecimentoId = Auth::user()->estabelecimento_id;
            if ($item->estabelecimento_id !== $estabelecimentoId) {
                return redirect()->route('lixeira.index')->with('error', 'Acesso negado a este registro.');
            }
        }

        $item->restore();

        return redirect()->route('lixeira.index')->with('success', 'Item restaurado com sucesso!');
    }

    /**
     * Exclui permanentemente um item da lixeira.
     * Limpa registros dependentes (estoque, vendas) antes de excluir.
     */
    public function forceDelete(string $tipo, $id)
    {
        $map = $this->getModelMap();

        if (!isset($map[$tipo])) {
            return redirect()->route('lixeira.index')->with('error', 'Tipo inválido.');
        }

        $model = $map[$tipo];
        $item = $model::onlyTrashed()->findOrFail($id);

        // Trava de segurança multi-tenant
        if ($tipo !== 'estabelecimentos') {
            $estabelecimentoId = Auth::user()->estabelecimento_id;
            if ($item->estabelecimento_id !== $estabelecimentoId) {
                return redirect()->route('lixeira.index')->with('error', 'Acesso negado a este registro.');
            }
        }

        try {
            DB::transaction(function () use ($item, $tipo) {
                if ($tipo === 'produtos') {
                    // Remove movimentações de estoque do produto
                    DB::table('estoque_movimentacoes')->where('produto_id', $item->id)->delete();
                    // Nullifica referência em itens de venda (preserva histórico de vendas)
                    DB::table('venda_itens')->where('produto_id', $item->id)->update(['produto_id' => null]);
                }

                if ($tipo === 'categorias') {
                    // Nullifica a categoria nos produtos (inclusive soft-deleted)
                    DB::table('produtos')->where('categoria_id', $item->id)->update(['categoria_id' => null]);
                }

                if ($tipo === 'fornecedores') {
                    // Nullifica o fornecedor nos produtos (inclusive soft-deleted)
                    if (\Schema::hasColumn('produtos', 'fornecedor_id')) {
                        DB::table('produtos')->where('fornecedor_id', $item->id)->update(['fornecedor_id' => null]);
                    }
                }

                $item->forceDelete();
            });

            return redirect()->route('lixeira.index')->with('success', 'Item excluído permanentemente!');
        } catch (\Exception $e) {
            return redirect()->route('lixeira.index')->with('error', 'Erro ao excluir permanentemente: ' . $e->getMessage());
        }
    }
}
