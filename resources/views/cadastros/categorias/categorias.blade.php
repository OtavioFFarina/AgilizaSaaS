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
            <h1 class="page-title"><i class='bx bx-category text-primary me-2'></i> Gerenciar Categorias</h1>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 border-0">
                <div class="form-card">
                    <h5 class="section-title">Nova Categoria</h5>

                    <form method="post" action="{{ route('categorias.store') }}">
                        @csrf
                        <div class="row align-items-end g-3">
                            <div class="col-md-9 col-lg-10">
                                <label for="nome" class="form-label">Nome da Categoria</label>
                                <input type="text" class="form-control" id="nome" name="nome"
                                    placeholder="Ex: Picolés Gourmet" required>
                            </div>
                            <div class="col-md-3 col-lg-2">
                                <button type="submit" class="btn btn-primary w-60 py-2" style="height: 48px;">
                                    Salvar <i class="bx bx-save"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabela -->
        <div class="table-container p-0">
            <div class="d-flex justify-content-between align-items-center p-4 pb-3 border-bottom border-light">
                <h5 class="m-0 font-weight-600">Categorias Cadastradas</h5>
            </div>

            <div class="table-responsive">
                <table class="table-modern mb-0">
                    <thead>
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Nome</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4" style="width: 180px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categorias as $cat)
                            <tr class="{{ !$cat->ativo ? 'opacity-50' : '' }}"
                                style="background-color: {{ !$cat->ativo ? 'var(--bg-body)' : 'transparent' }}">
                                <td class="text-muted fw-bold">#{{ $cat->id }}</td>
                                <td class="fw-bold">{{ $cat->nome }}</td>
                                <td class="text-center">
                                    @if($cat->ativo)
                                        <span class="badge badge-soft-success">Ativo</span>
                                    @else
                                        <span class="badge badge-soft-danger">Desativado</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('categorias.edit', $cat->id) }}"
                                            class="btn btn-sm btn-light py-1 px-2 border-0 text-primary" title="Editar">
                                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('categorias.toggle', $cat->id) }}" method="POST"
                                            class="d-inline m-0 p-0">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="btn btn-sm btn-light py-1 px-2 border-0 {{ $cat->ativo ? 'text-success' : 'text-muted' }}"
                                                title="{{ $cat->ativo ? 'Desativar' : 'Ativar' }}">
                                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                            </button>
                                        </form>

                                        <button type="button" onclick="confirmarExclusao({{ $cat->id }})"
                                            class="btn btn-sm btn-light py-1 px-2 border-0 text-danger" title="Excluir">
                                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>

                                        <form id="form-delete-{{ $cat->id }}"
                                            action="{{ route('categorias.destroy', $cat->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center p-5 text-muted">
                                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        class="opacity-25 mb-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <p class="m-0">Nenhuma categoria cadastrada.</p>
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
                text: "Você não poderá reverter isso!",
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
            });
        }
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
                Swal.fire({ icon: 'error', title: 'Oops!', text: "{{ session('error') }}" });
            });
        </script>
    @endif

@endsection