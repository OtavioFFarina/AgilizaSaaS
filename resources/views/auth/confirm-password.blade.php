<x-guest-layout>
    <div class="text-center mb-4">
        <h4 class="fw-bold">Área Segura</h4>
        <p class="text-muted small">Esta é uma área segura do aplicativo. Por favor, confirme sua senha antes de
            continuar.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="form-label fw-medium small">Senha</label>
            <input id="password" type="password" class="form-control" name="password" required
                autocomplete="current-password" placeholder="Sua senha">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-danger small" />
        </div>

        <div class="d-grid gap-2 mt-4">
            <button class="btn btn-primary fw-bold" type="submit">
                Confirmar
            </button>
        </div>
    </form>
</x-guest-layout>