@extends('layouts.app_internal')

@section('content')

    <!-- Barra Minimalista de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 1400px;">
        <div class="d-flex align-items-center mb-4">
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
            <h1 class="page-title"><i class='bx bx-bar-chart-alt-2 text-primary me-2'></i> Relatório de Fechamento de Caixa
            </h1>
        </div>

        <!-- Filtros (Apenas Admin/Dono) -->
        @if ($tipo_usuario === 'admin_master' || $tipo_usuario === 'dono')
            <div class="form-card mb-4 border-0">
                <h5 class="section-title mb-4">Filtrar por Período e Desempenho Global</h5>

                <form method="GET" action="{{ route('relatorio.caixa') }}" class="row g-3 align-items-end mb-4">
                    <div class="col-md-4">
                        <label class="form-label">Mês Específico de Fechamento</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted"
                                style="border-radius: 10px 0 0 10px;">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </span>
                            <input type="month" name="data" class="form-control border-start-0 ps-0" value="{{ $dataFiltro }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 fw-medium" style="height: 48px;">Buscar</button>
                    </div>
                </form>

                <div class="row g-4 mt-2">
                    <div class="col-md-4">
                        <div class="p-4 rounded-4" style="background-color: var(--primary-light); color: var(--primary-color);">
                            <p class="mb-1 fw-bold text-uppercase small opacity-75">Lucro Bruto (Faturamento)</p>
                            <h3 class="m-0 fw-bold">R$ {{ number_format($faturamentoTotal, 2, ',', '.') }}</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 rounded-4" style="background-color: #fee2e2; color: #dc2626;">
                            <p class="mb-1 fw-bold text-uppercase small opacity-75">Custo das Vendas</p>
                            <h3 class="m-0 fw-bold">R$ {{ number_format($custoTotal, 2, ',', '.') }}</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-4 rounded-4" style="background-color: #dcfce7; color: #16a34a;">
                            <p class="mb-1 fw-bold text-uppercase small opacity-75">Lucro Líquido Real</p>
                            <h3 class="m-0 fw-bold">R$ {{ number_format($lucroTotal, 2, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div
                class="alert bg-primary bg-opacity-10 text-primary border-primary border-opacity-25 rounded-3 mb-4 d-flex align-items-center gap-3 p-4">
                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h6 class="m-0 fw-bold">Modo Operador</h6>
                    <p class="m-0 small opacity-75">Você está visualizando apenas os registros de caixa do seu turno atual e
                        anteriores.</p>
                </div>
            </div>
        @endif

        <!-- Fechamentos Cards Em Grid -->
        <h5 class="section-title mb-4 mt-4">Detalhes dos Caixas</h5>

        <div class="row g-4">
            @forelse ($fechamentos as $caixa)
                <div class="col-12">
                    <div class="form-card h-100 border-0 p-0 shadow-sm"
                        style="overflow: hidden; border: 1px solid var(--border-color)!important;">
                        <!-- Cabecalho do Card de Caixa -->
                        <div class="p-4 bg-light border-bottom d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                    style="width: 48px; height: 48px; font-size: 1.2rem;">
                                    {{ substr($caixa->user->name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="m-0 fw-bold fs-5 text-dark">{{ $caixa->user->name ?? 'Usuário' }}</h6>
                                    <p class="m-0 text-muted small mt-1">
                                        <span class="d-inline-flex align-items-center gap-1"><i
                                                class='bx bx-log-in-circle text-success'></i>
                                            {{ \Carbon\Carbon::parse($caixa->data_abertura)->format('d/m/y H:i') }}</span>
                                        <span class="mx-2 opacity-25">|</span>
                                        <span class="d-inline-flex align-items-center gap-1"><i
                                                class='bx bx-log-out-circle text-danger'></i>
                                            {{ \Carbon\Carbon::parse($caixa->data_fechamento)->format('d/m/y H:i') }}</span>
                                    </p>
                                </div>
                            </div>
                            <div class="text-end">
                                <p class="m-0 text-muted small text-uppercase fw-bold mb-1">Total Movimentado</p>
                                <h4 class="m-0 text-primary fw-bold">R$ {{ number_format($caixa->faturamento, 2, ',', '.') }}
                                </h4>
                                <p class="m-0 text-success small fw-bold mt-1">Líquido: R$
                                    {{ number_format($caixa->lucro_liquido, 2, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Corpo do Card -->
                        <div class="p-4 d-flex flex-column flex-md-row gap-4">

                            <!-- Lista Resumo Pagamentos -->
                            <div class="flex-grow-1 border-end-md pe-md-4" style="min-width: 200px;">
                                <h6 class="text-muted fw-bold text-uppercase small mb-3">Resumo Financeiro</h6>

                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary"><i class='bx bx-wallet me-1 text-muted'></i> Fundo
                                        Inicial</span>
                                    <span class="fw-medium">R$ {{ number_format($caixa->valor_abertura, 2, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary"><i class='bx bx-money me-1 text-success'></i> Dinheiro</span>
                                    <span class="fw-medium">R$ {{ number_format($caixa->total_dinheiro, 2, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary"><i class='bx bx-credit-card me-1 text-primary'></i>
                                        Crédito</span>
                                    <span class="fw-medium">R$ {{ number_format($caixa->total_credito, 2, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary"><i class='bx bx-credit-card-front me-1 text-info'></i>
                                        Débito</span>
                                    <span class="fw-medium">R$ {{ number_format($caixa->total_debito, 2, ',', '.') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span class="text-secondary"><i class='bx bxs-zap me-1 text-warning'></i> PIX</span>
                                    <span class="fw-medium">R$ {{ number_format($caixa->total_pix, 2, ',', '.') }}</span>
                                </div>

                                @if ($caixa->total_sangrias > 0)
                                    <div class="d-flex justify-content-between mb-3 pt-2 border-top">
                                        <span class="text-danger"><i class='bx bx-money-withdraw me-1'></i> Retiradas
                                            (Sangria)</span>
                                        <span class="fw-bold text-danger">- R$
                                            {{ number_format($caixa->total_sangrias, 2, ',', '.') }}</span>
                                    </div>
                                @endif

                                <div
                                    class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center mt-auto border">
                                    <span class="fw-bold text-dark small">Na Gaveta (Dinheiro)</span>
                                    <span class="fw-bold text-success fs-6">R$
                                        {{ number_format($caixa->esperado_gaveta, 2, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Itens Vendidos Resumo -->
                            <div class="flex-grow-1" style="flex-basis: 50%;">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="text-muted fw-bold text-uppercase small m-0">Últimos Produtos</h6>
                                    <button class="btn btn-sm btn-light text-primary py-0 px-2 rounded-pill fw-medium border"
                                        data-bs-toggle="collapse" data-bs-target="#itens-{{ $caixa->id }}">
                                        Ver Todos <i class='bx bx-chevron-down'></i>
                                    </button>
                                </div>

                                <div class="collapse show" id="itens-{{ $caixa->id }}">
                                    <div style="max-height: 220px; overflow-y: auto;" class="column-scroll pe-2">
                                        <ul class="list-unstyled m-0 d-flex flex-column gap-2">
                                            @forelse ($caixa->vendas as $venda)
                                                @foreach ($venda->itens as $item)
                                                    <li class="p-2 bg-light rounded-2 border" style="font-size: 0.85rem;">
                                                        <div class="d-flex justify-content-between fw-bold text-dark">
                                                            <span>{{ $item->produto->nome ?? 'Produto' }} <small
                                                                    class="text-muted fw-normal">x{{ $item->quantidade }}</small></span>
                                                        </div>
                                                        <div class="d-flex justify-content-between text-muted mt-1">
                                                            <span class="badge border bg-white text-secondary"
                                                                style="font-size: 0.70rem;">{{ $venda->forma_pagamento }}</span>
                                                            <span>{{ $item->produto->sabor ?? '-' }}</span>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @empty
                                                <li class="text-center py-4 text-muted small">Nenhum produto registrado.</li>
                                            @endforelse
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        class="text-muted opacity-25 mb-3">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <h4 class="text-muted fw-bold">Nenhum Fechamento Encontrado</h4>
                    <p class="text-muted">Não há registros de caixas fechados para o período selecionado.</p>
                </div>
            @endforelse
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        /* Scrollbar bonita para a listinha de produtos */
        .column-scroll::-webkit-scrollbar {
            width: 4px;
        }

        .column-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .column-scroll::-webkit-scrollbar-thumb {
            background-color: var(--border-color);
            border-radius: 10px;
        }

        .border-end-md {
            border-right: 1px solid var(--border-color);
        }

        @media (max-width: 768px) {
            .border-end-md {
                border-right: none;
                border-bottom: 1px solid var(--border-color);
                padding-bottom: 1rem;
                margin-bottom: 1rem;
            }
        }
    </style>
@endsection