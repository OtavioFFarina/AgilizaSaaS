<x-guest-layout>
    <div class="text-center mb-4">
        <h4 class="fw-bold">Verifique seu E-mail</h4>
        <p class="text-muted small">
            Obrigado por se registrar! Antes de começar, por favor verifique seu endereço de e-mail clicando no link que
            acabamos de enviar para você. Se você não recebeu o e-mail, teremos o prazer de te enviar outro.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success small mb-4">
            Um novo link de verificação foi enviado para o endereço de e-mail fornecido durante o registro.
        </div>
    @endif

    <div class="d-flex flex-column gap-3 mt-4">
        <form method="POST" action="{{ route('verification.send') }}" class="w-100">
            @csrf
            <button type="submit" class="btn btn-primary w-100 fw-bold">
                Reenviar E-mail de Verificação
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="w-100 text-center">
            @csrf
            <button type="submit" class="btn btn-link text-muted text-decoration-none small">
                Sair
            </button>
        </form>
    </div>
</x-guest-layout>