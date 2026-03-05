@extends('layouts.app_internal')

@section('content')

    <!-- Barra Minimalista de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 900px;">
        <div class="d-flex align-items-center mb-4">
            <!-- O Único caminho para trás -->
            <a href="{{ route('fornecedores.index') }}" class="btn-back">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Voltar para Fornecedores
            </a>
        </div>
    </div>

    <div class="container-fluid px-4 px-md-5 pb-5" style="max-width: 900px;">

        <div class="d-flex justify-content-between align-items-end mb-4">
            <h1 class="page-title"><i class='bx bx-edit text-primary me-2'></i> Editar Fornecedor</h1>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ route('fornecedores.update', $fornecedor->id) }}">
                @csrf
                @method('PUT')

                <h5 class="section-title">Informações do Fornecedor</h5>

                <div class="row g-4 mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Nome da Empresa</label>
                        <input type="text" class="form-control" name="nome_fornecedor"
                            value="{{ old('nome_fornecedor', $fornecedor->nome_fornecedor) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">CNPJ</label>
                        <input type="text" class="form-control" id="cnpj" name="cnpj"
                            value="{{ old('cnpj', $fornecedor->cnpj) }}" placeholder="00.000.000/0000-00">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telefone</label>
                        <input type="tel" class="form-control" id="telefone" name="telefone"
                            value="{{ old('telefone', $fornecedor->telefone) }}" placeholder="(00) 00000-0000">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">E-mail</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $fornecedor->email) }}"
                            placeholder="contato@empresa.com">
                    </div>
                    <div class="col-12">
                        <label class="form-label">Endereço</label>
                        <input type="text" class="form-control" name="endereco"
                            value="{{ old('endereco', $fornecedor->endereco) }}">
                    </div>
                </div>

                <hr class="border-secondary opacity-10 my-5">

                <div class="d-flex justify-content-end align-items-center gap-3">
                    <a href="{{ route('fornecedores.index') }}" class="btn btn-light px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-5">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Máscaras
        document.getElementById('cnpj').addEventListener('input', function (e) {
            let v = e.target.value.replace(/\D/g, "");
            v = v.replace(/^(\d{2})(\d)/, "$1.$2");
            v = v.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
            v = v.replace(/\.(\d{3})(\d)/, ".$1/$2");
            v = v.replace(/(\d{4})(\d)/, "$1-$2");
            e.target.value = v.slice(0, 18);
        });

        document.getElementById('telefone').addEventListener('input', function (e) {
            let v = e.target.value.replace(/\D/g, "");
            v = v.replace(/^(\d{2})(\d)/g, "($1) $2");
            v = v.replace(/(\d{5})(\d)/, "$1-$2");
            e.target.value = v.slice(0, 15);
        });
    </script>

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