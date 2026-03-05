<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AgilizaPDV') }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicon-16x16.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/apple-touch-icon.png') }}">
    <link rel="manifest" href="{{ asset('assets/img/site.webmanifest') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Style -->
    <link href="{{ asset('css/style_master.css') }}" rel="stylesheet">

    <style>
        .guest-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-body);
            padding: 2rem;
        }

        .guest-card {
            width: 100%;
            max-width: 450px;
            background: var(--bg-card);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-hover);
            padding: 2.5rem;
        }
    </style>
</head>

<body>
    <div class="guest-container">
        <div class="guest-card">
            <div class="text-center mb-4">
                <a href="/" class="text-decoration-none d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/logoagilizasemfundo.png') }}" alt="Logo Agiliza PDV" width="45"
                        class="me-2">
                    <h3 class="m-0" style="color: var(--primary-color); font-weight: 700; letter-spacing: -0.05em;">
                        AgilizaPDV
                    </h3>
                </a>
            </div>

            @yield('content')
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>