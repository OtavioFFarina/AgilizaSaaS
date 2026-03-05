<x-guest-layout>
    <div class="text-center mb-4">
        <h4 class="fw-bold">Esqueceu sua senha?</h4>
        <p class="text-muted small">Sem problemas. Informe seu e-mail e enviaremos um link para você redefinir sua
            senha.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 text-success small" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="form-label fw-medium small">E-mail</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required
                autofocus placeholder="seu@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
        </div>

        <div class="d-grid gap-2">
            <button class="btn btn-primary fw-bold" type="submit">
                Enviar Link de Redefinição
            </button>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-muted text-decoration-none small">
                <i class='bx bx-arrow-back'></i> Voltar para o Login
            </a>
        </div>
    </form>
</x-guest-layout>