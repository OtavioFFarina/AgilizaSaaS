@extends('layouts.app_internal')

@section('content')

    <!-- Barra Minimalista de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 1200px;">
        <div class="d-flex align-items-center mb-4">
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
            <h1 class="page-title"><i class='bx bx-link text-primary me-2'></i> Vínculo de Estabelecimentos</h1>
        </div>

        <!-- Informação -->
        <div class="mb-4">
            <div class="alert alert-light border shadow-sm d-flex align-items-start">
                <i class='bx bx-info-circle text-primary fs-3 me-3 mt-1'></i>
                <div>
                    <span class="text-muted">Ao vincular dois estabelecimentos, as <strong
                            class="text-dark">categorias</strong>,
                        <strong class="text-dark">produtos</strong> e <strong class="text-dark">fornecedores</strong>
                        criados
                        serão automaticamente replicados entre as lojas vinculadas. O <strong
                            class="text-dark">estoque</strong>
                        continua sendo gerenciado individualmente por estabelecimento.</span>
                </div>
            </div>
        </div>

        <!-- Formulário de Novo Vínculo -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="form-card">
                    <h5 class="section-title mb-4">Criar Novo Vínculo</h5>

                    <form method="POST" action="{{ route('vinculos.store') }}">
                        @csrf
                        <div class="row g-3 align-items-end">
                            <div class="col-md-5">
                                <label class="form-label">Estabelecimento 1</label>
                                <select class="form-select" name="estabelecimento_origem_id" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    @foreach ($estabelecimentos as $est)
                                        <option value="{{ $est->id }}">{{ $est->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                <i class='bx bx-transfer-alt fs-2 text-primary'></i>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label">Estabelecimento 2</label>
                                <select class="form-select" name="estabelecimento_destino_id" required>
                                    <option value="" disabled selected>Selecione...</option>
                                    @foreach ($estabelecimentos as $est)
                                        <option value="{{ $est->id }}">{{ $est->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100" style="height: 48px;" title="Vincular">
                                    <i class='bx bx-link fs-5'></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Lista de Vínculos Existentes -->
        <div class="table-container p-0">
            <div class="d-flex justify-content-between align-items-center p-4 pb-3 border-bottom border-light">
                <h5 class="m-0 fw-bold">Vínculos Ativos</h5>
                <span class="badge badge-soft-primary">{{ $vinculos->count() }} vínculo(s)</span>
            </div>

            <div class="table-responsive">
                <table class="table-modern mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Estabelecimento 1</th>
                            <th class="text-center">Vínculo</th>
                            <th>Estabelecimento 2</th>
                            <th class="text-center">Criado em</th>
                            <th class="text-end pe-4">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vinculos as $vinculo)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">
                                    <i class='bx bx-store me-2 text-primary'></i>
                                    {{ $vinculo->origem->nome ?? 'N/A' }}
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-soft-success px-3 py-2">
                                        <i class='bx bx-transfer-alt me-1'></i> Vinculados
                                    </span>
                                </td>
                                <td class="fw-bold text-dark">
                                    <i class='bx bx-store me-2 text-primary'></i>
                                    {{ $vinculo->destino->nome ?? 'N/A' }}
                                </td>
                                <td class="text-center text-muted small">
                                    {{ $vinculo->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-end pe-4">
                                    <form method="POST" action="{{ route('vinculos.destroy', $vinculo->id) }}"
                                        class="d-inline vinculo-delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger border-0"
                                            title="Remover Vínculo">
                                            <i class='bx bx-trash fs-5'></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center p-5 text-muted">
                                    <i class='bx bx-link-external fs-1 opacity-25 d-block mb-3'></i>
                                    <p class="m-0">Nenhum vínculo criado ainda.</p>
                                    <small>Vincule dois estabelecimentos acima para compartilhar cadastros.</small>
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
        // Confirmação de exclusão
        document.querySelectorAll('.vinculo-delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Remover Vínculo?',
                    text: 'Os cadastros já criados não serão removidos, mas novos cadastros não serão mais replicados.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sim, Remover',
                    cancelButtonText: 'Cancelar',
                    heightAuto: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Ops!',
                text: "{{ session('error') }}",
                showConfirmButton: true
            });
        @endif
    </script>
@endsection