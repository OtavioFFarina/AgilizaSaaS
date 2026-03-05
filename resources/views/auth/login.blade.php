<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Agiliza - Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('assets/img/site.webmanifest') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/css/style_login.css') }}">
</head>

<body>
    <script>
        // Força o modo claro no login conforme sua regra antiga
        localStorage.removeItem('theme');
        document.documentElement.setAttribute('data-theme', 'light');
    </script>

    <div class="login-card">
        <div class="login-header">
            <img src="{{ asset('assets/img/logoagilizasemfundo.png') }}" alt="Logo Agiliza PDV" class="login-logo">
            <h1 class="login-title">Bem-vindo!</h1>
            <p class="login-subtitle">Insira suas credenciais para acessar o SaaS</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf @if ($errors->any())
                <div class="alert alert-danger py-2 fs-6 mb-3 text-center">
                    Credenciais incorretas. Tente novamente.
                </div>
            @endif

            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bxs-user'></i></span>
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                        placeholder="Seu E-mail" required autofocus>
                </div>
            </div>

            <div class="mb-4">
                <div class="input-group">
                    <span class="input-group-text"><i class='bx bxs-lock-alt'></i></span>
                    <input type="password" class="form-control" name="password" placeholder="Sua Senha" required>
                </div>
            </div>

            <button type="submit" class="btn btn-login">
                <i class='bx bx-log-in-circle me-2'></i> Entrar no Sistema
            </button>
        </form>

        <div class="footer-text">
            &copy; {{ date('Y') }} Sistema Desenvolvido pelo Grupo Agiliza.
        </div>
    </div>
</body>

</html>