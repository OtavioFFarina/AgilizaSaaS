@extends('layouts.app_internal')

@section('content')

    <!-- Barra Minimalista de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 900px;">
        <div class="d-flex align-items-center mb-4">
            <!-- O Único caminho para trás -->
            <a href="{{ route('estabelecimentos.index') }}" class="btn-back">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Voltar para Lojas
            </a>
        </div>
    </div>

    <div class="container-fluid px-4 px-md-5 pb-5" style="max-width: 900px;">

        <div class="d-flex justify-content-between align-items-end mb-4">
            <h1 class="page-title"><i class='bx bx-edit text-primary me-2'></i> Editar Estabelecimento</h1>
        </div>

        <div class="form-card">
            <form method="POST" action="{{ route('estabelecimentos.update', $estabelecimento->id) }}">
                @csrf
                @method('PUT')

                <h5 class="section-title">Informações da Loja</h5>

                <div class="row g-4 d-flex align-items-end mb-4">
                    <div class="col-md-8">
                        <label class="form-label">Nome da Loja / Filial</label>
                        <input type="text" class="form-control" name="nome"
                            value="{{ old('nome', $estabelecimento->nome) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">CEP</label>
                        <div class="input-group">
                            <input type="text" class="form-control fw-bold border-end-0" id="cep" name="cep"
                                value="{{ old('cep', $estabelecimento->cep) }}" placeholder="00000-000"
                                style="border-radius: 10px 0 0 10px;" required>
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
                        <input type="text" class="form-control" id="rua" name="rua"
                            value="{{ old('rua', $estabelecimento->rua) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairro" name="bairro"
                            value="{{ old('bairro', $estabelecimento->bairro) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidade" name="cidade"
                            value="{{ old('cidade', $estabelecimento->cidade) }}" required>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">UF</label>
                        <input type="text" class="form-control" id="estado" name="estado"
                            value="{{ old('estado', $estabelecimento->estado) }}" required>
                    </div>
                </div>

                <hr class="border-secondary opacity-10 my-5">

                <div class="d-flex justify-content-end align-items-center gap-3">
                    <a href="{{ route('estabelecimentos.index') }}" class="btn btn-light px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary px-5">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const cepInput = document.getElementById('cep');

        cepInput.addEventListener('input', (e) => {
            let v = e.target.value.replace(/\D/g, "");
            v = v.replace(/^(\d{5})(\d)/, "$1-$2");
            e.target.value = v.slice(0, 9);
        });

        cepInput.addEventListener('blur', () => {
            const cep = cepInput.value.replace(/\D/g, '');
            if (cep.length === 8) {
                Swal.fire({
                    title: 'Buscando CEP...',
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

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
                    }).catch(err => {
                        Swal.close();
                    });
            }
        });
    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Tudo Certo!',
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