@extends('layouts.app_internal')

@section('content')

    <!-- Barra de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 1400px;">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <a href="{{ route('dashboard') }}" class="btn-back">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Voltar ao Dashboard
            </a>
            <button class="btn btn-primary" onclick="window.print()">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                    </path>
                </svg>
                Imprimir Relatório
            </button>
        </div>
    </div>

    <div class="container-fluid px-4 px-md-5 pb-5" style="max-width: 1400px;">

        <!-- Título da Página -->
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h1 class="page-title"><i class='bx bx-clipboard text-danger me-2'></i>Relatório de Reposição de Estoque
                </h1>
                <p class="text-muted mt-2 mb-0" style="font-size: 1.05rem;">
                    Gerado em {{ now()->format('d/m/Y') }} às {{ now()->format('H:i') }}
                </p>
            </div>
        </div>

        <!-- Resumo Geral -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-md-6">
                <div class="floating-container {{ $totalItens > 0 ? 'border-danger' : '' }}"
                    style="{{ $totalItens > 0 ? 'border-left: 4px solid #dc3545;' : '' }}">
                    <p class="text-muted mb-2 font-weight-500 text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.05em;">Total de Itens para Repor</p>
                    <h2 class="mb-1 {{ $totalItens > 0 ? 'text-danger' : 'text-success' }}">{{ $totalItens }}
                        <small style="font-size: 1rem;" class="text-muted">itens</small>
                    </h2>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="floating-container">
                    <p class="text-muted mb-2 font-weight-500 text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.05em;">Estabelecimentos Analisados</p>
                    <h2 class="mb-1" style="color: var(--primary-color);">{{ count($dados) }}
                        <small style="font-size: 1rem;" class="text-muted">estabelecimentos</small>
                    </h2>
                </div>
            </div>
        </div>

        <!-- Seções por Estabelecimento -->
        @foreach ($dados as $grupo)
            <div class="table-container p-0 mb-4">
                <div class="d-flex justify-content-between align-items-center p-4 pb-3 border-bottom border-light">
                    <div class="d-flex align-items-center gap-2">
                        <i class='bx bx-store fs-5' style="color: var(--primary-color);"></i>
                        <h5 class="m-0 font-weight-600">{{ $grupo['estabelecimento_nome'] }}</h5>
                    </div>
                    <span
                        class="badge {{ count($grupo['itens']) > 0 ? 'badge-soft-danger' : 'badge-soft-success' }} rounded-pill px-3 py-2">
                        {{ count($grupo['itens']) }} {{ count($grupo['itens']) === 1 ? 'item' : 'itens' }}
                    </span>
                </div>

                @if (count($grupo['itens']) > 0)
                    <div class="table-responsive">
                        <table class="table-modern mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4">Produto</th>
                                    <th>Sabor</th>
                                    <th>Categoria</th>
                                    <th class="text-center pe-4">Qtd. Atual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($grupo['itens'] as $item)
                                    <tr>
                                        <td class="ps-4 fw-bold text-dark">{{ $item['produto'] }}</td>
                                        <td class="text-muted">{{ $item['sabor'] }}</td>
                                        <td>
                                            <span class="badge bg-light border text-dark rounded-pill px-3 py-1 fw-medium">
                                                {{ $item['tipo'] }}
                                            </span>
                                        </td>
                                        <td class="text-center pe-4">
                                            @php
                                                $qtd = $item['saldo_final'];
                                                $classe = 'badge-soft-danger';
                                                if ($qtd > 0 && $qtd <= 5) {
                                                    $classe = '';
                                                    $style = 'background-color: #fef3c7; color: #d97706; border: 1px solid #fde68a;';
                                                } else {
                                                    $style = '';
                                                }
                                            @endphp
                                            <span class="badge {{ $classe }} px-3 py-2 fs-6 rounded-pill" style="{{ $style }}">
                                                {{ $qtd }} un
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class='bx bx-check-circle fs-1 text-success opacity-50 mb-2 d-block'></i>
                        <p class="m-0 fw-medium text-success">Estoque OK — Nenhum item abaixo do nível crítico.</p>
                    </div>
                @endif
            </div>
        @endforeach

    </div>

    <style>
        @media print {

            .btn-back,
            .btn-primary,
            .main-header {
                display: none !important;
            }

            body {
                background: white !important;
            }

            .floating-container,
            .table-container {
                box-shadow: none !important;
                border: 1px solid #e5e7eb !important;
            }

            .badge-soft-danger,
            .badge-soft-success,
            .badge {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>

@endsection