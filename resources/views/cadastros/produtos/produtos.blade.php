@extends('layouts.app_internal')

@section('content')

    <!-- Barra Minimalista de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 1200px;">
        <div class="d-flex align-items-center mb-4">
            <!-- O Único caminho para trás -->
            <a href="{{ route('dashboard') }}" class="btn-back">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Voltar ao Dashboard
            </a>
        </div>
    </div>

    <div class="container-fluid px-4 px-md-5 pb-5" style="max-width: 1200px;">

        <div class="d-flex justify-content-between align-items-end mb-4">
            <h1 class="page-title"><i class='bx bx-package text-primary me-2'></i> Gerenciar Produtos</h1>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="form-card">
                    <h5 class="section-title">Novo Produto</h5>

                    <form method="POST" action="{{ route('produtos.store') }}">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label for="nome" class="form-label">Nome do Produto</label>
                                <input type="text" class="form-control" name="nome" placeholder="Ex: Sorvete de Massa"
                                    required>
                            </div>

                            <div class="col-md-6">
                                <label for="sabor" class="form-label">Sabor / Variação</label>
                                <input type="text" class="form-control" name="sabor" placeholder="Ex: Chocolate Belga">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Categoria</label>
                                <select name="categoria_id" class="form-select" required>
                                    <option value="" selected disabled>Selecione a categoria...</option>
                                    @foreach ($categorias as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fornecedor</label>
                                <select name="fornecedor_id" class="form-select" required>
                                    <option value="" selected disabled>Selecione o fornecedor...</option>
                                    @foreach ($fornecedores as $forn)
                                        <option value="{{ $forn->id }}">{{ $forn->nome_fornecedor }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Preço de Venda (R$)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"
                                        style="border-radius: 10px 0 0 10px;">R$</span>
                                    <input type="text" class="form-control border-start-0 mask-moeda" name="preco_venda"
                                        placeholder="0,00" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Preço de Compra (Custo R$)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white border-end-0 text-muted"
                                        style="border-radius: 10px 0 0 10px;">R$</span>
                                    <input type="text" class="form-control border-start-0 mask-moeda" name="preco_compra"
                                        placeholder="0,00" required>
                                </div>
                            </div>

                            <div class="col-12 mt-4 pt-2">
                                <button type="submit"
                                    class="btn btn-primary btn-lg w-100 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2">
                                    <i class='bx bx-check-circle fs-5'></i> Cadastrar Produto
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabela de Produtos -->
        <div class="table-container p-0">
            <div class="d-flex justify-content-between align-items-center p-4 pb-3 border-bottom border-light">
                <h5 class="m-0 font-weight-600">Produtos Cadastrados</h5>
            </div>

            <div class="table-responsive">
                <table class="table-modern mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Produto</th>
                            <th>Sabor</th>
                            <th>Categoria</th>
                            <th>Fornecedor</th>
                            <th class="text-end">Custo</th>
                            <th class="text-end">Venda</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produtos as $produto)
                            <tr class="{{ !$produto->ativo ? 'opacity-50' : '' }}"
                                style="background-color: {{ !$produto->ativo ? 'var(--bg-body)' : 'transparent' }}">
                                <td class="text-muted fw-bold">#{{ $produto->id }}</td>
                                <td class="fw-bold">{{ $produto->nome }}</td>
                                <td>{{ $produto->sabor ?? '-' }}</td>
                                <td><span class="badge border text-dark bg-white">{{ $produto->categoria->nome ?? '-' }}</span>
                                </td>
                                <td class="text-muted small">{{ $produto->fornecedor->nome_fornecedor ?? 'Sem fornecedor' }}
                                </td>
                                <td class="text-end text-danger small">R$
                                    {{ number_format($produto->preco_compra, 2, ',', '.') }}</td>
                                <td class="text-end fw-bold text-success">R$
                                    {{ number_format($produto->preco_venda, 2, ',', '.') }}</td>
                                <td class="text-center">
                                    @if($produto->ativo)
                                        <span class="badge badge-soft-success">Ativo</span>
                                    @else
                                        <span class="badge badge-soft-danger">Desativado</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('produtos.edit', $produto->id) }}"
                                            class="btn btn-sm btn-light py-1 px-2 border-0 text-primary" title="Editar">
                                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('produtos.toggle', $produto->id) }}" method="POST"
                                            class="d-inline m-0 p-0">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="btn btn-sm btn-light py-1 px-2 border-0 {{ $produto->ativo ? 'text-success' : 'text-muted' }}"
                                                title="{{ $produto->ativo ? 'Desativar' : 'Ativar' }}">
                                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                            </button>
                                        </form>

                                        <button type="button" onclick="confirmarExclusao({{ $produto->id }})"
                                            class="btn btn-sm btn-light py-1 px-2 border-0 text-danger" title="Excluir">
                                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>

                                        <form id="form-delete-{{ $produto->id }}"
                                            action="{{ route('produtos.destroy', $produto->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center p-5 text-muted">
                                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        class="opacity-25 mb-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <p class="m-0">Nenhum produto cadastrado.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarExclusao(id) {
            Swal.fire({
                title: 'Tem certeza?',
                text: "Isso removerá o produto do sistema!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + id).submit();
                }
            })
        }

        // Máscara de Moeda (R$) — força formato brasileiro com vírgula
        document.querySelectorAll('.mask-moeda').forEach(function (input) {
            input.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value === '') { e.target.value = ''; return; }
                value = (parseInt(value) / 100).toFixed(2);
                value = value.replace('.', ',');
                value = value.replace(/(\d)(\d{3}),(\d{2})$/g, '$1.$2,$3');
                value = value.replace(/(\d)(\d{3})\.(\d{3}),/g, '$1.$2.$3,');
                e.target.value = value;
            });
        });
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({ icon: 'success', title: 'Sucesso!', text: "{{ session('success') }}", showConfirmButton: false, timer: 1500 });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({ icon: 'error', title: 'Erro!', text: "{{ session('error') }}" });
            });
        </script>
    @endif

@endsection