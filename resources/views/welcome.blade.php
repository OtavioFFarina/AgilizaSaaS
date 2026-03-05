<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AgilizaPDV - O Sistema Inteligente para o seu Negócio</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('assets/img/site.webmanifest') }}">

    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <link href="{{ asset('css/style_master.css') }}" rel="stylesheet">

    <style>
        body {
            background-color: var(--bg-body);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Navbar transparente/glassmorphism */
        .navbar-landing {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 1rem 0;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 800;
            color: var(--primary-color);
            letter-spacing: -0.03em;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Hero Section */
        .hero-section {
            padding: 160px 0 100px;
            text-align: center;
            background: linear-gradient(180deg, rgba(248, 249, 250, 0) 0%, rgba(70, 130, 180, 0.05) 100%);
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            letter-spacing: -0.04em;
            color: var(--text-main);
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }

        .hero-title span {
            color: var(--primary-color);
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 2.5rem;
            line-height: 1.6;
        }

        .hero-buttons .btn {
            padding: 0.875rem 2rem;
            font-size: 1.125rem;
            border-radius: 50px;
            font-weight: 600;
        }

        .btn-conhecer {
            background: white;
            color: var(--text-main);
            border: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .btn-conhecer:hover {
            background: #f3f4f6;
            color: var(--text-main);
            border-color: #d1d5db;
        }

        /* Features Section */
        .features-section {
            padding: 80px 0;
            background: var(--color-white);
        }

        .feature-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 2.5rem 2rem;
            height: 100%;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-hover);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: rgba(70, 130, 180, 0.1);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
        }

        .feature-title {
            font-weight: 700;
            font-size: 1.25rem;
            margin-bottom: 1rem;
            color: var(--text-main);
        }

        .feature-text {
            color: var(--text-muted);
            line-height: 1.6;
            margin: 0;
        }

        /* CTA Section */
        .cta-section {
            padding: 100px 0;
            background: var(--primary-color);
            color: white;
            text-align: center;
        }

        .cta-section h2 {
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
            letter-spacing: -0.02em;
            color: #ffffff !important;
        }

        .cta-section p {
            font-size: 1.25rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto 2rem;
        }

        .cta-section .btn {
            background: white;
            color: var(--primary-color);
            padding: 0.875rem 2.5rem;
            font-size: 1.125rem;
            border-radius: 50px;
            font-weight: 700;
            border: none;
            transition: transform 0.2s;
        }

        .cta-section .btn:hover {
            transform: scale(1.05);
            background: #f8f9fa;
        }

        /* Footer */
        .footer {
            padding: 3rem 0;
            background: white;
            border-top: 1px solid var(--border-color);
            text-align: center;
            margin-top: auto;
        }

        .footer p {
            color: var(--text-muted);
            margin: 0;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar-landing">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand text-decoration-none" href="/">
                <img src="{{ asset('assets/img/logoagilizasemfundo.png') }}" alt="Logo" width="90" class="me-3"
                    style="transform: translateY(-2px);">
                <span style="font-size: 2.2rem; letter-spacing: -0.04em;">AgilizaPDV</span>
            </a>

            <div>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn btn-outline-primary fw-medium px-4"
                            style="border-radius: 50px;">Acessar Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary fw-medium px-4"
                            style="border-radius: 50px; box-shadow: var(--shadow-sm);">Login</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <h1 class="hero-title">Acelere as vendas do<br>seu <span>comércio</span>.</h1>
            <p class="hero-subtitle">Um sistema completo e inteligente de PDV e gestão para modernizar o atendimento,
                controlar o estoque e alavancar o seu negócio.</p>

            <div class="hero-buttons d-flex gap-3 justify-content-center flex-column flex-sm-row">
                @if (Route::has('register'))
                    <a href="#features" class="btn btn-conhecer">
                        Conhecer Recursos
                    </a>
                @endif

            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="features-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class='bx bx-store-alt'></i>
                        </div>
                        <h3 class="feature-title">PDV Ágil & Inteligente</h3>
                        <p class="feature-text">Interface rápida e intuitiva para não deixar seu cliente esperando.
                            Lance pedidos, adicione itens extras e feche contas em segundos com nosso sistema focado em
                            conversão.</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class='bx bx-package'></i>
                        </div>
                        <h3 class="feature-title">Controle de Estoque</h3>
                        <p class="feature-text">Chega de surpresas. Saiba exatamente o que entra, o que sai e quando é
                            hora de fazer novos pedidos. Receba alertas de estoque baixo e mantenha tudo sob controle.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class='bx bx-line-chart'></i>
                        </div>
                        <h3 class="feature-title">Dashboard em Tempo Real</h3>
                        <p class="feature-text">Acompanhe as métricas que realmente importam. Visualize vendas diárias,
                            fluxo de caixa e produtos mais vendidos diretamente do seu painel gerencial a qualquer
                            momento.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section">
        <div class="container">
            <h2>Pronto para transformar sua gestão?</h2>
            <p>Junte-se a vários outros estabelecimentos que já estão inovando no atendimento com o AgilizaPDV.</p>
            @if (Route::has('register'))
                <a href="{{ route('register') }}" class="btn">Entre em contato</a>
            @else
                <a href="{{ route('login') }}" class="btn">Fazer Login no Sistema</a>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; {{ date('Y') }} AgilizaPDV. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>