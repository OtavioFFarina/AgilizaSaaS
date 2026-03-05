<x-guest-layout>
    <div class="text-center mb-4">
        <h4 class="fw-bold">Criar Conta</h4>
        <p class="text-muted small">Preencha os dados abaixo para se cadastrar.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label fw-medium small">Nome Completo</label>
            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus
                autocomplete="name" placeholder="Ex: João da Silva">
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-danger small" />
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-medium small">E-mail</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required
                autocomplete="username" placeholder="seu@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-medium small">Senha</label>
            <input id="password" type="password" class="form-control" name="password" required
                autocomplete="new-password" placeholder="Mínimo 8 caracteres">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-medium small">Confirmar Senha</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password" placeholder="Repita sua senha">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger small" />
        </div>

        <div class="d-grid gap-2 mb-3">
            <button class="btn btn-primary fw-bold" type="submit">
                Registrar
            </button>
        </div>

        <div class="text-center mt-3">
            <span class="text-muted small">Já possui uma conta?</span>
            <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-medium small">Faça Login</a>
        </div>
    </form>
</x-guest-layout>