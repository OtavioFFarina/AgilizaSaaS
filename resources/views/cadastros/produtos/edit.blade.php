@extends('layouts.app_internal')

@section('content')

    <!-- Barra Minimalista de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 900px;">
        <div class="d-flex align-items-center mb-4">
            <!-- O Único caminho para trás -->
            <a href="{{ route('produtos.index') }}" class="btn-back">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Voltar para Produtos
            </a>
        </div>
    </div>

    <div class="container-fluid px-4 px-md-5 pb-5" style="max-width: 900px;">

        <div class="d-flex justify-content-between align-items-end mb-4">
            <h1 class="page-title"><i class='bx bx-edit text-primary me-2'></i> Editar Produto</h1>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ route('produtos.update', $produto->id) }}">
                @csrf
                @method('PUT')

                <h5 class="section-title">Informações do Produto</h5>

                <div class="row g-4">
                    <div class="col-md-6">
                        <label class="form-label">Produto</label>
                        <input type="text" class="form-control" name="nome" value="{{ old('nome', $produto->nome) }}"
                            required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Sabor / Variação</label>
                        <input type="text" class="form-control" name="sabor" value="{{ old('sabor', $produto->sabor) }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Categoria</label>
                        <select class="form-select" name="categoria_id" required>
                            @foreach ($categorias as $cat)
                                <option value="{{ $cat->id }}" {{ old('categoria_id', $produto->categoria_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fornecedor</label>
                        <select class="form-select" name="fornecedor_id" required>
                            @foreach ($fornecedores as $forn)
                                <option value="{{ $forn->id }}" {{ old('fornecedor_id', $produto->fornecedor_id) == $forn->id ? 'selected' : '' }}>
                                    {{ $forn->nome_fornecedor }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Preço de Venda (R$)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"
                                style="border-radius: 10px 0 0 10px;">R$</span>
                            <input type="text" class="form-control border-start-0 mask-moeda" name="preco_venda"
                                value="{{ old('preco_venda', number_format($produto->preco_venda, 2, ',', '.')) }}"
                                required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Preço de Compra (Custo R$)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0 text-muted"
                                style="border-radius: 10px 0 0 10px;">R$</span>
                            <input type="text" class="form-control border-start-0 mask-moeda" name="preco_compra"
                                value="{{ old('preco_compra', number_format($produto->preco_compra, 2, ',', '.')) }}"
                                required>
                        </div>
                    </div>
                </div>

                <hr class="border-secondary opacity-10 my-5">

                <div class="d-flex justify-content-end align-items-center gap-3">
                    <a href="{{ route('produtos.index') }}" class="btn btn-light px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-5">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Máscara de Moeda (R$)
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