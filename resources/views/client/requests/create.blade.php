<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Solicitud de Productos — Juventud en Camino</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Syne:wght@700;800&display=swap" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    :root {
      --brand: #4f46e5; --brand-dark: #3730a3;
      --success: #10b981; --danger: #ef4444; --warning: #f59e0b;
      --text: #0f172a; --muted: #64748b; --border: #e2e8f0; --surface: #f8fafc;
    }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      min-height: 100vh;
      background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #0f172a 100%);
      padding: 24px 16px 48px;
    }
    /* Header */
    .page-header { text-align: center; margin-bottom: 28px; }
    .page-header .logo { width: 48px; height: 48px; background: var(--brand); border-radius: 14px; display: inline-flex; align-items: center; justify-content: center; font-size: 22px; color: white; margin-bottom: 12px; }
    .page-header h1 { font-family: 'Syne', sans-serif; font-size: 22px; font-weight: 800; color: white; margin-bottom: 4px; }
    .page-header p  { color: rgba(255,255,255,.5); font-size: 13px; }
    /* Nav */
    .top-nav { display: flex; justify-content: center; gap: 8px; margin-bottom: 24px; }
    .top-nav a { color: rgba(255,255,255,.5); text-decoration: none; font-size: 13px; padding: 6px 14px; border-radius: 50rem; border: 1px solid rgba(255,255,255,.15); transition: all .2s; }
    .top-nav a:hover, .top-nav a.active { background: rgba(255,255,255,.1); color: white; }
    /* Card */
    .card { background: white; border-radius: 20px; box-shadow: 0 20px 60px rgba(0,0,0,.3); max-width: 720px; margin: 0 auto; overflow: hidden; }
    .card-head { background: linear-gradient(135deg, #0f172a, #1e1b4b); padding: 28px 32px; }
    .card-head h2 { font-family: 'Syne', sans-serif; font-size: 20px; font-weight: 800; color: white; margin-bottom: 4px; }
    .card-head p  { color: rgba(255,255,255,.5); font-size: 13px; }
    .card-body { padding: 28px 32px; }
    /* Form elements */
    .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--text); margin-bottom: 6px; }
    .form-control, .form-select {
      width: 100%; padding: 10px 14px; border: 1.5px solid var(--border); border-radius: 10px;
      font-family: inherit; font-size: 14px; color: var(--text); background: white; outline: none;
      transition: border-color .2s, box-shadow .2s;
    }
    .form-control:focus, .form-select:focus { border-color: var(--brand); box-shadow: 0 0 0 3px rgba(79,70,229,.12); }
    .form-group { margin-bottom: 18px; }
    .form-error { font-size: 12px; color: var(--danger); margin-top: 5px; display: none; }
    .row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    @media(max-width:600px) { .row { grid-template-columns: 1fr; } .card-body, .card-head { padding: 20px; } }
    /* Toggle switch */
    .toggle-wrap { background: linear-gradient(135deg, #ede9fe, #ddd6fe); border-radius: 14px; padding: 18px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 16px; cursor: pointer; }
    .toggle-label { font-size: 13.5px; font-weight: 600; color: #3730a3; flex: 1; }
    .toggle-sub { font-size: 12px; color: #5b21b6; font-weight: 400; margin-top: 2px; }
    .switch { position: relative; width: 44px; height: 24px; flex-shrink: 0; }
    .switch input { opacity: 0; width: 0; height: 0; }
    .slider { position: absolute; inset: 0; background: #c4b5fd; border-radius: 50px; transition: .3s; cursor: pointer; }
    .slider::before { content: ''; position: absolute; width: 18px; height: 18px; background: white; border-radius: 50%; left: 3px; top: 3px; transition: .3s; }
    input:checked + .slider { background: var(--brand); }
    input:checked + .slider::before { transform: translateX(20px); }
    /* Tabs */
    .tabs { display: flex; background: var(--surface); border-radius: 10px; padding: 4px; margin-bottom: 18px; gap: 4px; }
    .tab-btn { flex: 1; padding: 9px; border-radius: 8px; border: none; background: none; font-family: inherit; font-size: 13px; font-weight: 600; color: var(--muted); cursor: pointer; transition: all .2s; }
    .tab-btn.active { background: white; color: var(--brand); box-shadow: 0 1px 4px rgba(0,0,0,.1); }
    .tab-pane { display: none; }
    .tab-pane.active { display: block; }
    /* Search product */
    .search-box { position: relative; }
    .search-box i { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
    .search-box input { padding-left: 36px; }
    .product-dropdown {
      position: absolute; top: calc(100% + 4px); left: 0; right: 0;
      background: white; border: 1.5px solid var(--border); border-radius: 12px;
      box-shadow: 0 8px 24px rgba(0,0,0,.12); z-index: 100; max-height: 200px; overflow-y: auto; display: none;
    }
    .product-item { padding: 11px 14px; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-size: 13.5px; border-bottom: 1px solid #f8fafc; transition: background .15s; }
    .product-item:last-child { border-bottom: none; }
    .product-item:hover { background: #f5f3ff; }
    .product-item .stock-badge { font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 20px; background: #dcfce7; color: #166534; }
    .product-item .stock-badge.low { background: #fef3c7; color: #92400e; }
    .product-item .stock-badge.out { background: #fee2e2; color: #991b1b; }
    .selected-product { background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 10px; padding: 12px 14px; margin-top: 8px; display: none; }
    .selected-product .sp-info { display: flex; align-items: center; justify-content: space-between; }
    .selected-product .sp-name { font-weight: 600; font-size: 13.5px; color: #166534; }
    .selected-product .sp-stock { font-size: 12px; color: #15803d; margin-top: 2px; }
    .sp-change { background: none; border: none; color: var(--brand); font-size: 12px; font-weight: 600; cursor: pointer; font-family: inherit; }
    /* Multi row */
    .multi-row { display: grid; grid-template-columns: 1fr auto auto; gap: 10px; align-items: start; background: var(--surface); border-radius: 10px; padding: 14px; margin-bottom: 10px; border: 1.5px solid var(--border); }
    .multi-row .search-box { position: relative; }
    .btn-remove { background: #fef2f2; border: 1.5px solid #fecaca; color: var(--danger); border-radius: 8px; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 15px; transition: all .2s; flex-shrink: 0; margin-top: 0; }
    .btn-remove:hover { background: #fee2e2; }
    .btn-remove:disabled { opacity: .35; cursor: not-allowed; }
    /* New product box */
    .new-product-box { background: #eff6ff; border: 1.5px dashed #93c5fd; border-radius: 14px; padding: 20px; display: none; }
    .new-product-box h4 { font-size: 14px; font-weight: 700; color: #1e40af; margin-bottom: 16px; }
    /* Stock warning */
    .stock-warn { background: #fffbeb; border-left: 3px solid var(--warning); border-radius: 0 8px 8px 0; padding: 10px 12px; font-size: 13px; color: #92400e; margin-top: 8px; display: none; }
    /* Buttons */
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; border-radius: 10px; font-family: inherit; font-size: 14px; font-weight: 600; cursor: pointer; border: none; transition: all .2s; text-decoration: none; }
    .btn-primary { background: var(--brand); color: white; box-shadow: 0 4px 14px rgba(79,70,229,.3); width: 100%; justify-content: center; padding: 13px; font-size: 15px; }
    .btn-primary:hover { background: var(--brand-dark); transform: translateY(-1px); }
    .btn-ghost { background: var(--surface); border: 1.5px solid var(--border); color: var(--muted); }
    .btn-ghost:hover { border-color: var(--brand); color: var(--brand); }
    .btn-add { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #166534; font-size: 13px; padding: 8px 14px; border-radius: 8px; }
    .btn-add:hover { background: #dcfce7; }
    .form-actions { display: flex; gap: 12px; align-items: center; margin-top: 24px; }
    .form-actions .btn-ghost { flex-shrink: 0; }
    /* House badge */
    .house-badge { background: linear-gradient(135deg, #ede9fe, #ddd6fe); border-radius: 10px; padding: 12px 16px; display: flex; align-items: center; gap: 10px; }
    .house-badge i { font-size: 20px; color: var(--brand); }
    .house-badge .hb-name { font-weight: 700; font-size: 14px; color: #3730a3; }
    .house-badge .hb-change { font-size: 12px; color: var(--brand); cursor: pointer; font-weight: 600; background: none; border: none; font-family: inherit; }
    /* Alert */
    .alert { padding: 12px 14px; border-radius: 10px; font-size: 13.5px; margin-bottom: 18px; display: flex; align-items: flex-start; gap: 10px; }
    .alert-success { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
    .alert-danger  { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
    /* PIN Modal */
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.7); backdrop-filter: blur(4px); z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 20px; }
    .modal-box { background: white; border-radius: 20px; width: 100%; max-width: 380px; overflow: hidden; box-shadow: 0 24px 64px rgba(0,0,0,.3); }
    .modal-head { background: linear-gradient(135deg, #0f172a, #1e1b4b); padding: 24px; text-align: center; }
    .modal-head i { font-size: 32px; color: #a5b4fc; display: block; margin-bottom: 8px; }
    .modal-head h3 { font-family: 'Syne', sans-serif; font-size: 18px; color: white; font-weight: 800; }
    .modal-head p  { color: rgba(255,255,255,.5); font-size: 13px; margin-top: 4px; }
    .modal-body { padding: 24px; }
    .pin-input { font-size: 22px; font-weight: 800; text-align: center; letter-spacing: 10px; }
    .modal-footer { padding: 0 24px 24px; }
    .blur-content { filter: blur(4px); pointer-events: none; user-select: none; }
    .toast { position: fixed; top: 20px; right: 20px; z-index: 2000; background: white; border-radius: 12px; padding: 14px 18px; box-shadow: 0 8px 32px rgba(0,0,0,.15); display: flex; align-items: center; gap: 10px; font-size: 14px; font-weight: 600; border-left: 4px solid var(--success); animation: slideIn .3s ease; min-width: 260px; }
    .toast.error { border-left-color: var(--danger); }
    @keyframes slideIn { from { transform: translateX(100%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
    .divider { border: none; border-top: 1.5px solid var(--border); margin: 22px 0; }
    textarea.form-control { resize: vertical; min-height: 80px; }
  </style>
</head>
<body>

{{-- Modal PIN --}}
<div class="modal-overlay" id="pinModal">
  <div class="modal-box">
    <div class="modal-head">
      <i class="bi bi-shield-lock"></i>
      <h3>Verificación de Acceso</h3>
      <p>Selecciona tu área e ingresa el PIN</p>
    </div>
    <div class="modal-body">
      <div class="form-group">
        <label class="form-label">Área / Casa</label>
        <select class="form-select" id="houseSelect">
          <option value="">— Selecciona tu área —</option>
          <option value="Casa Amarilla">🏠 Casa Amarilla</option>
          <option value="Casa Naranja">🏠 Casa Naranja</option>
          <option value="Casa Verde">🏠 Casa Verde</option>
          <option value="Estimulacion">🧠 Estimulación</option>
          <option value="Clinica">🏥 Clínica</option>
          <option value="Mantenimiento">🔧 Mantenimiento</option>
          <option value="Cocina">👨‍🍳 Cocina</option>
          <option value="Carpinteria">🪚 Carpintería</option>
          <option value="Administracion">💼 Administración</option>
        </select>
      </div>
      <div class="form-group">
        <label class="form-label">PIN de 4 dígitos</label>
        <input type="password" class="form-control pin-input" id="pinInput" maxlength="4" placeholder="• • • •">
      </div>
    </div>
    <div class="modal-footer">
      <button class="btn btn-primary" onclick="verifyPin()">
        <i class="bi bi-unlock"></i> Verificar y Entrar
      </button>
    </div>
  </div>
</div>

{{-- Contenido principal --}}
<div id="mainContent">
  <div class="page-header">
    <div class="logo"><i class="bi bi-cart-plus"></i></div>
    <h1>Juventud en Camino</h1>
    <p>Sistema de Gestión de Inventario</p>
  </div>

  <nav class="top-nav">
    <a href="{{ route('client.requests.create') }}" class="active"><i class="bi bi-plus-circle me-1"></i>Nueva Solicitud</a>
    <a href="{{ route('client.requests.index') }}" id="viewRequestsLink"><i class="bi bi-list-check me-1"></i>Mis Solicitudes</a>
    <a href="{{ route('login') }}"><i class="bi bi-shield-lock me-1"></i>Admin</a>
  </nav>

  <div class="card">
    <div class="card-head">
      <h2><i class="bi bi-clipboard-plus me-2"></i>Solicitud de Productos</h2>
      <p>Completa el formulario para enviar tu solicitud al administrador</p>
    </div>
    <div class="card-body">

      @if(session('success'))
        <div class="alert alert-success"><i class="bi bi-check-circle-fill"></i> {{ session('success') }}</div>
      @endif
      @if(session('error') || $errors->any())
        <div class="alert alert-danger">
          <i class="bi bi-exclamation-triangle-fill"></i>
          {{ session('error') ?? $errors->first() }}
        </div>
      @endif

      <form action="{{ route('client.requests.store') }}" method="POST" id="requestForm" novalidate>
        @csrf

        {{-- Toggle producto nuevo --}}
        <label class="toggle-wrap" for="isNewProduct">
          <div>
            <div class="toggle-label">¿Solicitar producto nuevo?</div>
            <div class="toggle-sub">Activa si el producto no existe en el inventario</div>
          </div>
          <label class="switch">
            <input type="checkbox" id="isNewProduct" name="is_new_product" value="1">
            <span class="slider"></span>
          </label>
        </label>

        {{-- SECCIÓN PRODUCTOS EXISTENTES --}}
        <div id="existingSection">
          {{-- Tabs --}}
          <div class="tabs">
            <button type="button" class="tab-btn active" onclick="switchTab('single', this)">
              <i class="bi bi-1-circle me-1"></i> Producto Individual
            </button>
            <button type="button" class="tab-btn" onclick="switchTab('multiple', this)">
              <i class="bi bi-list-check me-1"></i> Pedido Múltiple
            </button>
          </div>

          {{-- Tab individual --}}
          <div class="tab-pane active" id="tab-single">
            <div class="row">
              <div class="form-group">
                <label class="form-label">Producto *</label>
                <div class="search-box" style="position:relative">
                  <i class="bi bi-search"></i>
                  <input type="text" class="form-control" id="singleSearch" placeholder="Escribe el nombre del producto…" autocomplete="off">
                  <div class="product-dropdown" id="singleDropdown"></div>
                </div>
                <div class="selected-product" id="singleSelected">
                  <div class="sp-info">
                    <div>
                      <div class="sp-name" id="singleSelectedName"></div>
                      <div class="sp-stock">Stock disponible: <span id="singleSelectedStock"></span> uds.</div>
                    </div>
                    <button type="button" class="sp-change" id="singleChange"><i class="bi bi-arrow-repeat me-1"></i>Cambiar</button>
                  </div>
                  <input type="hidden" name="product_id" id="singleProductId">
                </div>
                <div class="form-error" id="err-product">Selecciona un producto.</div>
              </div>
              <div class="form-group">
                <label class="form-label">Cantidad *</label>
                <input type="number" class="form-control" name="quantity_requested" id="quantityRequested" min="1" placeholder="¿Cuántas unidades?">
                <div class="stock-warn" id="stockWarn"><i class="bi bi-exclamation-triangle me-1"></i><span id="stockMsg"></span></div>
                <div class="form-error" id="err-quantity">Ingresa una cantidad válida.</div>
              </div>
            </div>
          </div>

          {{-- Tab múltiple --}}
          <div class="tab-pane" id="tab-multiple">
            <div id="multiContainer">
              <div class="multi-row" data-index="0">
                <div>
                  <div class="search-box" style="position:relative">
                    <i class="bi bi-search"></i>
                    <input type="text" class="form-control multi-search" placeholder="Producto…" autocomplete="off">
                    <div class="product-dropdown multi-dropdown"></div>
                  </div>
                  <div class="selected-product multi-selected" style="margin-top:6px">
                    <div class="sp-info">
                      <div>
                        <div class="sp-name multi-sel-name"></div>
                        <div class="sp-stock">Stock: <span class="multi-sel-stock"></span></div>
                      </div>
                      <button type="button" class="sp-change multi-change"><i class="bi bi-arrow-repeat me-1"></i>Cambiar</button>
                    </div>
                    <input type="hidden" class="multi-product-id" name="multiple_products[0][product_id]">
                  </div>
                </div>
                <input type="number" class="form-control" name="multiple_products[0][quantity]" min="1" value="1" placeholder="Cant." style="max-width:90px">
                <button type="button" class="btn-remove" disabled><i class="bi bi-trash"></i></button>
              </div>
            </div>
            <button type="button" class="btn btn-add mt-2" id="addProductBtn">
              <i class="bi bi-plus-circle"></i> Agregar producto
            </button>
          </div>
        </div>

        {{-- SECCIÓN PRODUCTO NUEVO --}}
        <div class="new-product-box" id="newProductBox">
          <h4><i class="bi bi-plus-circle me-2"></i>Solicitar Producto Nuevo</h4>
          <div class="form-group">
            <label class="form-label">Nombre del producto *</label>
            <input type="text" class="form-control" name="new_product_name" id="newProductName" placeholder="Ej: Monitor LED 24'', Sillas ergonómicas…">
            <div class="form-error" id="err-new-name">Ingresa el nombre del producto.</div>
          </div>
          <div class="form-group">
            <label class="form-label">Descripción *</label>
            <textarea class="form-control" name="new_product_description" id="newProductDesc" placeholder="Describe las características y uso del producto…"></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Cantidad solicitada *</label>
            <input type="number" class="form-control" name="new_product_quantity" id="newProductQty" min="1" placeholder="¿Cuántas unidades necesitas?">
            <div class="form-error" id="err-new-qty">Ingresa una cantidad válida.</div>
          </div>
        </div>

        <hr class="divider">

        {{-- Info básica --}}
        <div class="row">
          <div class="form-group">
            <label class="form-label">Área / Casa solicitante</label>
            <div class="house-badge" id="houseBadge">
              <i class="bi bi-house-check"></i>
              <div>
                <div class="hb-name" id="houseDisplay">Sin seleccionar</div>
                <button type="button" class="hb-change" id="changeHouseBtn"><i class="bi bi-arrow-repeat me-1"></i>Cambiar área</button>
              </div>
            </div>
            <input type="hidden" name="receptor" id="hiddenHouse" required>
            <div class="form-error" id="err-house">Debes seleccionar tu área primero.</div>
          </div>
          <div class="form-group">
            <label class="form-label">¿Quién solicita? *</label>
            <input type="text" class="form-control" name="requester_name" id="requesterName" placeholder="Tu nombre completo">
            <div class="form-error" id="err-requester">Ingresa tu nombre.</div>
          </div>
        </div>

        <div class="form-group">
          <label class="form-label">¿Para qué lo necesitas? *</label>
          <select class="form-select" name="purpose" id="purpose">
            <option value="">Selecciona el propósito</option>
            <option value="Uso diario">Uso diario</option>
            <option value="Evento especial">Evento especial</option>
            <option value="Reemplazo">Reemplazo</option>
            <option value="Nuevo proyecto">Nuevo proyecto</option>
            <option value="Otro">Otro</option>
          </select>
          <div class="form-error" id="err-purpose">Selecciona un propósito.</div>
        </div>

        <div class="form-actions">
          <a href="{{ route('client.requests.index') }}" class="btn btn-ghost" id="viewLink">
            <i class="bi bi-list"></i> Ver solicitudes
          </a>
          <button type="submit" class="btn btn-primary" style="flex:1">
            <i class="bi bi-send"></i> Enviar Solicitud
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
// ── DATOS DE PRODUCTOS Y PINES ──
const PRODUCTS = [
  @foreach($products as $p)
  { id: "{{ $p->id }}", name: "{{ addslashes($p->name) }}", stock: {{ $p->stock }} },
  @endforeach
];

const PINS = {
  'Casa Amarilla':'2648','Casa Naranja':'1205','Casa Verde':'1698',
  'Estimulacion':'2018','Clinica':'9867','Mantenimiento':'4578',
  'Cocina':'1256','Carpinteria':'3890','Administracion':'7902'
};

let currentHouse = null;
let currentTab = 'single';
let multiCount = 1;
const MAX = 10;

// ── TOAST ──
function toast(msg, ok = true) {
  const t = document.createElement('div');
  t.className = 'toast' + (ok ? '' : ' error');
  t.innerHTML = `<i class="bi bi-${ok?'check-circle-fill':'exclamation-triangle-fill'}" style="color:${ok?'#10b981':'#ef4444'}"></i> ${msg}`;
  document.body.appendChild(t);
  setTimeout(() => t.remove(), 3500);
}

// ── PIN ──
function verifyPin() {
  const house = document.getElementById('houseSelect').value;
  const pin   = document.getElementById('pinInput').value;
  if (!house) return toast('Selecciona tu área primero', false);
  if (pin.length !== 4) return toast('El PIN debe tener 4 dígitos', false);
  if (PINS[house] !== pin) {
    toast('PIN incorrecto para ' + house, false);
    document.getElementById('pinInput').value = '';
    return;
  }
  setHouse(house);
  document.getElementById('pinModal').style.display = 'none';
  document.getElementById('mainContent').classList.remove('blur-content');
  toast('Acceso concedido — ' + house);
}

function setHouse(house) {
  currentHouse = house;
  document.getElementById('houseDisplay').textContent = house;
  document.getElementById('hiddenHouse').value = house;
  document.getElementById('viewLink').href = "{{ route('client.requests.index') }}?house=" + encodeURIComponent(house);
  document.getElementById('viewRequestsLink').href = "{{ route('client.requests.index') }}?house=" + encodeURIComponent(house);
}

document.getElementById('changeHouseBtn').onclick = () => {
  document.getElementById('pinInput').value = '';
  document.getElementById('pinModal').style.display = 'flex';
  document.getElementById('mainContent').classList.add('blur-content');
};

document.getElementById('pinInput').addEventListener('keypress', e => {
  if (e.key === 'Enter') verifyPin();
});

// ── TABS ──
function switchTab(tab, btn) {
  currentTab = tab;
  document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById('tab-' + tab).classList.add('active');
}

// ── TOGGLE NUEVO PRODUCTO ──
document.getElementById('isNewProduct').addEventListener('change', function() {
  document.getElementById('existingSection').style.display = this.checked ? 'none' : 'block';
  document.getElementById('newProductBox').style.display = this.checked ? 'block' : 'none';
});

// ── BÚSQUEDA DE PRODUCTOS ──
function renderDropdown(items, dropdown, onSelect) {
  dropdown.innerHTML = '';
  if (!items.length) {
    dropdown.innerHTML = '<div class="product-item" style="color:#94a3b8">Sin resultados</div>';
  } else {
    items.forEach(p => {
      const el = document.createElement('div');
      el.className = 'product-item';
      const cls = p.stock <= 0 ? 'out' : p.stock < 10 ? 'low' : '';
      el.innerHTML = `<span>${p.name}</span><span class="stock-badge ${cls}">${p.stock} uds.</span>`;
      el.onclick = () => onSelect(p);
      dropdown.appendChild(el);
    });
  }
  dropdown.style.display = 'block';
}

function filterProducts(term) {
  return PRODUCTS.filter(p => p.name.toLowerCase().includes(term.toLowerCase()));
}

// Single
const singleSearch   = document.getElementById('singleSearch');
const singleDropdown = document.getElementById('singleDropdown');
const singleSelected = document.getElementById('singleSelected');

singleSearch.addEventListener('input', function() {
  renderDropdown(filterProducts(this.value), singleDropdown, selectSingle);
});
singleSearch.addEventListener('focus', function() {
  renderDropdown(filterProducts(this.value), singleDropdown, selectSingle);
});

function selectSingle(p) {
  document.getElementById('singleSelectedName').textContent  = p.name;
  document.getElementById('singleSelectedStock').textContent = p.stock;
  document.getElementById('singleProductId').value = p.id;
  singleSelected.style.display = 'block';
  singleDropdown.style.display = 'none';
  singleSearch.value = '';
  checkStock();
}

document.getElementById('singleChange').onclick = () => {
  singleSelected.style.display = 'none';
  document.getElementById('singleProductId').value = '';
  singleSearch.focus();
};

function checkStock() {
  const pid = document.getElementById('singleProductId').value;
  const qty = parseInt(document.getElementById('quantityRequested').value) || 0;
  const warn = document.getElementById('stockWarn');
  if (!pid) return;
  const p = PRODUCTS.find(x => x.id == pid);
  if (p && qty > p.stock) {
    document.getElementById('stockMsg').textContent = `Solo hay ${p.stock} unidades. Se aprobará parcialmente.`;
    warn.style.display = 'block';
  } else {
    warn.style.display = 'none';
  }
}
document.getElementById('quantityRequested').addEventListener('input', checkStock);

// Multiple
function initMultiRow(row, index) {
  const search   = row.querySelector('.multi-search');
  const dropdown = row.querySelector('.multi-dropdown');
  const selected = row.querySelector('.multi-selected');
  const change   = row.querySelector('.multi-change');
  const pidInput = row.querySelector('.multi-product-id');

  search.addEventListener('input',  () => renderDropdown(filterProducts(search.value), dropdown, sel));
  search.addEventListener('focus',  () => renderDropdown(filterProducts(search.value), dropdown, sel));
  change.onclick = () => { selected.style.display='none'; pidInput.value=''; search.focus(); };

  function sel(p) {
    row.querySelector('.multi-sel-name').textContent  = p.name;
    row.querySelector('.multi-sel-stock').textContent = p.stock;
    pidInput.value = p.id;
    selected.style.display = 'block';
    dropdown.style.display = 'none';
    search.value = '';
  }

  const removeBtn = row.querySelector('.btn-remove');
  removeBtn.onclick = () => {
    row.remove();
    renumber();
    updateRemoveBtns();
  };
}

function renumber() {
  document.querySelectorAll('#multiContainer .multi-row').forEach((row, i) => {
    row.querySelector('.multi-product-id').name = `multiple_products[${i}][product_id]`;
    row.querySelector('input[type="number"]').name = `multiple_products[${i}][quantity]`;
  });
}

function updateRemoveBtns() {
  const rows = document.querySelectorAll('#multiContainer .multi-row');
  rows.forEach(r => r.querySelector('.btn-remove').disabled = rows.length === 1);
}

initMultiRow(document.querySelector('.multi-row'), 0);

document.getElementById('addProductBtn').onclick = () => {
  if (multiCount >= MAX) return toast(`Máximo ${MAX} productos`, false);
  const tpl = document.querySelector('.multi-row').cloneNode(true);
  tpl.querySelector('.multi-search').value = '';
  tpl.querySelector('.multi-product-id').value = '';
  tpl.querySelector('.multi-sel-name').textContent = '';
  tpl.querySelector('.multi-sel-stock').textContent = '';
  tpl.querySelector('.multi-selected').style.display = 'none';
  tpl.querySelector('.multi-dropdown').style.display = 'none';
  tpl.querySelector('input[type="number"]').value = 1;
  document.getElementById('multiContainer').appendChild(tpl);
  multiCount++;
  renumber();
  updateRemoveBtns();
  initMultiRow(tpl, multiCount - 1);
};

// ── CERRAR DROPDOWNS AL HACER CLIC FUERA ──
document.addEventListener('click', e => {
  if (!e.target.closest('.search-box')) {
    document.querySelectorAll('.product-dropdown').forEach(d => d.style.display = 'none');
  }
});

// ── VALIDACIÓN Y ENVÍO ──
document.getElementById('requestForm').addEventListener('submit', function(e) {
  let ok = true;
  document.querySelectorAll('.form-error').forEach(el => el.style.display = 'none');

  if (!currentHouse) {
    document.getElementById('err-house').style.display = 'block';
    ok = false;
  }
  if (!document.getElementById('requesterName').value.trim()) {
    document.getElementById('err-requester').style.display = 'block';
    ok = false;
  }
  if (!document.getElementById('purpose').value) {
    document.getElementById('err-purpose').style.display = 'block';
    ok = false;
  }

  const isNew = document.getElementById('isNewProduct').checked;
  if (isNew) {
    if (!document.getElementById('newProductName').value.trim()) {
      document.getElementById('err-new-name').style.display = 'block'; ok = false;
    }
    if (!document.getElementById('newProductQty').value || document.getElementById('newProductQty').value < 1) {
      document.getElementById('err-new-qty').style.display = 'block'; ok = false;
    }
  } else if (currentTab === 'single') {
    if (!document.getElementById('singleProductId').value) {
      document.getElementById('err-product').style.display = 'block'; ok = false;
    }
    if (!document.getElementById('quantityRequested').value || document.getElementById('quantityRequested').value < 1) {
      document.getElementById('err-quantity').style.display = 'block'; ok = false;
    }
  }

  if (!ok) { e.preventDefault(); toast('Corrige los errores antes de enviar', false); }
});

// ── INICIO ──
document.getElementById('mainContent').classList.add('blur-content');
document.getElementById('pinModal').style.display = 'flex';
</script>
</body>
</html>
