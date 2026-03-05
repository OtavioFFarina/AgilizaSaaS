@extends('layouts.app')

@section('content')
    <!-- Barra Minimalista de Voltar -->
    <div class="container-fluid px-4 px-md-5 pt-4 pb-0" style="max-width: 1200px;">
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

    <div class="container-fluid px-4 px-md-5 pb-5" style="max-width: 1200px;">

        <div class="d-flex justify-content-between align-items-end mb-4">
            <h1 class="page-title"><i class='bx bx-user-circle text-primary me-2'></i> Meu Perfil</h1>
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-8 mx-auto">

                <div class="form-card mb-4 border-0">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <div class="form-card mb-4 border-0">
                    @include('profile.partials.update-password-form')
                </div>

                <div class="form-card mb-4 border-0">
                    @include('profile.partials.delete-user-form')
                </div>

            </div>
        </div>
    </div>
@endsection