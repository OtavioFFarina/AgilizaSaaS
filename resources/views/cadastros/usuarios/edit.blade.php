@extends('layouts.app_internal')

@section('content')

    <!-- Barra Minimalista de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 1200px;">
        <div class="d-flex align-items-center mb-4">
            <!-- O Único caminho para trás -->
            <a href="{{ route('usuarios.index') }}" class="btn-back">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Voltar aos Usuários
            </a>
        </div>
    </div>

    <div class="container-fluid px-4 px-md-5 pb-5" style="max-width: 1200px;">

        <div class="d-flex justify-content-between align-items-end mb-4">
            <h1 class="page-title"><i class='bx bx-edit text-primary me-2'></i> Editar Usuário</h1>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-12 border-0">
                <div class="form-card">
                    <form method="POST" action="{{ route('usuarios.update', $usuario->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ old('name', $usuario->name) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">E-mail (Para Login)</label>
                                <input type="email" class="form-control" name="email"
                                    value="{{ old('email', $usuario->email) }}" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Nova Senha <small class="text-muted">(deixe em branco para manter)</small></label>
                                <input type="password" class="form-control" name="password" placeholder="Mínimo 8 caracteres">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tipo de Acesso</label>
                                <select class="form-select" name="role" required>
                                    <option value="caixa"
                                        {{ old('role', $usuario->role) == 'caixa' ? 'selected' : '' }}>Vendedor (Acesso apenas ao PDV)</option>
                                    <option value="dono" {{ old('role', $usuario->role) == 'dono' ? 'selected' : '' }}>
                                        Administrador (Acesso Total)</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Loja / Filial</label>
                                <select class="form-select" name="estabelecimento_id" required>
                                    @foreach ($estabelecimentos as $est)
                                        <option value="{{ $est->id }}"
                                            {{ old('estabelecimento_id', $usuario->estabelecimento_id) == $est->id ? 'selected' : '' }}>
                                            {{ $est->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 mt-4 pt-2">
                                <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-2">
                                    <i class='bx bx-save fs-5'></i> Salvar Alterações
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 Setup -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Erro de Validação!',
                html: '{!! implode("<br>", $errors->all()) !!}'
            });
        @endif
    </script>
@endsection
