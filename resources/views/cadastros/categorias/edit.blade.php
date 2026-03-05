@extends('layouts.app_internal')

@section('content')

    <!-- Barra Minimalista de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 900px;">
        <div class="d-flex align-items-center mb-4">
            <!-- O Único caminho para trás -->
            <a href="{{ route('categorias.index') }}" class="btn-back">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Voltar para Categorias
            </a>
        </div>
    </div>

    <div class="container-fluid px-4 px-md-5 pb-5" style="max-width: 900px;">

        <div class="d-flex justify-content-between align-items-end mb-4">
            <h1 class="page-title"><i class='bx bx-edit text-primary me-2'></i> Editar Categoria</h1>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ route('categorias.update', $categoria->id) }}">
                @csrf
                @method('PUT')

                <h5 class="section-title">Informações da Categoria</h5>

                <div class="row align-items-end g-3">
                    <div class="col-md-9 col-lg-10">
                        <label for="nome" class="form-label">Nome da Categoria</label>
                        <input type="text" class="form-control" id="nome" name="nome"
                            value="{{ old('nome', $categoria->nome) }}" required>
                    </div>
                    <div class="col-md-3 col-lg-2">
                        <button type="submit" class="btn btn-primary w-100 py-2" style="height: 48px;">
                            Salvar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Sucesso!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 1500
                });
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Erro de Validação!',
                    html: '{!! implode("<br>", $errors->all()) !!}'
                });
            });
        </script>
    @endif

@endsection