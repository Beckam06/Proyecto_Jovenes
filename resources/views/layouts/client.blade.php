<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Solicitudes') — Juventud en Camino</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 24px 16px;
            font-family: 'Segoe UI', sans-serif;
        }
        .client-header {
            text-align: center;
            color: white;
            margin-bottom: 24px;
        }
        .client-header h1 { font-size: 1.5rem; font-weight: 700; margin-bottom: 4px; }
        .client-header p  { opacity: 0.8; font-size: 0.9rem; margin: 0; }
        .glass-card {
            background: rgba(255,255,255,0.97);
            border-radius: 20px;
            border: none;
            box-shadow: 0 16px 40px rgba(0,0,0,0.15);
            overflow: hidden;
        }
        .glass-card .card-header {
            background: linear-gradient(135deg, #1e293b, #334155);
            padding: 1.4rem 1.8rem;
        }
        .form-control, .form-select {
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 10px 14px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.15);
        }
        .btn-primary {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            border: none; border-radius: 10px; font-weight: 600;
        }
        .btn-primary:hover { opacity: 0.92; transform: translateY(-1px); }
        .nav-client {
            display: flex; gap: 8px; justify-content: center; margin-bottom: 20px;
        }
        .nav-client a {
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            font-size: 0.9rem;
            padding: 6px 16px;
            border-radius: 50rem;
            border: 1px solid rgba(255,255,255,0.25);
            transition: all 0.2s;
        }
        .nav-client a:hover, .nav-client a.active {
            background: rgba(255,255,255,0.2);
            color: #fff;
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="client-header">
        <i class="bi bi-box-seam" style="font-size:2rem;opacity:0.9"></i>
        <h1>Juventud en Camino</h1>
        <p>Sistema de Gestión de Inventario</p>
    </div>
    <nav class="nav-client">
        <a href="{{ route('client.requests.create') }}"
           class="{{ Route::is('client.requests.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle me-1"></i>Nueva Solicitud
        </a>
        <a href="{{ route('client.requests.index') }}"
           class="{{ Route::is('client.requests.index') ? 'active' : '' }}">
            <i class="bi bi-list-check me-1"></i>Mis Solicitudes
        </a>
        <a href="{{ route('login') }}">
            <i class="bi bi-shield-lock me-1"></i>Admin
        </a>
    </nav>
    <div class="container" style="max-width:860px">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" style="border-radius:12px">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
