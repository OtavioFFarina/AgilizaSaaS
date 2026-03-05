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
                    AgilizaPDV <span class="text-muted fw-normal ms-2 fs-6">| PDV</span>
                </h3>
            </a>
        </div>

        <div class="header-user d-flex align-items-center gap-3">
            @if ($caixaStatus === 'aberto')
                <span class="badge badge-soft-success py-2 px-3"><i class='bx bxs-lock-open-alt'></i> Caixa Aberto</span>
            @else
                <span class="badge badge-soft-danger py-2 px-3"><i class='bx bxs-lock-alt'></i> Caixa Fechado</span>
            @endif

            <div class="dropdown">
                <button class="btn btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    style="padding: 0.4rem 1rem;">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center"
                            style="width: 28px; height: 28px; background: var(--primary-light)!important; font-size: 0.8rem; font-weight: 700;">
                            {{ substr(Auth::user()->name, 0, 2) }}
                        </div>
                        <span style="font-weight: 500;" class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                    </div>
                </button>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2"
                    style="border-radius: 12px; min-width: 220px;">
                    @if (Auth::user()->role === 'admin_master' || Auth::user()->role === 'dono')
                        <li>
                            <a class="dropdown-item py-2 fw-medium" href="{{ route('dashboard') }}">
                                <i class='bx bxs-dashboard me-2'></i> Ir para Dashboard
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider my-1">
                        </li>
                    @endif
                    <li>
                        <a class="dropdown-item py-2" href="{{ route('estoque.index') }}">
                            <i class='bx bx-box me-2'></i> Estoque
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider my-1">
                    </li>
                    <li>
                        <a class="dropdown-item py-2 text-primary fw-medium" href="#" data-bs-toggle="modal"
                            data-bs-target="#modalCaixa">
                            <i class='bx bx-toggle-left me-2'></i> Abrir/Fechar Caixa
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider my-1">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item py-2 text-danger fw-medium">
                                <i class='bx bx-log-out me-2'></i> Sair da Conta
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </header>

    <!-- Área de Conteúdo do PDV -->
    <div class="container-fluid px-4 py-4" style="height: calc(100vh - 80px); overflow: hidden;">
        <div class="row h-100 g-4">

            <!-- Categorias e Produtos -->
            <div class="col-lg-8 h-100 column-scroll" style="overflow-y: auto;">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h4 class="m-0 fw-bold">Categorias</h4>
                </div>

                <div class="row g-3">
                    @foreach ($categorias as $cat)
                        <div class="col-6 col-md-4 col-xl-3">
                            <button class="floating-container w-100 text-center border-0 bg-white"
                                style="padding: 2rem 1rem; cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#modalCat{{ $cat->id }}">
                                <div class="mb-3">
                                    <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                        style="width: 60px; height: 60px; background: var(--primary-light); color: var(--primary-color);">
                                        <svg width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                            </path>
                                        </svg>
                                    </span>
                                </div>
                                <h6 class="m-0 fw-bold">{{ $cat->nome }}</h6>
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Carrinho de Compras -->
            <div class="col-lg-4 h-100">
                <div class="form-card h-100 d-flex flex-column p-0" style="overflow: hidden;">
                    <!-- Cabeçalho do Carrinho -->
                    <div class="p-4 border-bottom d-flex justify-content-between align-items-center bg-light"
                        style="border-radius: var(--radius-lg) var(--radius-lg) 0 0;">
                        <h5 class="m-0 fw-bold d-flex align-items-center gap-2">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                            Carrinho Atual
                        </h5>
                        <button class="btn btn-sm btn-light text-danger fw-medium" onclick="limparCarrinho()">
                            Limpar
                        </button>
                    </div>

                    <!-- Lista de Itens -->
                    <div class="flex-grow-1 p-3" style="overflow-y: auto; background-color: #fafbfc;">
                        <ul id="carrinhoLista" class="list-unstyled m-0 d-flex flex-column gap-2"></ul>
                        <div id="emptyCartMsg"
                            class="text-center text-muted mt-5 py-5 d-flex flex-column align-items-center">
                            <svg width="48" height="48" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                class="opacity-25 mb-3" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            <p class="m-0 fw-medium">Seu carrinho está vazio.</p>
                            <small>Selecione uma categoria ao lado.</small>
                        </div>
                    </div>

                    <!-- Rodapé / Totais -->
                    <div class="p-4 bg-white border-top">
                        <div class="d-flex justify-content-between mb-2 text-muted fw-medium">
                            <span>Subtotal</span>
                            <span id="subtotalDisplay">R$ 0,00</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mb-4">
                            <span class="fw-bold fs-5 text-dark">TOTAL</span>
                            <span id="totalCarrinho" class="fw-bold text-primary" style="font-size: 1.75rem;">R$ 0,00</span>
                        </div>
                        <button
                            class="btn btn-primary w-100 py-3 d-flex justify-content-center align-items-center gap-2 fs-5 shadow-sm"
                            onclick="finalizarVenda()">
                            <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Finalizar Venda
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Modais de Produtos das Categorias -->
    @foreach ($categorias as $cat)
        @php
            $produtosDaCategoria = $produtos->get($cat->id, collect());
        @endphp
        <div class="modal fade" id="modalCat{{ $cat->id }}" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content border-0" style="border-radius: var(--radius-lg);">
                    <div class="modal-header border-bottom-0 bg-light p-4">
                        <h4 class="modal-title fw-bold text-dark d-flex align-items-center gap-2">
                            <span class="d-inline-flex align-items-center justify-content-center rounded-circle"
                                style="width: 40px; height: 40px; background: var(--primary-light); color: var(--primary-color);">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                    </path>
                                </svg>
                            </span>
                            {{ $cat->nome }}
                        </h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 pt-1 bg-light">
                        @if($produtosDaCategoria->isEmpty())
                            <div class="text-center py-5 text-muted">
                                <p>Nenhum produto cadastrado nesta categoria.</p>
                            </div>
                        @else
                            <div class="row g-4 mt-1">
                                @foreach ($produtosDaCategoria as $prod)
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="form-card h-100 p-4 border-0 text-center d-flex flex-column justify-content-between transition shadow-sm"
                                            style="border: 1px solid var(--border-color)!important;">
                                            <div>
                                                <h6 class="fw-bold mb-1 text-dark" style="font-size: 1.1rem;">{{ $prod->nome }}</h6>
                                                @if($prod->sabor)
                                                    <small
                                                        class="text-muted bg-light px-2 py-1 rounded d-inline-block mt-2">{{ $prod->sabor }}</small>
                                                @endif
                                                <h4 class="text-primary fw-bold mt-3 mb-0">R$
                                                    {{ number_format($prod->preco_venda, 2, ',', '.') }}
                                                </h4>
                                            </div>
                                            <div class="mt-4 pt-3 border-top">
                                                <div
                                                    class="d-flex align-items-center justify-content-between mb-3 bg-light rounded-pill p-1">
                                                    <button
                                                        class="btn btn-sm btn-white rounded-circle text-danger border-0 d-flex align-items-center justify-content-center"
                                                        style="width: 32px; height: 32px;" type="button"
                                                        onclick="alterarQtd('prod{{ $prod->id }}', -1)">
                                                        <svg width="16" height="16" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    <input type="text"
                                                        class="form-control text-center fw-bold border-0 bg-transparent p-0 w-25"
                                                        id="prod{{ $prod->id }}" value="1" readonly>
                                                    <button
                                                        class="btn btn-sm btn-white rounded-circle text-success border-0 d-flex align-items-center justify-content-center"
                                                        style="width: 32px; height: 32px;" type="button"
                                                        onclick="alterarQtd('prod{{ $prod->id }}', 1)">
                                                        <svg width="16" height="16" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                d="M12 4v16m8-8H4"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                <button
                                                    class="btn btn-primary w-100 fw-medium d-flex justify-content-center align-items-center gap-2"
                                                    onclick="adicionarProduto({{ $prod->id }}, '{{ addslashes($prod->nome . ($prod->sabor ? ' - ' . $prod->sabor : '')) }}', document.getElementById('prod{{ $prod->id }}').value, {{ $prod->preco_venda }}, 'prod{{ $prod->id }}')">
                                                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                    </svg>
                                                    Adicionar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Modal Caixa -->
    <div class="modal fade" id="modalCaixa" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-lg);">
                <div class="modal-header border-0 pb-0 mt-2 px-4">
                    <h5 class="modal-title fw-bold text-dark fs-4">Controle de Caixa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 pt-3">
                    <div class="text-center mb-4 p-4 rounded bg-light">
                        @if ($caixaStatus === 'aberto')
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white text-success shadow-sm mb-3"
                                style="width: 80px; height: 80px;">
                                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="fw-bold text-success mb-1">Caixa Aberto</h4>
                            <p class="text-muted m-0">O sistema está registrando vendas.</p>
                        @else
                            <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-white text-danger shadow-sm mb-3"
                                style="width: 80px; height: 80px;">
                                <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="fw-bold text-danger mb-1">Caixa Fechado</h4>
                            <p class="text-muted m-0">Abra o caixa para começar a vender.</p>
                        @endif
                    </div>

                    @if ($caixaStatus === 'aberto')
                        @if (Auth::user()->role === 'admin_master' || Auth::user()->role === 'dono')
                            <form method="post" action="{{ route('caixa.sangria') }}" class="mb-4">
                                @csrf
                                <label class="form-label fw-bold text-warning d-flex align-items-center gap-2">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Retirada Esporádica (Sangria)
                                </label>
                                <div class="input-group input-group-lg mb-2">
                                    <span class="input-group-text bg-white border-end-0">R$</span>
                                    <input type="text" class="form-control border-start-0 ps-0" name="valor_sangria"
                                        placeholder="0,00" required>
                                </div>
                                <label class="form-label fw-bold text-warning d-flex align-items-center gap-2 mt-3">
                                    <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                    Senha (Confirmação)
                                </label>
                                <div class="input-group input-group-lg mb-4">
                                    <span class="input-group-text bg-white border-end-0">
                                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </span>
                                    <input type="password" class="form-control border-start-0 ps-0" name="password_sangria"
                                        placeholder="Digite sua senha" required>
                                </div>

                                <button type="submit"
                                    class="btn btn-warning w-100 py-3 fw-bold text-dark fs-5 shadow-sm d-flex justify-content-center align-items-center gap-2">
                                    <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    Sacar
                                </button>
                                <div class="form-text mt-2 text-center">Retire o valor correspondente fisicamente da gaveta.</div>
                            </form>
                        @endif

                        <form id="formFecharCaixa" method="post" action="{{ route('caixa.fechar') }}">
                            @csrf
                            <button type="button" onclick="confirmarFechamento()"
                                class="btn btn-danger w-100 py-3 fw-bold fs-5 shadow-sm d-flex justify-content-center align-items-center gap-2">
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                                </svg>
                                Fechar Caixa Definitivamente
                            </button>
                        </form>
                    @else
                        <form method="post" action="{{ route('caixa.abrir') }}">
                            @csrf
                            <div class="mb-4 text-start">
                                <label for="valor_abertura" class="form-label fw-bold text-secondary">Fundo de Troco
                                    (R$)</label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bg-white border-end-0"><svg width="20" height="20" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                            </path>
                                        </svg></span>
                                    <input type="text" class="form-control border-start-0 ps-0 fw-bold text-primary"
                                        id="valor_abertura" name="valor_abertura" placeholder="0,00" required>
                                </div>
                                <div class="form-text mt-2">Informe o valor em dinheiro vivo presente na gaveta no início do
                                    turno.</div>
                            </div>
                            <button type="submit"
                                class="btn btn-success w-100 py-3 fw-bold fs-5 shadow-sm d-flex justify-content-center align-items-center gap-2">
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Abrir Caixa
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Pagamento -->
    <div class="modal fade" id="modalPagamentoPDV" tabindex="-1" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-lg); overflow: hidden;">
                <div class="modal-header border-0 bg-primary px-5 py-4">
                    <h4 class="modal-title fw-bold text-white d-flex align-items-center gap-3">
                        <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        Finalizar Cobrança
                    </h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body p-0">
                    <div class="row g-0">
                        <!-- Esquerda: Calculadora -->
                        <div class="col-lg-7 p-5 bg-light border-end">
                            <div
                                class="form-card mb-4 p-4 border-0 d-flex justify-content-between align-items-center shadow-sm">
                                <span class="text-muted fw-bold fs-5 uppercase">Total a Pagar</span>
                                <span class="fw-bold text-primary display-6 m-0" id="displayTotal">R$ 0,00</span>
                                <input type="hidden" id="totalPDV">
                                <input type="hidden" id="subtotalPDV">
                            </div>

                            <div class="mb-4">
                                <label for="dinheiroPDV" class="form-label fw-bold text-success fs-5 mb-3">Valor recebido em
                                    Dinheiro Físico</label>
                                <div class="input-group input-group-lg shadow-sm w-100"
                                    style="border-radius: var(--radius-md); overflow: hidden;">
                                    <span
                                        class="input-group-text bg-white border-0 fw-bold fs-4 text-success ps-4">R$</span>
                                    <input type="number" id="dinheiroPDV"
                                        class="form-control border-0 fw-bold text-end text-success" value="0"
                                        style="font-size: 2rem; border-radius: 0;" oninput="calcularTrocoPDV()">
                                    <button class="btn btn-white bg-white border-0 text-danger px-4" type="button"
                                        onclick="resetarDinheiro()" title="Zerar"
                                        style="border-left: 1px solid var(--border-color)!important;">
                                        <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-4">
                                <p class="text-muted fw-bold mb-2 small text-uppercase">Notas Rápidas (Soma)</p>
                                <div class="d-flex flex-wrap gap-2">
                                    <button
                                        class="btn btn-outline-success fw-bold flex-grow-1 py-3 border-2 text-dark border-success-subtle bg-white hover-bg-success-subtle"
                                        onclick="adicionarValorPDV(2)">2</button>
                                    <button
                                        class="btn btn-outline-success fw-bold flex-grow-1 py-3 border-2 text-dark border-success-subtle bg-white hover-bg-success-subtle"
                                        onclick="adicionarValorPDV(5)">5</button>
                                    <button
                                        class="btn btn-outline-success fw-bold flex-grow-1 py-3 border-2 text-dark border-success-subtle bg-white hover-bg-success-subtle"
                                        onclick="adicionarValorPDV(10)">10</button>
                                    <button
                                        class="btn btn-outline-success fw-bold flex-grow-1 py-3 border-2 text-dark border-success-subtle bg-white hover-bg-success-subtle"
                                        onclick="adicionarValorPDV(20)">20</button>
                                    <button
                                        class="btn btn-outline-success fw-bold flex-grow-1 py-3 border-2 text-dark border-success-subtle bg-white hover-bg-success-subtle"
                                        onclick="adicionarValorPDV(50)">50</button>
                                    <button
                                        class="btn btn-outline-success fw-bold flex-grow-1 py-3 border-2 text-dark border-success-subtle bg-white hover-bg-success-subtle"
                                        onclick="adicionarValorPDV(100)">100</button>
                                </div>
                            </div>

                            <div
                                class="form-card border-0 d-flex justify-content-between align-items-center bg-white shadow-sm p-4">
                                <span class="fw-bold text-dark fs-5">Troco para devolver</span>
                                <input type="text" id="trocoPDV"
                                    class="form-control-plaintext text-end fw-bold text-danger m-0 p-0"
                                    style="font-size: 2rem;" value="0,00" readonly>
                            </div>
                        </div>

                        <!-- Direita: Formas de Pagamento -->
                        <div class="col-lg-5 p-5 bg-white d-flex flex-column justify-content-center">
                            <h6 class="text-secondary fw-bold text-uppercase mb-4 small text-center">Registrar pagamento em
                            </h6>

                            <div class="d-flex flex-column gap-3">
                                <button
                                    class="btn btn-success py-4 fs-5 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-3 border-0 transition-hover"
                                    onclick="finalizarPagamentoPDV('DINHEIRO')">
                                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                        </path>
                                    </svg>
                                    Pagou em Dinheiro
                                </button>

                                <button
                                    class="btn text-white py-4 fs-5 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-3 border-0 transition-hover"
                                    style="background-color: #0ea5e9;" onclick="finalizarPagamentoPDV('DÉBITO')">
                                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                        </path>
                                    </svg>
                                    Cartão de Débito
                                </button>

                                <button
                                    class="btn btn-primary py-4 fs-5 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-3 border-0 transition-hover"
                                    onclick="finalizarPagamentoPDV('CRÉDITO')">
                                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                        </path>
                                    </svg>
                                    Cartão de Crédito
                                </button>

                                <button
                                    class="btn btn-warning text-dark py-4 fs-5 fw-bold shadow-sm d-flex justify-content-center align-items-center gap-3 border-0 transition-hover"
                                    onclick="finalizarPagamentoPDV('PIX')">
                                    <svg width="28" height="28" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Recebido no PIX
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Estilos extra específicos do PDV que complementam o estilo master */
        .transition-hover {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .transition-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        .hover-bg-success-subtle:hover {
            background-color: #d1fae5 !important;
            border-color: #10b981 !important;
        }

        /* Scrollbar bonita para Firefox e Chrome */
        .column-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .column-scroll::-webkit-scrollbar-track {
            background: transparent;
        }

        .column-scroll::-webkit-scrollbar-thumb {
            background-color: var(--border-color);
            border-radius: 10px;
        }
    </style>

    <!-- Scripts (SweetAlert, Chart etc - mantendo a logica original adaptada) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        const statusCaixa = '{{ $caixaStatus }}';
        let carrinho = [];

        // Formatação do Fundo de Troco
        const inputAbertura = document.getElementById('valor_abertura');
        if (inputAbertura) {
            inputAbertura.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\D/g, "");
                value = (value / 100).toFixed(2) + "";
                value = value.replace(".", ",");
                value = value.replace(/(\d)(\d{3})(\d{3}),/g, "$1.$2.$3,");
                value = value.replace(/(\d)(\d{3}),/g, "$1.$2,");
                e.target.value = value;
            });
        }

        window.addEventListener('beforeunload', function (e) {
            if (carrinho.length > 0) {
                e.preventDefault();
                e.returnValue = '';
            }
        });

        document.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href && href !== '#' && !href.startsWith('javascript') && !href.startsWith('#modal') && carrinho.length > 0 && !this.hasAttribute('data-bs-toggle')) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Esvaziar Carrinho?',
                        text: "Você tem itens no carrinho. Se sair desta página, a venda atual será perdida.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sim, sair e perder venda',
                        cancelButtonText: 'Ficar aqui',
                        heightAuto: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = href;
                        }
                    });
                }
            });
        });

        function confirmarFechamento() {
            Swal.fire({
                title: 'Fechar o Caixa?',
                text: "Tem certeza que deseja encerrar o fluxo de vendas do caixa agora?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim, Encerrar Caixa!',
                cancelButtonText: 'Voltar',
                heightAuto: false
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('formFecharCaixa').submit();
                }
            })
        }

        function alterarQtd(id, valor) {
            const input = document.getElementById(id);
            let qtd = parseInt(input.value, 10) + valor;
            if (isNaN(qtd) || qtd < 1) qtd = 1;
            input.value = qtd;
        }

        function adicionarProduto(id, nome, qtd, preco, inputId) {
            if (statusCaixa !== 'aberto') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Caixa Fechado',
                    text: 'Abra o caixa primeiro para registrar itens.',
                    heightAuto: false,
                    confirmButtonColor: 'var(--primary-color)'
                });
                return;
            }
            qtd = parseInt(qtd, 10);
            preco = parseFloat(preco);
            if (qtd > 0 && !isNaN(preco)) {
                const index = carrinho.findIndex(item => item.id === id);
                if (index >= 0) {
                    carrinho[index].qtd += qtd;
                } else {
                    carrinho.push({ id, nome, qtd, preco });
                }
                atualizarCarrinho();
                if (inputId) document.getElementById(inputId).value = 1;

                Swal.mixin({
                    toast: true,
                    position: 'bottom-end',
                    showConfirmButton: false,
                    timer: 1500,
                    background: 'var(--bg-card)',
                    color: 'var(--text-main)'
                }).fire({
                    icon: 'success',
                    title: `Adicionado: ${nome}`
                });
            }
        }

        function atualizarCarrinho() {
            const lista = document.getElementById("carrinhoLista");
            const msgVazio = document.getElementById("emptyCartMsg");
            lista.innerHTML = "";
            let total = 0;

            if (carrinho.length === 0) {
                msgVazio.style.display = 'flex';
            } else {
                msgVazio.style.display = 'none';
                carrinho.forEach((item, i) => {
                    total += item.qtd * item.preco;
                    const li = document.createElement("li");
                    li.className = "p-3 bg-white rounded shadow-sm d-flex justify-content-between align-items-center";
                    li.style.border = "1px solid var(--border-color)";
                    li.innerHTML = `
                                                        <div class="pe-2">
                                                            <div class="fw-bold mb-1 text-dark" style="font-size: 0.95rem;">${item.nome}</div>
                                                            <div class="d-flex align-items-center gap-2">
                                                                <span class="badge badge-soft-primary px-2">${item.qtd}x</span>
                                                                <small class="text-muted">${(item.qtd * item.preco).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' })}</small>
                                                            </div>
                                                        </div>
                                                        <button class="btn btn-sm btn-light text-danger rounded-circle border-0 d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;" onclick="removerProduto(${i})">
                                                            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    `;
                    lista.appendChild(li);
                });
            }

            const totalFormatado = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
            document.getElementById("totalCarrinho").innerText = totalFormatado;
            if (document.getElementById("subtotalDisplay")) {
                document.getElementById("subtotalDisplay").innerText = totalFormatado;
            }
        }

        function removerProduto(i) {
            carrinho.splice(i, 1);
            atualizarCarrinho();
        }

        function limparCarrinho() {
            if (carrinho.length === 0) return;
            Swal.fire({
                title: 'Limpar Carrinho?',
                text: "Remover todos os itens adicionados?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sim',
                cancelButtonText: 'Não',
                heightAuto: false
            }).then((result) => {
                if (result.isConfirmed) {
                    carrinho = [];
                    atualizarCarrinho();
                }
            });
        }

        function finalizarVenda() {
            if (statusCaixa !== 'aberto') {
                Swal.fire({
                    icon: 'warning',
                    title: 'Caixa Fechado',
                    text: 'Abra o caixa primeiro para fazer a venda.',
                    heightAuto: false
                });
                return;
            }
            if (carrinho.length === 0) {
                Swal.fire({
                    icon: 'info',
                    title: 'Carrinho Vazio',
                    text: 'Adicione produtos para finalizar.',
                    heightAuto: false
                });
                return;
            }

            let total = 0;
            carrinho.forEach(item => total += item.qtd * item.preco);

            document.getElementById("subtotalPDV").value = total.toFixed(2).replace('.', ',');
            document.getElementById("totalPDV").value = total.toFixed(2).replace('.', ',');
            document.getElementById("displayTotal").innerText = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });

            document.getElementById("dinheiroPDV").value = '0';
            document.getElementById("trocoPDV").value = "0,00";

            new bootstrap.Modal(document.getElementById("modalPagamentoPDV")).show();
        }

        function calcularTrocoPDV() {
            let total = parseFloat(document.getElementById("totalPDV").value.replace(',', '.')) || 0;
            let pago = parseFloat(document.getElementById("dinheiroPDV").value) || 0;
            let troco = pago - total;
            if (troco < 0) troco = 0;
            document.getElementById("trocoPDV").value = troco.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function resetarDinheiro() {
            document.getElementById("dinheiroPDV").value = "0";
            calcularTrocoPDV();
        }

        function adicionarValorPDV(valor) {
            let dinheiroInput = document.getElementById("dinheiroPDV");
            let atual = parseFloat(dinheiroInput.value) || 0;
            let novo = (atual + valor).toFixed(2);
            dinheiroInput.value = novo;
            calcularTrocoPDV();
        }

        function finalizarPagamentoPDV(metodo) {
            let totalValor = document.getElementById("totalPDV").value;
            let totalNumerico = parseFloat(totalValor.replace(',', '.'));

            if (carrinho.length === 0) return;

            if (metodo === 'DINHEIRO') {
                let pago = parseFloat(document.getElementById("dinheiroPDV").value) || 0;
                if (pago < totalNumerico) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Valor Insuficiente',
                        text: 'O valor digitado em dinheiro é menor que o total da compra.',
                        heightAuto: false
                    });
                    return;
                }
            }

            Swal.fire({
                title: 'Confirmar Venda?',
                text: `Valor Total: R$ ${totalValor} | Forma: ${metodo}`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: 'var(--primary-color)',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Confirmar e Imprimir',
                cancelButtonText: 'Voltar',
                heightAuto: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Processando Venda...',
                        allowOutsideClick: false,
                        heightAuto: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    let dados = {
                        total: totalNumerico,
                        forma_pagamento: metodo,
                        itens: carrinho
                    };
                    const carrinhoBackup = [...carrinho];

                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    fetch("{{ route('venda.registrar') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "Accept": "application/json",
                            "X-CSRF-TOKEN": csrfToken
                        },
                        body: JSON.stringify(dados)
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.sucesso) {
                                // Limpa o carrinho diretamente (sem confirmação)
                                carrinho = [];
                                atualizarCarrinho();

                                const modalEl = document.getElementById("modalPagamentoPDV");
                                const modal = bootstrap.Modal.getInstance(modalEl);
                                if (modal) modal.hide();

                                Swal.fire({
                                    title: 'Sucesso!',
                                    text: 'A venda foi registrada corretamente no caixa.',
                                    icon: 'success',
                                    confirmButtonColor: 'var(--primary-color)',
                                    confirmButtonText: 'Fechar'
                                });

                                // Abre o cupom imediatamente
                                window.open(`/pdv/imprimir-cupom/${data.id_venda}`, 'Cupom', 'width=400,height=600');
                            } else {
                                carrinho = carrinhoBackup;
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Erro de Sistema',
                                    text: data.mensagem || 'Ocorreu um erro interno ao salvar a venda.',
                                    heightAuto: false
                                });
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            carrinho = carrinhoBackup;
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro de Conexão',
                                text: 'A conexão com o servidor falhou.',
                                heightAuto: false
                            });
                        });
                }
            });
        }

    </script>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Feito!',
                    text: "{!! session('success') !!}",
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true
                });
            });
        </script>
    @endif

@endsection