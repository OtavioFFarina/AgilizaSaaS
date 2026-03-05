@extends('layouts.app')

@section('content')
    <!-- Header Principal - APENAS NESTA TELA E NO PDV -->
    <header class="main-header">
        <div class="header-logo">
            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                {{-- Logo em texto ou Imagem --}}
                <h4 class="m-0 d-flex align-items-center"
                    style="color: var(--primary-color); font-weight: 700; letter-spacing: -0.05em;">
                    <img src="{{ asset('assets/img/logoagilizasemfundo.png') }}" alt="Logo" width="30" class="me-2">
                    AgilizaPDV
                </h4>
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

        <div class="d-flex justify-content-between align-items-end mb-5">
            <div>
                <h1 class="page-title">Visão Geral</h1>
                <p class="text-muted mt-2 mb-0" style="font-size: 1.05rem;">Resumo em tempo real do seu restaurante.</p>
            </div>
            <div>
                <a href="{{ route('pdv.index') }}" class="btn btn-primary">
                    {{-- Ícone Feather/Heroicons --}}
                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Abrir PDV / Caixa
                </a>
            </div>
        </div>

        <!-- Cards de Métricas -->
        <div class="row g-4 mb-5">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="floating-container">
                    <p class="text-muted mb-2 font-weight-500 text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.05em;">Vendas Hoje</p>
                    <h2 class="mb-2">R$ 0,00</h2>
                    <div class="d-flex align-items-center gap-1 text-success" style="font-size: 0.85rem; font-weight: 500;">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                        </svg>
                        <span>Em breve...</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="floating-container">
                    <p class="text-muted mb-2 font-weight-500 text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.05em;">Pedidos Ativos</p>
                    <h2 class="mb-2">0</h2>
                    <div class="d-flex align-items-center gap-1 text-muted" style="font-size: 0.85rem; font-weight: 500;">
                        <span>Em preparo</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="floating-container">
                    <p class="text-muted mb-2 font-weight-500 text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.05em;">Ticket Médio</p>
                    <h2 class="mb-2">R$ 0,00</h2>
                    <div class="d-flex align-items-center gap-1 text-muted" style="font-size: 0.85rem; font-weight: 500;">
                        <span>Base de hoje</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="floating-container">
                    <p class="text-muted mb-2 font-weight-500 text-uppercase"
                        style="font-size: 0.75rem; letter-spacing: 0.05em;">Mesas Ocupadas</p>
                    <h2 class="mb-2">0</h2>
                    <div class="d-flex align-items-center gap-1 text-muted" style="font-size: 0.85rem; font-weight: 500;">
                        <span>Do total disponível</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Atividade e Acesso Rápido -->
        <div class="row g-4">
            <!-- Tabela -->
            <div class="col-lg-8">
                <div class="table-container p-0">
                    <div class="d-flex justify-content-between align-items-center p-4 pb-3 border-bottom border-light">
                        <h5 class="m-0 font-weight-600">Últimos Pedidos</h5>
                        <a href="{{ route('historico.vendas') }}" class="btn btn-light btn-sm px-3">Ver todos</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table-modern mb-0">
                            <thead>
                                <tr>
                                    <th>Identificação</th>
                                    <th>Cliente / Tipo</th>
                                    <th>Status</th>
                                    <th class="text-end">Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Ainda não há pedidos recentes
                                        registrados hoje.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Atalhos Laterais -->
            <div class="col-lg-4">
                <div class="table-container">
                    <h5 class="mb-4">Ações Rápidas</h5>
                    <div class="d-flex flex-column gap-3">
                        <a href="{{ route('produtos.create') ?? '#' }}"
                            class="btn btn-light w-100 justify-content-start py-3 px-4 border text-start shadow-none">
                            <span class="me-3 fs-5">🍔</span> Cadastrar Produto
                        </a>
                        <a href="{{ route('estabelecimentos.index') ?? '#' }}"
                            class="btn btn-light w-100 justify-content-start py-3 px-4 border text-start shadow-none">
                            <span class="me-3 fs-5">🪑</span> Estabelecimentos
                        </a>
                        <a href="{{ route('categorias.index') ?? '#' }}"
                            class="btn btn-light w-100 justify-content-start py-3 px-4 border text-start shadow-none">
                            <span class="me-3 fs-5">🏷️</span> Categorias
                        </a>
                        <a href="{{ route('pdv.index') ?? '#' }}"
                            class="btn btn-primary w-100 justify-content-start py-3 px-4 border-0 text-start shadow-sm mt-2">
                            <span class="me-3 fs-5 text-white">💰</span> PDV (Frente de Caixa)
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection