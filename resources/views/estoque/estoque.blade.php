@extends('layouts.app_internal')

@section('content')

    <!-- Barra Minimalista de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 1400px;">
        <div class="d-flex align-items-center justify-content-between mb-4">
            @if ($tipo_usuario === 'admin_master' || $tipo_usuario === 'dono')
                <a href="{{ route('dashboard') }}" class="btn-back">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                        </path>
                    </svg>
                    Voltar ao Dashboard
                </a>
            @else
                <a href="{{ route('vendas.index') }}" class="btn-back">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                        </path>
                    </svg>
                    Voltar ao PDV
                </a>
            @endif
        </div>
    </div>

    <div class="container-fluid px-4 px-md-5 pb-5" style="max-width: 1400px;">

        <div class="d-flex justify-content-between align-items-end mb-4">
            <h1 class="page-title"><i class='bx bx-package text-primary me-2'></i> Controle de Estoque</h1>
        </div>

        {{-- Seletor de Estabelecimento (Apenas para Admin/Dono com vínculos) --}}
        @if (($tipo_usuario === 'admin_master' || $tipo_usuario === 'dono') && $estabelecimentosDisponiveis->count() > 1)
            <div class="mb-4">
                <div class="form-card border-0 shadow-sm" style="padding: 1.5rem 2rem;">
                    <h6 class="section-title mb-3"><i class='bx bx-store me-2'></i>Selecione o Estabelecimento</h6>
                    <ul class="nav nav-pills d-flex gap-2 flex-nowrap overflow-auto" style="padding-bottom: 5px;">
                        @foreach ($estabelecimentosDisponiveis as $est)
                            <li class="nav-item flex-sm-grow-1 text-center">
                                <a href="{{ route('estoque.index', ['estabelecimento_id' => $est->id]) }}"
                                    class="nav-link w-100 py-3 fw-bold border shadow-sm {{ $estabelecimentoSelecionado == $est->id ? 'active' : '' }}"
                                    style="{{ $estabelecimentoSelecionado != $est->id ? 'color: var(--text-muted); background: white;' : '' }}">
                                    <i class='bx bx-store fs-5 me-1' style="transform: translateY(2px);"></i>
                                    {{ $est->nome }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @if ($tipo_usuario === 'admin_master' || $tipo_usuario === 'dono')
            <div class="row g-4 mb-4">
                <div class="col-12 border-0">
                    <div class="form-card">
                        <h5 class="section-title mb-4">Nova Entrada de Mercadoria</h5>

                        <form method="POST" action="{{ route('estoque.store') }}" class="row g-3 align-items-end">
                            @csrf
                            <input type="hidden" name="estabelecimento_id" value="{{ $estabelecimentoSelecionado }}">

                            <div class="col-md-4">
                                <label class="form-label">Categoria</label>
                                <select id="select_categoria" class="form-select" required>
                                    <option value="" selected disabled>Selecione a Categoria</option>
                                    @foreach ($categorias as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-5">
                                <label class="form-label">Sabor / Produto Específico</label>
                                <select name="produto_id" id="select_produto" class="form-select" required disabled>
                                    <option value="">Aguardando categoria selecionada...</option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <label class="form-label">Quantidade</label>
                                <input type="number" name="quantidade" class="form-control text-center fw-bold" placeholder="0"
                                    min="1" required />
                            </div>

                            <div class="col-md-1">
                                <button type="submit" class="btn btn-primary w-100" style="height: 48px;"
                                    title="Registrar Entrada">
                                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tabela de Saldo -->
        <div class="table-container p-0">
            <div class="d-flex justify-content-between align-items-center p-4 pb-3 border-bottom border-light">
                <h5 class="m-0 font-weight-600">Saldo Atual em Estoque</h5>
            </div>

            <div class="table-responsive">
                <table class="table-modern mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4">Produto</th>
                            <th>Sabor</th>
                            <th>Categoria</th>
                            <th class="text-center">Qtd. Atual</th>
                            <th class="text-end pe-4">Última Movimentação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produtos as $linha)
                            <tr>
                                <td class="ps-4 fw-bold text-dark">{{ $linha->nome }}</td>
                                <td class="text-muted">{{ $linha->sabor ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-light border text-dark rounded-pill px-3 py-1 fw-medium">
                                        {{ $linha->categoria->nome ?? 'Geral' }}
                                    </span>
                                </td>

                                <td class="text-center">
                                    @php
                                        $qtd = $linha->estoque_atual;
                                        $classe = 'badge-soft-success';
                                        if ($qtd <= 5) {
                                            $classe = 'badge-soft-danger';
                                        } elseif ($qtd <= 15) {
                                            $classe = 'badge-soft-warning';
                                        }
                                        if ($classe == 'badge-soft-warning') {
                                            $style = 'background-color: #fef3c7; color: #d97706; border: 1px solid #fde68a;';
                                            $classe = '';
                                        } else {
                                            $style = '';
                                        }
                                    @endphp
                                    <span class="badge {{ $classe }} px-3 py-2 fs-6 rounded-pill" style="{{ $style }}">
                                        {{ $qtd }} un
                                    </span>
                                </td>

                                <td class="text-end pe-4 small text-muted">
                                    @if ($linha->ultima_data)
                                        <span
                                            class="d-block fw-medium">{{ \Carbon\Carbon::parse($linha->ultima_data)->format('d/m/Y') }}</span>
                                        <span class="d-block">{{ \Carbon\Carbon::parse($linha->ultima_data)->format('H:i') }}</span>
                                    @else
                                        <span class="text-muted opacity-50">-</span>
                                    @endif
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
                                    <p class="m-0">Nenhum item com saldo em estoque no momento.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if ($tipo_usuario === 'admin_master' || $tipo_usuario === 'dono')
        <script>
            document.getElementById('select_categoria').addEventListener('change', function () {
                const categoriaId = this.value;
                const selectProduto = document.getElementById('select_produto');
                const estabelecimentoId = '{{ $estabelecimentoSelecionado }}';

                selectProduto.innerHTML = '<option>Carregando...</option>';
                selectProduto.disabled = true;

                fetch(`/estoque/sabores/${categoriaId}?estabelecimento_id=${estabelecimentoId}`)
                    .then(res => res.json())
                    .then(data => {
                        selectProduto.innerHTML = '';
                        selectProduto.disabled = false;

                        if (data.length > 0) {
                            selectProduto.innerHTML =
                                '<option value="" selected disabled>Selecione o produto...</option>';
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.id;
                                opt.textContent = `${item.nome} - ${item.sabor || 'Sem sabor'}`;
                                selectProduto.appendChild(opt);
                            });
                        } else {
                            selectProduto.innerHTML =
                                '<option value="" disabled>Nenhum produto nesta categoria</option>';
                        }
                    })
                    .catch(() => {
                        selectProduto.innerHTML = '<option value="">Erro ao carregar</option>';
                        selectProduto.disabled = false;
                    });
            });
        </script>
    @endif

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Tudo Certo!',
                    text: "{{ session('success') }}",
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Ops!',
                    text: "{{ session('error') }}",
                    showConfirmButton: true
                });
            });
        </script>
    @endif

@endsection