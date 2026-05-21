<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title','JEC') — Juventud en Camino</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="manifest" href="/manifest.json">
  <meta name="theme-color" content="#4f46e5">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
  <meta name="apple-mobile-web-app-title" content="JEC">
  <link rel="apple-touch-icon" href="/icons/icon-192.png">
  @stack('styles')
</head>
<body>

{{-- Topbar móvil --}}
<div class="topbar" id="topbar">
  <button class="topbar-btn" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
  <span class="topbar-brand"><i class="bi bi-box-seam me-1"></i>JEC</span>
  <div class="topbar-actions">
    <a href="{{ route('dashboard') }}" class="topbar-btn"><i class="bi bi-house"></i></a>
    <form method="POST" action="{{ route('logout') }}" style="display:inline">
      @csrf
      <button type="submit" class="topbar-btn"><i class="bi bi-box-arrow-right"></i></button>
    </form>
  </div>
</div>

<div class="overlay" id="overlay" onclick="toggleSidebar()"></div>

{{-- Sidebar --}}
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <div class="logo-wrap">
      <div class="logo-icon"><i class="bi bi-box-seam"></i></div>
      <div>
        <div class="logo-text">Juventud en Camino</div>
        <div class="logo-sub">Inventario</div>
      </div>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-label">Principal</div>
    <a href="{{ route('dashboard') }}" class="@if(Route::is('dashboard')) active @endif" onclick="closeSidebar()">
      <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('products.index') }}" class="@if(Route::is('products.*')) active @endif" onclick="closeSidebar()">
      <i class="bi bi-box"></i> Productos
    </a>
    <a href="{{ route('movements.index') }}" class="@if(Route::is('movements.*')) active @endif" onclick="closeSidebar()">
      <i class="bi bi-arrow-left-right"></i> Movimientos
    </a>

    <div class="nav-label">Gestión</div>
    <a href="{{ route('admin.requests.index') }}" class="@if(Route::is('admin.requests.*')) active @endif" onclick="closeSidebar()">
      <i class="bi bi-clipboard-check"></i> Solicitudes
      @if($pendingRequestsCount > 0)
        <span class="nav-badge">{{ $pendingRequestsCount }}</span>
      @endif
    </a>
  </nav>

  <div class="sidebar-footer">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" onclick="closeSidebar()">
        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
      </button>
    </form>
  </div>
</aside>

{{-- Contenido --}}
<main class="main" id="main">
  @foreach(['success'=>'alert-success','error'=>'alert-danger','warning'=>'alert-warning'] as $type => $class)
    @if(session($type))
      <div class="alert {{ $class }}" id="flash-alert">
        <i class="bi bi-{{ $type=='success' ? 'check-circle-fill' : ($type=='error' ? 'exclamation-triangle-fill' : 'exclamation-circle-fill') }}"></i>
        {{ session($type) }}
        <button class="alert-close" onclick="this.parentElement.remove()">×</button>
      </div>
    @endif
  @endforeach

  @yield('content')
</main>

<script>
function toggleSidebar() {
  document.getElementById('sidebar').classList.toggle('open');
  document.getElementById('overlay').classList.toggle('show');
}
function closeSidebar() {
  if (window.innerWidth < 768) {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('overlay').classList.remove('show');
  }
}
setTimeout(() => {
  const a = document.getElementById('flash-alert');
  if (a) a.style.transition = 'opacity .5s', a.style.opacity = '0', setTimeout(() => a.remove(), 500);
}, 4000);
</script>
@stack('scripts')
</body>
</html>
