@extends('layouts.app')

@section('content')
    <!-- Header Principal - APENAS NESTA TELA E NO PDV -->
    <header class="main-header">
        <div class="header-logo">
            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                {{-- Logo em texto ou Imagem --}}
                <h3 class="m-0 d-flex align-items-center"
                    style="color: var(--primary-color); font-weight: 700; letter-spacing: -0.05em;">
                    <img src="{{ asset('assets/img/logoagilizasemfundo.png') }}" alt="Logo" width="110" class="me-2">
                    AgilizaPDV
                </h3>
            </a>
        </div>

        <div class="header-user">
            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    style="padding: 0.4rem 1rem;">
                    <!-- Avatar Minimalista -->
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 28px; height: 28px; background: var(--primary-light)!important; font-size: 0.8rem; font-weight: 700;">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <span style="font-weight: 500;">{{ Auth::user()->name }}</span>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2"
                    style="border-radius: 12px; min-width: 200px;">
                    <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}">Meu Perfil</a></li>
                    <li>
                        <hr class="dropdown-divider my-1">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger fw-medium">Sair da Conta</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Área de Conteúdo do Dashboard -->
    <div class="container-fluid px-4 px-md-5 py-5" style="max-width: 1400px;">

        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 gap-3">
            <div>
                <h1 class="page-title">Painel de Desempenho</h1>
                <p class="text-muted mt-2 mb-0" style="font-size: 1.05rem;">Resumo em tempo real do seu restaurante.</p>
            </div>
            <div class="d-flex gap-2 flex-wrap justify-content-md-end">
                <a href="{{ route('relatorio.caixa') }}" class="btn btn-light text-dark d-flex align-items-center gap-2">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    Consulta de Caixa
                </a>
                <a href="{{ route('estoque.index') }}" class="btn btn-light d-flex align-items-center gap-2">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Consultar Estoque
                </a>
                <a href="{{ route('vendas.index') }}" class="btn btn-primary d-flex align-items-center gap-2">
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Abrir PDV / Caixa
                </a>
            </div>
        </div>

        <!-- Cards de Métricas -->
        <div class="row g-4 mb-5">
            <div class="col-12 col-md-4">
                <div class="floating-container">
                    <p class="text-muted mb-2 font-weight-500 text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.05em;">Vendas de Hoje</p>
                    <h2 class="mb-2 text-success">R$ {{ number_format($faturamentoDia, 2, ',', '.') }}</h2>
                    <div class="d-flex align-items-center gap-1 text-muted" style="font-size: 0.85rem; font-weight: 500;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                        <span>Faturamento do Dia</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="floating-container">
                    <p class="text-muted mb-2 font-weight-500 text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.05em;">Faturamento Líquido</p>
                    <h2 class="mb-2" style="color: #6610f2;">R$ {{ number_format($faturamentoLiquidoMes, 2, ',', '.') }}
                    </h2>
                    <div class="d-flex align-items-center gap-1 text-muted" style="font-size: 0.85rem; font-weight: 500;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>Mês Corrente</span>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="floating-container {{ $qtdBaixoEstoque > 0 ? 'border-danger' : '' }}"
                    style="cursor: pointer; {{ $qtdBaixoEstoque > 0 ? 'border-left: 4px solid #dc3545;' : '' }}"
                    id="btnEstoqueBaixo" role="button">
                    <p class="text-muted mb-2 font-weight-500 text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.05em;">Estoque Crítico (≤ 5)</p>
                    <h2 class="mb-2 {{ $qtdBaixoEstoque > 0 ? 'text-danger' : 'text-success' }}">{{ $qtdBaixoEstoque }}
                        <small style="font-size: 1rem;" class="text-muted">itens</small>
                    </h2>
                    <div class="d-flex align-items-center gap-1 {{ $qtdBaixoEstoque > 0 ? 'text-danger' : 'text-success' }}"
                        style="font-size: 0.85rem; font-weight: 500;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        <span>Clique para visualizar</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="form-card">
                    <h5 class="section-title">Evolução de Vendas (Mês Atual)</h5>
                    <canvas id="salesChart" style="max-height: 300px; width: 100%;"></canvas>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-6">
                <div class="form-card h-100">
                    <h5 class="section-title">Produtos Mais Vendidos (Qtd)</h5>
                    <div style="height: 250px; display: flex; justify-content: center;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-card h-100">
                    <h5 class="section-title">Faturamento por Pagamento</h5>
                    <div style="height: 250px;">
                        <canvas id="paymentChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-3">
            <div class="col-12">
                <h4 class="fw-bold text-secondary mb-3">Acesso Rápido a Cadastros e Relatórios</h4>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('produtos.index') }}"
                    class="btn btn-light w-100 h-100 py-3 shadow-none border transition-hover d-flex flex-column align-items-center justify-content-center text-center"
                    style="min-height: 110px;">
                    <div class="fs-4 mb-2">🍔</div> <span
                        style="font-size: 0.9rem; white-space: normal; line-height: 1.2;">Produtos</span>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('categorias.index') }}"
                    class="btn btn-light w-100 h-100 py-3 shadow-none border transition-hover d-flex flex-column align-items-center justify-content-center text-center"
                    style="min-height: 110px;">
                    <div class="fs-4 mb-2">🏷️</div> <span
                        style="font-size: 0.9rem; white-space: normal; line-height: 1.2;">Categorias</span>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('fornecedores.index') }}"
                    class="btn btn-light w-100 h-100 py-3 shadow-none border transition-hover d-flex flex-column align-items-center justify-content-center text-center"
                    style="min-height: 110px;">
                    <div class="fs-4 mb-2">📦</div> <span
                        style="font-size: 0.9rem; white-space: normal; line-height: 1.2;">Fornecedores</span>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('estabelecimentos.index') }}"
                    class="btn btn-light w-100 h-100 py-3 shadow-none border transition-hover d-flex flex-column align-items-center justify-content-center text-center"
                    style="min-height: 110px;">
                    <div class="fs-4 mb-2">🪑</div> <span
                        style="font-size: 0.9rem; white-space: normal; line-height: 1.2;">Estabelecimentos</span>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('usuarios.index') }}"
                    class="btn btn-light w-100 h-100 py-3 shadow-none border transition-hover d-flex flex-column align-items-center justify-content-center text-center"
                    style="min-height: 110px;">
                    <div class="fs-4 mb-2">👥</div> <span
                        style="font-size: 0.9rem; white-space: normal; line-height: 1.2;">Usuários</span>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('historico.entradas') }}"
                    class="btn btn-light w-100 h-100 py-3 shadow-none border transition-hover d-flex flex-column align-items-center justify-content-center text-center"
                    style="min-height: 110px;">
                    <div class="fs-4 mb-2">📥</div> <span
                        style="font-size: 0.9rem; white-space: normal; line-height: 1.2;">Histórico de Entradas</span>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('historico.vendas') }}"
                    class="btn btn-light w-100 h-100 py-3 shadow-none border transition-hover d-flex flex-column align-items-center justify-content-center text-center"
                    style="min-height: 110px;">
                    <div class="fs-4 mb-2">📈</div> <span
                        style="font-size: 0.9rem; white-space: normal; line-height: 1.2;">Histórico de Vendas</span>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('vinculos.index') }}"
                    class="btn btn-light w-100 h-100 py-3 shadow-none border transition-hover d-flex flex-column align-items-center justify-content-center text-center"
                    style="min-height: 110px;">
                    <div class="fs-4 mb-2">🔗</div> <span
                        style="font-size: 0.9rem; white-space: normal; line-height: 1.2;">Vínculo de Estabelecimentos</span>
                </a>
            </div>
            <div class="col-6 col-md-3 col-lg-2">
                <a href="{{ route('lixeira.index') }}"
                    class="btn btn-light w-100 h-100 py-3 shadow-none border text-danger transition-hover d-flex flex-column align-items-center justify-content-center text-center"
                    style="min-height: 110px;">
                    <div class="fs-4 mb-2">🗑️</div> <span
                        style="font-size: 0.9rem; white-space: normal; line-height: 1.2;">Lixeira</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Estoque Baixo por Estabelecimento -->
    <div class="modal fade" id="estoqueModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content border-0" style="border-radius: var(--radius-lg); box-shadow: var(--shadow-hover);">
                <div class="modal-header bg-danger bg-opacity-10 border-bottom-0">
                    <h5 class="modal-title fw-bold text-danger d-flex align-items-center gap-2">
                        <svg width="24" height="24" fill="none" class="text-danger" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                        Alerta de Ruptura de Estoque
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body p-4 bg-light">
                    <div id="estoqueList" style="max-height: 500px; overflow-y: auto;">
                    </div>
                </div>
                <div class="modal-footer border-top-0 bg-light" id="estoqueFooter" style="display: none;">
                    <a href="{{ route('dashboard.relatorio.estoque') }}" target="_blank"
                        class="btn btn-dark d-flex align-items-center gap-2 mx-auto px-4 py-2"
                        style="border-radius: 10px; font-weight: 600;">
                        <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        Gerar Relatório de Reposição
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const dadosPorEstabelecimento = @json($produtosBaixoEstoquePorEstabelecimento);
        const labelsEvolucao = @json($labelsGrafico);
        const valuesEvolucao = @json($valoresGrafico);
        const labelsCat = @json($labelsCat);
        const valuesCat = @json($valoresCat);
        const labelsPag = @json($labelsPag);
        const valuesPag = @json($valoresPag);

        // Evento de clique no card de Estoque Baixo
        document.getElementById('btnEstoqueBaixo').addEventListener('click', function () {
            const listaEl = document.getElementById('estoqueList');
            const footerEl = document.getElementById('estoqueFooter');

            // Verifica total global
            let totalItens = 0;
            dadosPorEstabelecimento.forEach(g => totalItens += g.itens.length);

            if (totalItens === 0) {
                listaEl.innerHTML =
                    '<p class="text-muted text-center py-5">Ufa! Nenhum produto com estoque crítico no momento.</p>';
                footerEl.style.display = 'none';
            } else {
                let html = '';

                dadosPorEstabelecimento.forEach(grupo => {
                    html += `
                                    <div class="mb-4">
                                        <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-3 mb-3"
                                             style="background: #f0f4ff; border-left: 4px solid #4682B4;">
                                            <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="#4682B4">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                            <h6 class="mb-0 fw-bold" style="color: #1a1a2e;">${grupo.estabelecimento_nome}</h6>
                                            <span class="ms-auto badge rounded-pill"
                                                  style="background: #4682B4; color: white; font-size: 0.75rem;">
                                                ${grupo.itens.length} ${grupo.itens.length === 1 ? 'item' : 'itens'}
                                            </span>
                                        </div>
                                `;

                    if (grupo.itens.length > 0) {
                        html += '<div class="list-group shadow-sm" style="border-radius: var(--radius-md);">';
                        grupo.itens.forEach(item => {
                            const badgeClass = item.saldo_final <= 0
                                ? 'background: #fee2e2; color: #dc2626; border: 1px solid #fecaca;'
                                : 'background: #fef3c7; color: #d97706; border: 1px solid #fde68a;';
                            const label = item.saldo_final <= 0 ? 'Repor Imediatamente' : 'Estoque Baixo';
                            const labelStyle = item.saldo_final <= 0
                                ? 'badge-soft-danger'
                                : '';
                            const labelBg = item.saldo_final <= 0
                                ? ''
                                : 'style="background: #fef3c7; color: #d97706; border: 1px solid #fde68a;"';
                            html += `
                                            <div class="list-group-item border-0 border-start border-4 ${item.saldo_final <= 0 ? 'border-danger' : 'border-warning'} mb-2 rounded bg-white">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-1 fw-bold text-dark">${item.produto}</h6>
                                                        <p class="mb-0 text-muted small">
                                                            <strong>Sabor:</strong> ${item.sabor} &bull; <strong>Categoria:</strong> ${item.tipo}
                                                        </p>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="badge ${labelStyle} rounded-pill" ${labelBg}>${label}</span>
                                                        <p class="mb-0 fw-bold mt-1 fs-5" style="color: ${item.saldo_final <= 0 ? '#dc2626' : '#d97706'};">
                                                            ${item.saldo_final} un
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        `;
                        });
                        html += '</div>';
                    } else {
                        html += `
                                        <div class="text-center py-3 rounded-3" style="background: #f0fdf4; border: 1px dashed #86efac; color: #16a34a; font-weight: 600;">
                                            ✅ Estoque OK neste estabelecimento
                                        </div>
                                    `;
                    }

                    html += '</div>';
                });

                listaEl.innerHTML = html;
                footerEl.style.display = 'flex';
            }

            new bootstrap.Modal(document.getElementById('estoqueModal')).show();
        });

        // --- GRÁFICO 1: EVOLUÇÃO (Linha) ---
        new Chart(document.getElementById('salesChart').getContext('2d'), {
            type: 'line',
            data: {
                labels: labelsEvolucao,
                datasets: [{
                    label: 'Faturamento Diário (R$)',
                    data: valuesEvolucao,
                    borderColor: '#4682B4',
                    backgroundColor: 'rgba(70, 130, 180, 0.1)',
                    borderWidth: 3,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#4682B4',
                    pointRadius: 5,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(229, 231, 235, 0.5)',
                            borderDash: [5, 5]
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // --- GRÁFICO 2: CATEGORIAS (Rosca) ---
        new Chart(document.getElementById('categoryChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: labelsCat,
                datasets: [{
                    data: valuesCat,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'],
                    hoverOffset: 4,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                }
            }
        });

        // --- GRÁFICO 3: PAGAMENTOS (Barras) ---
        new Chart(document.getElementById('paymentChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: labelsPag,
                datasets: [{
                    label: 'Total Recebido (R$)',
                    data: valuesPag,
                    backgroundColor: ['#20c997', '#0d6efd', '#6f42c1', '#ffc107', '#fd7e14'],
                    borderRadius: 5,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(229, 231, 235, 0.5)',
                            borderDash: [5, 5]
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endsection