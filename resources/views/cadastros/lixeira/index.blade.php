@extends('layouts.app_internal')

@section('content')
    <!-- Barra Minimalista de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 1400px;">
        <div class="d-flex align-items-center mb-4">
            <!-- O Único caminho para trás -->
            <a href="{{ route('dashboard') }}" class="btn-back">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="me-1">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
                Voltar ao Dashboard
            </a>
        </div>
    </div>

    <div class="container-fluid px-4 px-md-5 pb-5" style="max-width: 1400px;">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h1 class="page-title"><i class='bx bx-recycle text-primary me-2'></i> Lixeira Centralizada</h1>
        </div>

        <div class="mb-4">
            <div class="alert alert-light border shadow-sm d-flex align-items-center">
                <i class='bx bx-info-circle text-primary fs-3 me-3'></i>
                <span class="text-muted">Itens excluídos são mantidos por <strong class="text-dark">30 dias</strong> antes
                    de serem removidos permanentemente.</span>
            </div>
        </div>

        <div class="form-card mb-5 border-0 shadow-sm"
            style="border-radius: var(--radius-lg); padding: 2.5rem; background: var(--bg-card);">
            <ul class="nav nav-pills mb-4 d-flex gap-2 flex-nowrap overflow-auto" id="lixeiraTabs" role="tablist"
                style="padding-bottom: 5px;">
                <li class="nav-item flex-sm-grow-1 text-center" role="presentation">
                    <button class="nav-link active w-100 py-3 fw-bold border shadow-sm" id="produtos-tab"
                        data-bs-toggle="pill" data-bs-target="#produtos-pane" type="button" role="tab">
                        <i class='bx bx-package fs-5 me-1' style="transform: translateY(2px);"></i> Produtos
                        @if($produtos->count() > 0)
                            <span class="badge bg-danger ms-2 rounded-pill">{{ $produtos->count() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item flex-sm-grow-1 text-center" role="presentation">
                    <button class="nav-link w-100 py-3 fw-bold border shadow-sm" id="categorias-tab" data-bs-toggle="pill"
                        data-bs-target="#categorias-pane" type="button" role="tab"
                        style="color: var(--text-muted); background: white;">
                        <i class='bx bx-category fs-5 me-1' style="transform: translateY(2px);"></i> Categorias
                        @if($categorias->count() > 0)
                            <span class="badge bg-danger ms-2 rounded-pill">{{ $categorias->count() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item flex-sm-grow-1 text-center" role="presentation">
                    <button class="nav-link w-100 py-3 fw-bold border shadow-sm" id="fornecedores-tab" data-bs-toggle="pill"
                        data-bs-target="#fornecedores-pane" type="button" role="tab"
                        style="color: var(--text-muted); background: white;">
                        <i class='bx bx-truck fs-5 me-1' style="transform: translateY(2px);"></i> Fornecedores
                        @if($fornecedores->count() > 0)
                            <span class="badge bg-danger ms-2 rounded-pill">{{ $fornecedores->count() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item flex-sm-grow-1 text-center" role="presentation">
                    <button class="nav-link w-100 py-3 fw-bold border shadow-sm" id="estabelecimentos-tab"
                        data-bs-toggle="pill" data-bs-target="#estabelecimentos-pane" type="button" role="tab"
                        style="color: var(--text-muted); background: white;">
                        <i class='bx bx-store-alt fs-5 me-1' style="transform: translateY(2px);"></i> Estabelecimentos
                        @if($estabelecimentos->count() > 0)
                            <span class="badge bg-danger ms-2 rounded-pill">{{ $estabelecimentos->count() }}</span>
                        @endif
                    </button>
                </li>
                <li class="nav-item flex-sm-grow-1 text-center" role="presentation">
                    <button class="nav-link w-100 py-3 fw-bold border shadow-sm" id="usuarios-tab" data-bs-toggle="pill"
                        data-bs-target="#usuarios-pane" type="button" role="tab"
                        style="color: var(--text-muted); background: white;">
                        <i class='bx bx-user-circle fs-5 me-1' style="transform: translateY(2px);"></i> Usuários
                        @if($usuarios->count() > 0)
                            <span class="badge bg-danger ms-2 rounded-pill">{{ $usuarios->count() }}</span>
                        @endif
                    </button>
                </li>
            </ul>

            {{-- Tab Content --}}
            <div class="tab-content table-container p-0 border-0 bg-transparent shadow-none" id="lixeiraTabContent">

                {{-- ============== PRODUTOS ============== --}}
                <div class="tab-pane fade show active" id="produtos-pane" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table-modern mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Produto</th>
                                    <th>Categoria</th>
                                    <th>Excluído em</th>
                                    <th>Expira em</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produtos as $item)
                                    <tr>
                                        <td class="fw-bold text-muted">#{{ $item->id }}</td>
                                        <td class="fw-bold text-dark">{{ $item->nome }}</td>
                                        <td><span class="badge badge-soft-secondary">{{ $item->categoria->nome ?? '-' }}</span>
                                        </td>
                                        <td class="text-muted small">{{ $item->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @php $diasRestantes = (int) round(30 - $item->deleted_at->diffInDays(now())); @endphp
                                            <span
                                                class="badge {{ $diasRestantes <= 5 ? 'bg-danger shadow-sm' : 'badge-soft-warning text-dark' }} px-3 py-2">
                                                {{ $diasRestantes > 0 ? $diasRestantes . ' dias' : 'Expirando hoje' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <form
                                                    action="{{ route('lixeira.restaurar', ['tipo' => 'produtos', 'id' => $item->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-sm btn-light text-success border-0 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                        style="width: 32px; height: 32px;" title="Restaurar"><i
                                                            class='bx bx-undo fs-5'></i></button>
                                                </form>
                                                <button type="button"
                                                    class="btn btn-sm btn-light text-danger border-0 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                    style="width: 32px; height: 32px;" title="Excluir Permanentemente"
                                                    onclick="confirmarExclusaoPermanente('produtos', {{ $item->id }}, '{{ addslashes($item->nome) }}')">
                                                    <i class='bx bx-x-circle fs-5'></i>
                                                </button>
                                                <form id="form-force-delete-produtos-{{ $item->id }}"
                                                    action="{{ route('lixeira.forceDelete', ['tipo' => 'produtos', 'id' => $item->id]) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5 text-muted">
                                            <i class='bx bx-check-circle fs-1 opacity-25 mb-3'></i>
                                            <p class="m-0">Nenhum produto na lixeira.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ============== CATEGORIAS ============== --}}
                <div class="tab-pane fade" id="categorias-pane" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table-modern mb-0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>Excluído em</th>
                                    <th>Expira em</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categorias as $item)
                                    <tr>
                                        <td class="fw-bold text-muted">#{{ $item->id }}</td>
                                        <td class="fw-bold text-dark">{{ $item->nome }}</td>
                                        <td class="text-muted small">{{ $item->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @php $diasRestantes = (int) round(30 - $item->deleted_at->diffInDays(now())); @endphp
                                            <span
                                                class="badge {{ $diasRestantes <= 5 ? 'bg-danger shadow-sm' : 'badge-soft-warning text-dark' }} px-3 py-2">
                                                {{ $diasRestantes > 0 ? $diasRestantes . ' dias' : 'Expirando hoje' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <form
                                                    action="{{ route('lixeira.restaurar', ['tipo' => 'categorias', 'id' => $item->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-sm btn-light text-success border-0 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                        style="width: 32px; height: 32px;" title="Restaurar"><i
                                                            class='bx bx-undo fs-5'></i></button>
                                                </form>
                                                <button type="button"
                                                    class="btn btn-sm btn-light text-danger border-0 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                    style="width: 32px; height: 32px;" title="Excluir Permanentemente"
                                                    onclick="confirmarExclusaoPermanente('categorias', {{ $item->id }}, '{{ addslashes($item->nome) }}')">
                                                    <i class='bx bx-x-circle fs-5'></i>
                                                </button>
                                                <form id="form-force-delete-categorias-{{ $item->id }}"
                                                    action="{{ route('lixeira.forceDelete', ['tipo' => 'categorias', 'id' => $item->id]) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class='bx bx-check-circle fs-1 opacity-25 mb-3'></i>
                                            <p class="m-0">Nenhuma categoria na lixeira.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ============== FORNECEDORES ============== --}}
                <div class="tab-pane fade" id="fornecedores-pane" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table-modern mb-0">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>CNPJ</th>
                                    <th>Excluído em</th>
                                    <th>Expira em</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($fornecedores as $item)
                                    <tr>
                                        <td class="fw-bold text-dark">{{ $item->nome_fornecedor }}</td>
                                        <td class="text-muted">{{ $item->cnpj ?? '-' }}</td>
                                        <td class="text-muted small">{{ $item->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @php $diasRestantes = (int) round(30 - $item->deleted_at->diffInDays(now())); @endphp
                                            <span
                                                class="badge {{ $diasRestantes <= 5 ? 'bg-danger shadow-sm' : 'badge-soft-warning text-dark' }} px-3 py-2">
                                                {{ $diasRestantes > 0 ? $diasRestantes . ' dias' : 'Expirando hoje' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <form
                                                    action="{{ route('lixeira.restaurar', ['tipo' => 'fornecedores', 'id' => $item->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-sm btn-light text-success border-0 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                        style="width: 32px; height: 32px;" title="Restaurar"><i
                                                            class='bx bx-undo fs-5'></i></button>
                                                </form>
                                                <button type="button"
                                                    class="btn btn-sm btn-light text-danger border-0 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                    style="width: 32px; height: 32px;" title="Excluir Permanentemente"
                                                    onclick="confirmarExclusaoPermanente('fornecedores', {{ $item->id }}, '{{ addslashes($item->nome_fornecedor) }}')">
                                                    <i class='bx bx-x-circle fs-5'></i>
                                                </button>
                                                <form id="form-force-delete-fornecedores-{{ $item->id }}"
                                                    action="{{ route('lixeira.forceDelete', ['tipo' => 'fornecedores', 'id' => $item->id]) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class='bx bx-check-circle fs-1 opacity-25 mb-3'></i>
                                            <p class="m-0">Nenhum fornecedor na lixeira.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ============== ESTABELECIMENTOS ============== --}}
                <div class="tab-pane fade" id="estabelecimentos-pane" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table-modern mb-0">
                            <thead>
                                <tr>
                                    <th>Loja</th>
                                    <th>Cidade</th>
                                    <th>Excluído em</th>
                                    <th>Expira em</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($estabelecimentos as $item)
                                    <tr>
                                        <td class="fw-bold text-dark"><i
                                                class='bx bx-store text-primary me-2'></i>{{ $item->nome }}</td>
                                        <td class="text-muted">{{ $item->cidade ?? '-' }} - {{ $item->estado ?? '' }}</td>
                                        <td class="text-muted small">{{ $item->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @php $diasRestantes = (int) round(30 - $item->deleted_at->diffInDays(now())); @endphp
                                            <span
                                                class="badge {{ $diasRestantes <= 5 ? 'bg-danger shadow-sm' : 'badge-soft-warning text-dark' }} px-3 py-2">
                                                {{ $diasRestantes > 0 ? $diasRestantes . ' dias' : 'Expirando hoje' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <form
                                                    action="{{ route('lixeira.restaurar', ['tipo' => 'estabelecimentos', 'id' => $item->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-sm btn-light text-success border-0 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                        style="width: 32px; height: 32px;" title="Restaurar"><i
                                                            class='bx bx-undo fs-5'></i></button>
                                                </form>
                                                <button type="button"
                                                    class="btn btn-sm btn-light text-danger border-0 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                    style="width: 32px; height: 32px;" title="Excluir Permanentemente"
                                                    onclick="confirmarExclusaoPermanente('estabelecimentos', '{{ $item->id }}', '{{ addslashes($item->nome) }}')">
                                                    <i class='bx bx-x-circle fs-5'></i>
                                                </button>
                                                <form id="form-force-delete-estabelecimentos-{{ $item->id }}"
                                                    action="{{ route('lixeira.forceDelete', ['tipo' => 'estabelecimentos', 'id' => $item->id]) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class='bx bx-check-circle fs-1 opacity-25 mb-3'></i>
                                            <p class="m-0">Nenhum estabelecimento na lixeira.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- ============== USUÁRIOS ============== --}}
                <div class="tab-pane fade" id="usuarios-pane" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table-modern mb-0">
                            <thead>
                                <tr>
                                    <th>Usuário</th>
                                    <th>E-mail</th>
                                    <th>Excluído em</th>
                                    <th>Expira em</th>
                                    <th class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($usuarios as $item)
                                    <tr>
                                        <td class="fw-bold text-dark"><i
                                                class='bx bx-user text-primary me-2'></i>{{ $item->name }}</td>
                                        <td class="text-muted">{{ $item->email }}</td>
                                        <td class="text-muted small">{{ $item->deleted_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            @php $diasRestantes = (int) round(30 - $item->deleted_at->diffInDays(now())); @endphp
                                            <span
                                                class="badge {{ $diasRestantes <= 5 ? 'bg-danger shadow-sm' : 'badge-soft-warning text-dark' }} px-3 py-2">
                                                {{ $diasRestantes > 0 ? $diasRestantes . ' dias' : 'Expirando hoje' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <form
                                                    action="{{ route('lixeira.restaurar', ['tipo' => 'usuarios', 'id' => $item->id]) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit"
                                                        class="btn btn-sm btn-light text-success border-0 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                        style="width: 32px; height: 32px;" title="Restaurar"><i
                                                            class='bx bx-undo fs-5'></i></button>
                                                </form>
                                                <button type="button"
                                                    class="btn btn-sm btn-light text-danger border-0 rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                                    style="width: 32px; height: 32px;" title="Excluir Permanentemente"
                                                    onclick="confirmarExclusaoPermanente('usuarios', {{ $item->id }}, '{{ addslashes($item->name) }}')">
                                                    <i class='bx bx-x-circle fs-5'></i>
                                                </button>
                                                <form id="form-force-delete-usuarios-{{ $item->id }}"
                                                    action="{{ route('lixeira.forceDelete', ['tipo' => 'usuarios', 'id' => $item->id]) }}"
                                                    method="POST" style="display: none;">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class='bx bx-check-circle fs-1 opacity-25 mb-3'></i>
                                            <p class="m-0">Nenhum usuário na lixeira.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <style>
        /* Adjusts for active tabs styling without !important and keeping specificity */
        .nav-pills .nav-link:not(.active) {
            color: var(--text-muted);
        }

        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color) !important;
        }

        .nav-pills .nav-link {
            transition: all 0.2s ease;
        }

        .nav-pills .nav-link:hover:not(.active) {
            background-color: #f8f9fa !important;
            transform: translateY(-2px);
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmarExclusaoPermanente(tipo, id, nomeItem) {
            const fraseEsperada = `Eu estou ciente e pretendo realmente excluir o item ${nomeItem}`;

            Swal.fire({
                title: '⚠️ Exclusão Permanente!',
                html: `
                                <p class="text-muted">Essa ação é <strong class="text-danger">irreversível</strong>. O item <strong>"${nomeItem}"</strong> será apagado para sempre.</p>
                                <hr>
                                <p class="small">Para confirmar, digite exatamente a frase abaixo:</p>
                                <p class="fw-bold text-danger small" style="user-select: none;">"${fraseEsperada}"</p>
                            `,
                input: 'text',
                inputPlaceholder: 'Digite a frase de confirmação...',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bx bx-x-circle"></i> Excluir Permanentemente',
                cancelButtonText: 'Cancelar',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Você precisa digitar a frase de confirmação!';
                    }
                    if (value.trim() !== fraseEsperada) {
                        return 'A frase digitada não confere. Verifique e tente novamente.';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`form-force-delete-${tipo}-${id}`).submit();
                }
            });
        }

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Sucesso!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 1500,
                background: 'var(--bg-card)',
                color: 'var(--text-main)'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: "{{ session('error') }}"
            });
        @endif
    </script>
@endsection