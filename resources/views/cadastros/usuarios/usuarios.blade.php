@extends('layouts.app_internal')

@section('content')
    <div class="container-fluid px-4 px-md-5 pt-4 pb-5" style="max-width: 1200px;">

        <!-- Barra Minimalista de Voltar -->
        <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 1200px;">
            <div class="d-flex align-items-center mb-4">
                <!-- O Único caminho para trás -->
                <a href="{{ route('dashboard') }}" class="btn-back">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18">
                        </path>
                    </svg>
                    Voltar ao Dashboard
                </a>
            </div>
        </div>

        <div class="container-fluid px-4 px-md-5 pb-5" style="max-width: 1200px;">

            <div class="d-flex justify-content-between align-items-end mb-4">
                <h1 class="page-title"><i class='bx bx-user-circle text-primary me-2'></i> Gerenciar Equipe</h1>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12 border-0">
                    <div class="form-card">
                        <h5 class="section-title">Novo Funcionário</h5>
                        <form method="POST" action="{{ route('usuarios.store') }}">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-4">
                                    <label class="form-label">Nome Completo</label>
                                    <input type="text" class="form-control" name="name" placeholder="Ex: João da Silva"
                                        required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">E-mail (Para Login)</label>
                                    <input type="email" class="form-control" name="email" placeholder="joao@agiliza.com"
                                        required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Senha Inicial</label>
                                    <input type="password" class="form-control" name="password"
                                        placeholder="Mínimo 8 caracteres" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Tipo de Acesso</label>
                                    <select class="form-select" name="role" required>
                                        <option value="" disabled selected>Selecione...</option>
                                        <option value="caixa">Vendedor (Acesso apenas ao PDV)</option>
                                        <option value="dono">Administrador (Acesso Total)</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Loja / Filial</label>
                                    <select class="form-select" name="estabelecimento_id" required>
                                        <option value="" disabled selected>Selecione a loja onde ele trabalha...</option>
                                        @foreach ($estabelecimentos as $est)
                                            <option value="{{ $est->id }}">{{ $est->nome }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12 mt-4 pt-2">
                                    <button type="submit"
                                        class="btn btn-primary btn-lg w-100 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2">
                                        <i class='bx bx-user-plus fs-5'></i> Cadastrar Usuário
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="table-container p-0">
                <div class="d-flex justify-content-between align-items-center p-4 pb-3 border-bottom border-light">
                    <h5 class="m-0 font-weight-600">Equipe Cadastrada</h5>
                </div>
                <div class="table-responsive">
                    <table class="table-modern mb-0">
                        <thead>
                            <tr>
                                <th>Usuário</th>
                                <th>E-mail</th>
                                <th>Loja Vinculada</th>
                                <th>Permissão</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" style="width: 150px;">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr class="{{ !$usuario->ativo ? 'opacity-50 bg-light' : '' }}">
                                    <td class="fw-bold text-dark align-middle">
                                        <i class='bx bx-user text-primary me-2 fs-5' style="transform: translateY(2px);"></i>
                                        {{ $usuario->name }}
                                        @if ($usuario->id == Auth::id())
                                            <span class="badge badge-soft-success ms-2">Você</span>
                                        @endif
                                    </td>
                                    <td class="text-muted align-middle">{{ $usuario->email }}</td>
                                    <td class="text-muted align-middle">{{ $usuario->estabelecimento->nome ?? 'Sem Loja' }}</td>
                                    <td class="align-middle">
                                        @if ($usuario->role == 'dono' || $usuario->role == 'admin_master')
                                            <span class="badge badge-soft-primary px-3 py-2">Administrador</span>
                                        @else
                                            <span class="badge badge-soft-secondary px-3 py-2">Vendedor</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        @if($usuario->ativo)
                                            <span class="badge bg-success shadow-sm px-3 py-2">Ativo</span>
                                        @else
                                            <span class="badge bg-danger shadow-sm px-3 py-2">Desativado</span>
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ route('usuarios.edit', $usuario->id) }}"
                                                class="btn btn-sm btn-light text-primary border-0 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                style="width: 32px; height: 32px;" title="Editar">
                                                <i class='bx bx-edit-alt fs-5'></i>
                                            </a>

                                            @if ($usuario->id != Auth::id())
                                                <form action="{{ route('usuarios.toggle', $usuario->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-light border-0 rounded-circle d-flex align-items-center justify-content-center shadow-sm {{ $usuario->ativo ? 'text-success' : 'text-secondary' }}"
                                                        style="width: 32px; height: 32px;"
                                                        title="{{ $usuario->ativo ? 'Desativar' : 'Ativar' }}">
                                                        <i class='bx bx-power-off fs-5'></i>
                                                    </button>
                                                </form>

                                                <button type="button" onclick="confirmarExclusao({{ $usuario->id }})"
                                                    class="btn btn-sm btn-light text-danger border-0 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                    style="width: 32px; height: 32px;">
                                                    <i class='bx bx-trash fs-5'></i>
                                                </button>

                                                <form id="form-delete-{{ $usuario->id }}"
                                                    action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST"
                                                    style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SweetAlert2 Setup -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            function confirmarExclusao(id) {
                Swal.fire({
                    title: 'Demitir Usuário?',
                    text: "Ele perderá o acesso ao sistema imediatamente.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sim, remover acesso!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) document.getElementById('form-delete-' + id).submit();
                });
            }

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500,
                    background: 'var(--bg-card)',
                    color: 'var(--text-main)'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Atenção!',
                    text: "{{ session('error') }}"
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Erro de Cadastro!',
                    html: '{!! implode("<br>", $errors->all()) !!}'
                });
            @endif
        </script>
@endsection