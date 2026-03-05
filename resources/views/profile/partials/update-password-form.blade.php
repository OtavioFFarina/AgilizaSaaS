<section>
    <header class="mb-4">
        <h5 class="fw-bold text-dark m-0">Atualizar Senha</h5>
        <p class="text-muted small m-0 mt-1">Certifique-se de que sua conta esteja usando uma senha longa e aleatória
            para permanecer segura.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="row g-3">
        @csrf
        @method('put')

        <div class="col-md-12">
            <label for="update_password_current_password" class="form-label fw-medium small">Senha Atual</label>
            <input id="update_password_current_password" name="current_password" type="password" class="form-control"
                autocomplete="current-password">
            @error('current_password', 'updatePassword')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12">
            <label for="update_password_password" class="form-label fw-medium small">Nova Senha</label>
            <input id="update_password_password" name="password" type="password" class="form-control"
                autocomplete="new-password">
            @error('password', 'updatePassword')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12">
            <label for="update_password_password_confirmation" class="form-label fw-medium small">Confirmar Nova
                Senha</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-12 mt-4 d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary px-4 fw-medium">Salvar Nova Senha</button>

            @if (session('status') === 'password-updated')
                <span class="text-success small fw-medium" x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)">
                    <i class='bx bx-check-circle'></i> Senha atualizada.
                </span>
            @endif
        </div>
    </form>
</section>