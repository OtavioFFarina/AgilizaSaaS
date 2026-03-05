<section>
    <header class="mb-4">
        <h5 class="fw-bold text-dark m-0">Informações do Perfil</h5>
        <p class="text-muted small m-0 mt-1">Atualize as informações do perfil e o endereço de e-mail da sua conta.</p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="row g-3">
        @csrf
        @method('patch')

        <div class="col-md-12">
            <label for="name" class="form-label fw-medium small">Nome Completo</label>
            <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}"
                required autofocus autocomplete="name">
            @error('name')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="col-md-12">
            <label for="email" class="form-label fw-medium small">E-mail</label>
            <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}"
                required autocomplete="username">
            @error('email')
                <div class="text-danger small mt-1">{{ $message }}</div>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-warning small mb-1">
                        Seu endereço de e-mail não foi verificado.
                        <button form="send-verification"
                            class="btn btn-link p-0 m-0 align-baseline text-primary small fw-medium">
                            Clique aqui para reenviar o e-mail de verificação.
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="text-success small fw-medium mb-0">
                            Um novo link de verificação foi enviado para o seu e-mail.
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="col-12 mt-4 d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-primary px-4 fw-medium">Salvar Alterações</button>

            @if (session('status') === 'profile-updated')
                <span class="text-success small fw-medium" x-data="{ show: true }" x-show="show" x-transition
                    x-init="setTimeout(() => show = false, 2000)">
                    <i class='bx bx-check-circle'></i> Salvo com sucesso.
                </span>
            @endif
        </div>
    </form>
</section>