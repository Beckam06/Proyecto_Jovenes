@extends('layouts.client')

@section('title', 'Acceso de Solicitantes')

@section('content')
<div class="glass-card">
    <div class="card-header">
        <h5 class="text-white fw-bold mb-0"><i class="bi bi-person-badge me-2"></i>Verificación de acceso</h5>
    </div>
    <div class="card-body p-4">
        @if($errors->any())
            <div class="alert alert-danger"><i class="bi bi-exclamation-triangle me-2"></i>{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('client.auth.login') ?? '#' }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">PIN de acceso</label>
                <input type="password" class="form-control" name="pin" placeholder="Ingresa tu PIN" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-arrow-right-circle me-2"></i>Continuar
            </button>
        </form>
    </div>
</div>
@endsection
