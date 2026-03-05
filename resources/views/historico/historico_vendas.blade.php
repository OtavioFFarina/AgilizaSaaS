@extends('layouts.app_internal')

@section('content')

    <!-- Barra Minimalista de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 1400px;">
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

    <div class="container-fluid px-4 px-md-5 pb-5" style="max-width: 1400px;">

        <div class="d-flex justify-content-between align-items-end mb-4">
            <h1 class="page-title"><i class='bx bx-list-check text-primary me-2'></i> Relatório de Vendas Realizadas</h1>
        </div>

        <!-- Filtros -->
        <div class="row g-4 mb-4">
            <div class="col-12 border-0">
                <div class="form-card">
                    <h5 class="section-title mb-4">Filtros de Busca</h5>

                    <form method="GET" action="{{ route('historico.vendas') }}" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Data Inicial</label>
                            <input type="date" name="data_inicio" class="form-control" value="{{ $data_inicio }}" />
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Data Final</label>
                            <input type="date" name="data_fim" class="form-control" value="{{ $data_fim }}" />
                        </div>
                        <div class="col-md-4 d-flex gap-2">
                            <a href="{{ route('historico.vendas') }}" class="btn btn-light py-2 px-3" title="Limpar Filtros"
                                style="height: 48px;">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </a>
                            <button type="submit" class="btn btn-primary flex-grow-1 fw-medium" style="height: 48px;">
                                Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabela -->
        <div class="table-container p-0">
            <div class="d-flex justify-content-between align-items-center p-4 pb-3 border-bottom border-light">
                <h5 class="m-0 font-weight-600">Resultados</h5>
            </div>

            <div class="table-responsive">
                <table class="table-modern mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">ID Trans.</th>
                            <th>Data / Hora</th>
                            <th>Pagamento</th>
                            <th>Total</th>
                            <th class="text-center">Status</th>
                            <th class="text-end pe-4" style="width: 180px;">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vendas as $v)
                            <tr class="{{ $v->status == 'cancelada' ? 'opacity-50' : '' }}"
                                style="background-color: {{ $v->status == 'cancelada' ? 'var(--bg-body)' : 'transparent' }}">
                                <td class="ps-4 text-muted fw-bold">#{{ str_pad($v->id, 5, '0', STR_PAD_LEFT) }}</td>
                                <td class="text-muted small">
                                    <span class="d-block text-dark fw-medium mb-1">{{ $v->created_at->format('d/m/Y') }}</span>
                                    <span class="d-block">{{ $v->created_at->format('H:i') }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border">
                                        {{ strtoupper($v->forma_pagamento ?? 'OUTROS') }}
                                    </span>
                                </td>
                                <td class="fw-bold text-success">
                                    <span
                                        class="{{ $v->status == 'cancelada' ? 'text-decoration-line-through text-muted' : '' }}">
                                        R$ {{ number_format($v->valor_total, 2, ',', '.') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if ($v->status == 'finalizada')
                                        <span class="badge badge-soft-success">Concluída</span>
                                    @elseif ($v->status == 'cancelada')
                                        <span class="badge badge-soft-danger">Cancelada</span>
                                    @else
                                        <span class="badge badge-soft-secondary">{{ ucfirst($v->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        <button class="btn btn-sm btn-light text-primary border-0 p-2" data-bs-toggle="modal"
                                            data-bs-target="#modalItens{{ $v->id }}" title="Ver Itens">
                                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </button>

                                        <button class="btn btn-sm btn-light text-dark border-0 p-2"
                                            onclick="imprimirCupom({{ $v->id }})" title="Imprimir Cupom">
                                            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                                </path>
                                            </svg>
                                        </button>

                                        @if ($v->status == 'finalizada')
                                            <button class="btn btn-sm btn-light border-0 p-2 text-danger"
                                                onclick="cancelarVenda({{ $v->id }})" title="Estornar Venda">
                                                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-5 text-muted">
                                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        class="opacity-25 mb-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <p class="m-0">Nenhuma venda encontrada neste período.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modais (Mesma Lógica) -->
    @foreach ($vendas as $v)
        <div class="modal fade" id="modalItens{{ $v->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-lg);">
                    <div class="modal-header border-bottom-0 bg-light p-4">
                        <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                            <span
                                class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle"
                                style="width: 40px; height: 40px;">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                            </span>
                            Itens da Venda #{{ str_pad($v->id, 5, '0', STR_PAD_LEFT) }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="table-responsive m-0">
                            <table class="table table-modern m-0">
                                <thead class="bg-light border-bottom">
                                    <tr>
                                        <th class="ps-4">Produto</th>
                                        <th>Sabor</th>
                                        <th class="text-center">Qtd</th>
                                        <th class="text-end">Preço Un.</th>
                                        <th class="text-end pe-4">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($v->itens as $item)
                                        <tr>
                                            <td class="ps-4 fw-bold text-dark">{{ $item->produto->nome ?? 'Removido' }}</td>
                                            <td class="text-muted">{{ $item->produto->sabor ?? '-' }}</td>
                                            <td class="text-center fw-medium">{{ $item->quantidade }}x</td>
                                            <td class="text-end text-muted">R$
                                                {{ number_format($item->preco_unitario, 2, ',', '.') }}</td>
                                            <td class="text-end pe-4 fw-bold text-success">R$
                                                {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-light border-top">
                                    <tr>
                                        <td colspan="4" class="text-end fw-bold text-dark pt-3 pb-3">TOTAL:</td>
                                        <td class="text-end pe-4 fw-bold text-primary fs-5 pt-3 pb-3">R$
                                            {{ number_format($v->valor_total, 2, ',', '.') }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function imprimirCupom(id) {
            const url = `/cupom/${id}`;
            window.open(url, 'Cupom', 'width=400,height=600');
        }

        function cancelarVenda(id) {
            Swal.fire({
                title: 'Cancelar Venda #' + id + '?',
                text: "Os produtos voltarão para o estoque e o valor será estornado. Essa ação não pode ser desfeita!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, cancelar!',
                cancelButtonText: 'Voltar'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processando...',
                        text: 'Devolvendo produtos ao estoque...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });

                    fetch(`/historico/vendas/${id}/cancelar`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.sucesso) {
                                Swal.fire({
                                    title: 'Sucesso!',
                                    text: data.mensagem,
                                    icon: 'success'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Erro!', data.mensagem, 'error');
                            }
                        })
                        .catch(err => {
                            console.error(err);
                            Swal.fire('Erro!', 'Falha na comunicação com o servidor.', 'error');
                        });
                }
            });
        }
    </script>

@endsection