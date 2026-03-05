@extends('layouts.app_internal')

@section('content')

    <!-- Barra Minimalista de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 1400px;">
        <div class="d-flex align-items-center mb-4">
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
            <h1 class="page-title"><i class='bx bx-history text-primary me-2'></i> Histórico de Entradas no Estoque</h1>
        </div>

        <!-- Filtros -->
        <div class="row g-4 mb-4">
            <div class="col-12 border-0">
                <div class="form-card">
                    <h5 class="section-title mb-4">Filtros de Busca</h5>

                    <form method="GET" action="{{ route('historico.entradas') }}" class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label">Produto / Sabor</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted"
                                    style="border-radius: 10px 0 0 10px;">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </span>
                                <input type="text" name="produto" class="form-control border-start-0 ps-0"
                                    placeholder="Ex: Chocolate" value="{{ request('produto') }}" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Data Inicial</label>
                            <input type="date" name="data_inicial" class="form-control"
                                value="{{ request('data_inicial') }}" />
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Data Final</label>
                            <input type="date" name="data_final" class="form-control" value="{{ request('data_final') }}" />
                        </div>
                        <div class="col-md-2 d-flex gap-2">
                            <a href="{{ route('historico.entradas') }}" class="btn btn-light py-2 px-3"
                                title="Limpar Filtros" style="height: 48px;">
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
                            <th class="ps-4">Data / Hora</th>
                            <th>Produto</th>
                            <th>Sabor</th>
                            <th>Tipo</th>
                            <th class="text-center">Quantidade</th>
                            <th class="text-end pe-4">Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($entradas as $row)
                            <tr>
                                <td class="ps-4 text-muted small">
                                    <span
                                        class="d-block text-dark fw-medium mb-1">{{ $row->created_at->format('d/m/Y') }}</span>
                                    <span class="d-block">{{ $row->created_at->format('H:i') }}</span>
                                </td>
                                <td class="fw-bold">{{ $row->produto->nome ?? 'Removido' }}</td>
                                <td class="text-muted">{{ $row->produto->sabor ?? '-' }}</td>
                                <td>
                                    @if ($row->tipo == 'entrada')
                                        <span class="badge badge-soft-success d-inline-flex align-items-center gap-1">
                                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                            </svg>
                                            Entrada
                                        </span>
                                    @else
                                        <span class="badge badge-soft-danger d-inline-flex align-items-center gap-1">
                                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                            </svg>
                                            Saída
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($row->tipo == 'entrada')
                                        <span class="fw-bold text-success">+{{ $row->quantidade }}</span>
                                    @else
                                        <span class="fw-bold text-danger">-{{ $row->quantidade }}</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4 text-muted small">{{ $row->motivo ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center p-5 text-muted">
                                    <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        class="opacity-25 mb-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    <p class="m-0">Nenhum registro encontrado para os filtros aplicados.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection