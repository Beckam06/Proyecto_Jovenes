<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Acceso — Juventud en Camino</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh; display: flex;
    }
    /* Panel izquierdo: foto */
    .login-photo {
      flex: 1;
      background: url('/images/fondo-login.jpg') center center / cover no-repeat;
      position: relative; min-height: 280px;
    }
    .login-photo::after {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(15,23,42,.75) 0%, rgba(79,70,229,.5) 100%);
    }
    .login-photo-content {
      position: relative; z-index: 1;
      padding: 40px; height: 100%;
      display: flex; flex-direction: column; justify-content: flex-end;
    }
    .login-photo-content h2 {
      font-family: 'Syne', sans-serif;
      font-size: clamp(22px, 3vw, 36px);
      font-weight: 800; color: white; line-height: 1.2;
      margin-bottom: 10px;
    }
    .login-photo-content p { color: rgba(255,255,255,.75); font-size: 14px; line-height: 1.6; }

    /* Panel derecho: form */
    .login-form-side {
      width: 440px; flex-shrink: 0;
      background: white; display: flex;
      flex-direction: column; justify-content: center;
      padding: 48px 40px; overflow-y: auto;
    }
    .login-logo {
      width: 44px; height: 44px; background: #4f46e5;
      border-radius: 12px; display: flex; align-items: center;
      justify-content: center; font-size: 20px; color: white;
      margin-bottom: 24px;
    }
    .login-title { font-family: 'Syne', sans-serif; font-size: 26px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
    .login-sub { font-size: 13.5px; color: #64748b; margin-bottom: 32px; }

    .form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
    .input-wrap { position: relative; margin-bottom: 18px; }
    .input-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 16px; pointer-events: none; }
    .form-input {
      width: 100%; padding: 11px 14px 11px 42px;
      border: 1.5px solid #e5e7eb; border-radius: 10px;
      font-family: inherit; font-size: 14px; color: #111827;
      outline: none; transition: border-color .2s, box-shadow .2s;
    }
    .form-input:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,.12); }

    .alert-error {
      background: #fef2f2; border: 1px solid #fecaca;
      color: #991b1b; border-radius: 10px;
      padding: 10px 14px; font-size: 13px;
      display: flex; align-items: center; gap: 8px;
      margin-bottom: 20px;
    }
    .btn-login {
      width: 100%; padding: 12px;
      background: #4f46e5; color: white; border: none;
      border-radius: 10px; font-family: inherit;
      font-size: 14px; font-weight: 700; cursor: pointer;
      transition: all .2s; box-shadow: 0 4px 14px rgba(79,70,229,.35);
    }
    .btn-login:hover { background: #3730a3; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(79,70,229,.45); }

    .divider { display: flex; align-items: center; gap: 12px; margin: 22px 0; color: #9ca3af; font-size: 12px; }
    .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #f3f4f6; }

    .btn-request {
      width: 100%; padding: 11px;
      background: white; border: 1.5px solid #e5e7eb;
      border-radius: 10px; font-family: inherit;
      font-size: 14px; font-weight: 600; color: #374151;
      cursor: pointer; transition: all .2s;
      display: flex; align-items: center; justify-content: center; gap: 8px;
      text-decoration: none;
    }
    .btn-request:hover { border-color: #f97316; color: #f97316; background: #fff7ed; transform: translateY(-1px); }

    @media (max-width: 768px) {
      body { flex-direction: column; }
      .login-photo { min-height: 220px; flex: none; }
      .login-photo-content { padding: 24px; }
      .login-form-side { width: 100%; padding: 32px 24px; }
    }
  </style>
</head>
<body>
  <div class="login-photo">
    <div class="login-photo-content">
      <h2>Sistema de Gestión de Inventario</h2>
      <p>Control eficiente de productos, movimientos y solicitudes para Juventud en Camino.</p>
    </div>
  </div>

  <div class="login-form-side">
    <div class="login-logo"><i class="bi bi-box-seam"></i></div>
    <h1 class="login-title">Bienvenido</h1>
    <p class="login-sub">Ingresa tus credenciales para continuar</p>

    @if($errors->any())
      <div class="alert-error">
        <i class="bi bi-exclamation-triangle-fill"></i>
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
      @csrf
      <label class="form-label">Correo electrónico</label>
      <div class="input-wrap">
        <i class="bi bi-envelope input-icon"></i>
        <input type="email" name="email" class="form-input"
               value="{{ old('email') }}" placeholder="usuario@ejemplo.com" required autofocus>
      </div>
      <label class="form-label">Contraseña</label>
      <div class="input-wrap">
        <i class="bi bi-lock input-icon"></i>
        <input type="password" name="password" class="form-input"
               placeholder="Tu contraseña" required>
      </div>
      <button type="submit" class="btn-login">
        <i class="bi bi-box-arrow-in-right me-1"></i> Acceder al Sistema
      </button>
    </form>

    <div class="divider">o</div>

    <a href="{{ route('client.requests.create') }}" class="btn-request">
      <i class="bi bi-clipboard-plus"></i> Realizar una Solicitud
    </a>
  </div>
</body>
</html>
