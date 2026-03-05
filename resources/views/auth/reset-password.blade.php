<x-guest-layout>
    <div class="text-center mb-4">
        <h4 class="fw-bold">Redefinir Senha</h4>
        <p class="text-muted small">Crie uma nova senha para sua conta.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-medium small">E-mail</label>
            <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $request->email) }}"
                required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-danger small" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-medium small">Nova Senha</label>
            <input id="password" type="password" class="form-control" name="password" required
                autocomplete="new-password" placeholder="Nova senha">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label fw-medium small">Confirmar Nova Senha</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required
                autocomplete="new-password" placeholder="Repita a nova senha">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-danger small" />
        </div>

        <div class="d-grid gap-2">
            <button class="btn btn-primary fw-bold" type="submit">
                Redefinir Senha
            </button>
        </div>
    </form>
</x-guest-layout>