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
            <h1 class="page-title"><i class='bx bx-store-alt text-primary me-2'></i> Gerenciar Lojas e Filiais</h1>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 border-0">
                <div class="form-card">
                    <h5 class="section-title">Novo Estabelecimento</h5>

                    <form method="POST" action="{{ route('estabelecimentos.store') }}">
                        @csrf
                        <div class="row g-4">
                            <div class="col-md-8">
                                <label class="form-label">Nome da Loja / Filial</label>
                                <input type="text" class="form-control" name="nome_estabelecimento"
                                    placeholder="Ex: Loja Matriz Centro" required>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">CEP</label>
                                <div class="input-group">
                                    <input type="text" class="form-control fw-bold border-end-0" id="cep" name="cep"
                                        placeholder="00000-000" style="border-radius: 10px 0 0 10px;" required>
                                    <button class="btn btn-outline-secondary bg-white text-muted" type="button"
                                        title="Busca automática ao digitar"
                                        style="border-radius: 0 10px 10px 0; border: 1px solid var(--border-color); border-left: none;">
                                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label">Rua / Logradouro</label>
                                <input type="text" class="form-control bg-light" id="rua" name="rua" required readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Bairro</label>
                                <input type="text" class="form-control bg-light" id="bairro" name="bairro" required
                                    readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Cidade</label>
                                <input type="text" class="form-control bg-light" id="cidade" name="cidade" required
                                    readonly>
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">UF</label>
                                <input type="text" class="form-control bg-light" id="estado" name="estado" required
                                    readonly>
                            </div>

                            <div class="col-12 mt-4 pt-2">
                                <button type="submit"
                                    class="btn btn-primary btn-lg w-100 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2">
                                    <i class='bx bx-check-circle fs-5'></i> Salvar Loja
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
                <h5 class="m-0 font-weight-600">Lojas Cadastradas</h5>
            </div>

            <div class="table-responsive">
                <table class="table-modern mb-0">
                    <thead>
                        <tr>
                            <th>Loja</th>
                            <th>Endereço Completo</th>
                            <th>Localidade</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($estabelecimentos as $loja)
                            <tr class="{{ !$loja->ativo ? 'opacity-50' : '' }}"
                                style="background-color: {{ !$loja->ativo ? 'var(--bg-body)' : 'transparent' }}">
                                <td class="fw-bold">
                                    <div class="d-flex align-items-center gap-2">
                                        <span
                                            class="d-inline-flex align-items-center justify-content-center bg-primary rounded-circle text-white"
                                            style="width: 32px; height: 32px;">
                                            <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1v1H9V7zm5 0h1v1h-1V7zm-5 4h1v1H9v-1zm5 0h1v1h-1v-1zm-3 4H2v-1h5v1z">
                                                </path>
                                            </svg>
                                        </span>
                                        {{ $loja->nome }}
                                    </div>
                                </td>
                                <td>
                                    <div class="text-muted small mb-1">{{ $loja->rua ?? 'Rua não informada' }},
                                        {{ $loja->bairro ?? '' }}</div>
                                    <span class="badge border text-dark bg-white">CEP: {{ $loja->cep ?? '00000-000' }}</span>
                                </td>
                                <td>
                                    <span class="fw-semibold text-secondary">{{ $loja->cidade ?? 'Cidade' }} -
                                        {{ $loja->estado ?? 'UF' }}</span>
                                </td>
                                <td class="text-center">
                                    @if($loja->ativo)
                                        <span class="badge badge-soft-success">Ativo</span>
                                    @else
                                        <span class="badge badge-soft-danger">Desativado</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('estabelecimentos.edit', $loja->id) }}"
                                            class="btn btn-sm btn-light py-1 px-2 border-0 text-primary" title="Editar">
                                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                </path>
                                            </svg>
                                        </a>

                                        <form action="{{ route('estabelecimentos.toggle', $loja->id) }}" method="POST"
                                            class="d-inline m-0 p-0">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="btn btn-sm btn-light py-1 px-2 border-0 {{ $loja->ativo ? 'text-success' : 'text-muted' }}"
                                                title="{{ $loja->ativo ? 'Desativar' : 'Ativar' }}">
                                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                            </button>
                                        </form>

                                        <button type="button" onclick="confirmarExclusao({{ $loja->id }})"
                                            class="btn btn-sm btn-light py-1 px-2 border-0 text-danger" title="Excluir">
                                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>

                                        <form id="form-delete-{{ $loja->id }}"
                                            action="{{ route('estabelecimentos.destroy', $loja->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-5 text-muted">
                                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        class="opacity-25 mb-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <p class="m-0">Nenhuma loja cadastrada.</p>
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
                text: "Essa ação pode impactar usuários logados nessa filial.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) document.getElementById('form-delete-' + id).submit();
            });
        }

        const cepInput = document.getElementById('cep');

        cepInput.addEventListener('input', (e) => {
            let v = e.target.value.replace(/\D/g, "");
            v = v.replace(/^(\d{5})(\d)/, "$1-$2");
            e.target.value = v.slice(0, 9);
        });

        cepInput.addEventListener('blur', () => {
            const cep = cepInput.value.replace(/\D/g, '');
            if (cep.length === 8) {
                Swal.fire({ title: 'Buscando CEP...', timerProgressBar: true, didOpen: () => { Swal.showLoading(); } });

                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(res => res.json())
                    .then(data => {
                        Swal.close();
                        if (!data.erro) {
                            document.getElementById('rua').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('estado').value = data.uf;
                        } else {
                            Swal.fire('CEP Inválido', 'Endereço não encontrado para este CEP.', 'error');
                        }
                    }).catch(err => { Swal.close(); });
            }
        });
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({ icon: 'success', title: 'Tudo Certo!', text: "{{ session('success') }}", showConfirmButton: false, timer: 1500 });
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