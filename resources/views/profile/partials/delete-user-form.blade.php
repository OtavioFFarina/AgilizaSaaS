<section>
    <header class="mb-4">
        <h5 class="fw-bold text-danger m-0">Excluir Conta</h5>
        <p class="text-muted small m-0 mt-1">
            Depois que sua conta for excluída, todos os seus recursos e dados serão excluídos permanentemente. Antes de
            excluir sua conta, baixe todos os dados ou informações que deseja reter.
        </p>
    </header>

    <button class="btn btn-danger px-4 fw-medium" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        Excluir Conta Permanentemente
    </button>

    <!-- Moda Confirmação Exclusão -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel"
        aria-hidden="true" {{ $errors->userDeletion->isNotEmpty() ? 'data-bs-show="true"' : '' }}>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: var(--radius-lg);">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header border-bottom-0 bg-danger bg-opacity-10 p-4">
                        <h5 class="modal-title fw-bold text-danger" id="confirmUserDeletionModalLabel">Tem certeza que
                            deseja excluir sua conta?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4 pt-2">
                        <p class="text-muted small mb-4">
                            Depois que sua conta for excluída, todos os seus recursos e dados serão excluídos
                            permanentemente. Por favor, insira sua senha para confirmar que deseja excluir sua conta
                            permanentemente.
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium small sr-only">Senha</label>
                            <input id="password" name="password" type="password" class="form-control"
                                placeholder="Sua senha">
                            @error('password', 'userDeletion')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer border-top-0 px-4 pb-4">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger px-4 fw-medium">Excluir Conta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if($errors->userDeletion->isNotEmpty())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var myModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
                myModal.show();
            });
        </script>
    @endif
</section>