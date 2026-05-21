@extends('layouts.app')
@section('title', 'Solicitudes')
@section('content')

<div class="page-header">
  <div>
    <h1 class="page-title">Solicitudes</h1>
    <p class="page-subtitle">Gestión de solicitudes de productos</p>
  </div>
</div>

<div class="card">
  @if($requests->count())
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Producto</th>
          <th>Solicitante / Área</th>
          <th>Solicitado</th>
          <th>Stock actual</th>
          <th>Estado</th>
          <th class="hide-mobile">Fecha</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @php $start = ($requests->currentPage()-1)*$requests->perPage()+1; @endphp
        @foreach($requests as $i => $req)
        @php
          $stock      = $req->product ? $req->product->stock : 0;
          $needed     = $req->quantity_requested;
          $hayStock   = $req->product && $stock >= $needed;
          $processed  = in_array($req->status, ['aprobado','completado','rechazado']);
        @endphp
        <tr>
          <td class="text-muted text-sm">{{ $start+$i }}</td>

          <td>
            @if($req->product)
              <div class="flex-center gap-2">
                <div class="product-avatar"><i class="bi bi-box-seam"></i></div>
                <span class="fw-semibold" style="font-size:13.5px">{{ $req->product->name }}</span>
              </div>
            @else
              <div class="flex-center gap-2">
                <div class="product-avatar" style="background:#eff6ff;color:#3b82f6">
                  <i class="bi bi-stars"></i>
                </div>
                <div>
                  <div class="fw-semibold" style="font-size:13.5px;color:#1e40af">{{ $req->new_product_name }}</div>
                  <div class="text-sm" style="color:#93c5fd">Producto nuevo</div>
                </div>
              </div>
            @endif
          </td>

          <td>
            <div class="fw-semibold" style="font-size:13px">{{ $req->requester_name }}</div>
            <div class="text-sm text-muted">{{ $req->receptor }}</div>
          </td>

          <td>
            <span class="badge badge-gray" style="font-size:12px">{{ $needed }} uds.</span>
            @if($req->quantity_pending > 0)
              <div class="text-sm" style="color:#f59e0b;margin-top:3px">
                <i class="bi bi-hourglass-split"></i> Pendiente: {{ $req->quantity_pending }}
              </div>
            @endif
          </td>

          {{-- Stock actual con semáforo visual --}}
          <td>
            @if($processed)
              <span class="text-muted text-sm">—</span>
            @elseif(!$req->product)
              <span class="badge badge-gray">Sin producto</span>
            @elseif($stock === 0)
              <span class="badge badge-red"><i class="bi bi-x-circle me-1"></i>Sin stock</span>
            @elseif($stock < $needed)
              <span class="badge badge-amber"><i class="bi bi-exclamation-triangle me-1"></i>{{ $stock }} uds.</span>
            @else
              <span class="badge badge-green"><i class="bi bi-check-circle me-1"></i>{{ $stock }} uds.</span>
            @endif
          </td>

          <td>
            @php
              $map = [
                'pendiente'             => ['badge-amber',  'Pendiente'],
                'en_revision'           => ['badge-blue',   'En revisión'],
                'producto_creado'       => ['badge-purple', 'Prod. creado'],
                'aprobado'              => ['badge-green',  'Aprobado'],
                'parcialmente_aprobado' => ['badge-blue',   'Parcial'],
                'completado'            => ['badge-green',  'Completado'],
                'rechazado'             => ['badge-red',    'Rechazado'],
              ];
              [$cls, $lbl] = $map[strtolower($req->status)] ?? ['badge-gray', $req->status];
            @endphp
            <span class="badge {{ $cls }}">{{ $lbl }}</span>
          </td>

          <td class="hide-mobile text-muted text-sm">{{ $req->created_at->format('d/m/Y H:i') }}</td>

<td>
            <div style="display:flex;flex-direction:column;gap:6px;min-width:160px">

              {{-- ══ PENDIENTE ══ --}}
              @if($req->status === 'pendiente')
                <form method="POST" action="{{ route('admin.requests.review', $req->id) }}">
                  @csrf
                  <button class="btn btn-sm" style="background:#eff6ff;color:#1e40af;border:1.5px solid #bfdbfe;width:100%">
                    <i class="bi bi-eye"></i> Revisar
                  </button>
                </form>
                <form method="POST" action="{{ route('admin.requests.reject', $req->id) }}"
                      onsubmit="return confirm('¿Rechazar?')">
                  @csrf
                  <button class="btn btn-sm" style="background:#fef2f2;color:#ef4444;border:1.5px solid #fecaca;width:100%">
                    <i class="bi bi-x-circle"></i> Rechazar
                  </button>
                </form>

              {{-- ══ EN REVISIÓN ══ --}}
              @elseif($req->status === 'en_revision')
                @if($req->is_new_product && !$req->product_id)
                  <form method="POST" action="{{ route('admin.requests.create-product', $req->id) }}"
                        onsubmit="return confirm('¿Crear este producto con stock 0?')">
                    @csrf
                    <button class="btn btn-sm" style="background:#fffbeb;color:#92400e;border:1.5px solid #fde68a;width:100%">
                      <i class="bi bi-plus-circle"></i> Crear producto
                    </button>
                  </form>
                  <div style="font-size:11px;color:#92400e;background:#fffbeb;padding:6px 8px;border-radius:8px;border:1px solid #fde68a;line-height:1.4">
                    <i class="bi bi-info-circle"></i> Crea el producto, agrega stock y luego aprueba
                  </div>
                @elseif($stock === 0)
                  {{-- Sin stock: bloquear totalmente --}}
                  <div style="font-size:11px;color:#991b1b;background:#fef2f2;padding:8px 10px;border-radius:8px;border:1px solid #fecaca;line-height:1.5">
                    <i class="bi bi-lock-fill"></i> <strong>Sin stock</strong><br>
                    Agrega inventario primero
                  </div>
                  <a href="{{ route('movements.create', ['product' => $req->product?->id]) }}"
                     class="btn btn-sm" style="background:#fffbeb;color:#92400e;border:1.5px solid #fde68a;width:100%">
                    <i class="bi bi-plus-lg"></i> Agregar stock
                  </a>
                @else
                  {{-- Hay stock (completo o parcial) → mostrar botón aprobar --}}
                  @if($stock < $needed)
                    <div style="font-size:11px;color:#92400e;background:#fffbeb;padding:6px 8px;border-radius:8px;border:1px solid #fde68a;line-height:1.4">
                      <i class="bi bi-exclamation-triangle"></i> Stock parcial ({{ $stock }}/{{ $needed }})<br>
                      Se entregarán {{ $stock }} y quedarán {{ $needed - $stock }} pendientes
                    </div>
                  @endif
                  <form method="POST" action="{{ route('admin.requests.approve', $req->id) }}"
                        onsubmit="return confirm('{{ $stock >= $needed ? '¿Aprobar y entregar '.$needed.' unidades?' : '¿Aprobar parcialmente? Se entregarán '.$stock.' de '.$needed.' unidades. El resto quedará pendiente.' }}')">
                    @csrf
                    <button class="btn btn-sm" style="background:#f0fdf4;color:#166534;border:1.5px solid #bbf7d0;width:100%">
                      <i class="bi bi-check-circle"></i>
                      {{ $stock >= $needed ? 'Aprobar' : 'Aprobar parcial ('.$stock.' uds.)' }}
                    </button>
                  </form>
                  <form method="POST" action="{{ route('admin.requests.reject', $req->id) }}"
                        onsubmit="return confirm('¿Rechazar?')">
                    @csrf
                    <button class="btn btn-sm" style="background:#fef2f2;color:#ef4444;border:1.5px solid #fecaca;width:100%">
                      <i class="bi bi-x-circle"></i> Rechazar
                    </button>
                  </form>
                @endif

              {{-- ══ PRODUCTO CREADO ══ --}}
              @elseif($req->status === 'producto_creado')
                @if($stock === 0)
                  <div style="font-size:11px;color:#991b1b;background:#fef2f2;padding:8px 10px;border-radius:8px;border:1px solid #fecaca;line-height:1.5">
                    <i class="bi bi-lock-fill"></i> <strong>Sin stock</strong><br>
                    Agrega inventario primero
                  </div>
                  <a href="{{ route('movements.create', ['product' => $req->product?->id]) }}"
                     class="btn btn-sm" style="background:#fffbeb;color:#92400e;border:1.5px solid #fde68a;width:100%">
                    <i class="bi bi-plus-lg"></i> Agregar stock
                  </a>
                @else
                  @if($stock < $needed)
                    <div style="font-size:11px;color:#92400e;background:#fffbeb;padding:6px 8px;border-radius:8px;border:1px solid #fde68a;line-height:1.4">
                      <i class="bi bi-exclamation-triangle"></i> Stock parcial ({{ $stock }}/{{ $needed }})<br>
                      Se entregarán {{ $stock }}, quedan {{ $needed - $stock }} pendientes
                    </div>
                  @endif
                  <form method="POST" action="{{ route('admin.requests.approve', $req->id) }}"
                        onsubmit="return confirm('{{ $stock >= $needed ? '¿Aprobar y entregar '.$needed.' unidades?' : '¿Aprobar parcialmente? Se entregarán '.$stock.' de '.$needed.'.' }}')">
                    @csrf
                    <button class="btn btn-sm" style="background:#f0fdf4;color:#166534;border:1.5px solid #bbf7d0;width:100%">
                      <i class="bi bi-check-circle"></i>
                      {{ $stock >= $needed ? 'Aprobar' : 'Aprobar parcial ('.$stock.' uds.)' }}
                    </button>
                  </form>
                @endif

              {{-- ══ PARCIALMENTE APROBADO ══ --}}
              @elseif($req->status === 'parcialmente_aprobado' && $req->quantity_pending > 0)
                @if($stock === 0)
                  <div style="font-size:11px;color:#991b1b;background:#fef2f2;padding:8px 10px;border-radius:8px;border:1px solid #fecaca;line-height:1.5">
                    <i class="bi bi-lock-fill"></i> Sin stock para completar<br>
                    Pendiente: {{ $req->quantity_pending }} uds.
                  </div>
                  <a href="{{ route('movements.create', ['product' => $req->product?->id]) }}"
                     class="btn btn-sm" style="background:#fffbeb;color:#92400e;border:1.5px solid #fde68a;width:100%">
                    <i class="bi bi-plus-lg"></i> Agregar stock
                  </a>
                @else
                  @php $entregar = min($stock, $req->quantity_pending); @endphp
                  @if($stock < $req->quantity_pending)
                    <div style="font-size:11px;color:#92400e;background:#fffbeb;padding:6px 8px;border-radius:8px;border:1px solid #fde68a;line-height:1.4">
                      <i class="bi bi-exclamation-triangle"></i> Se entregarán {{ $entregar }} de {{ $req->quantity_pending }} pendientes
                    </div>
                  @endif
                  <form method="POST" action="{{ route('admin.requests.complete', $req->id) }}"
                        onsubmit="return confirm('¿Entregar {{ $entregar }} unidades?')">
                    @csrf
                    <button class="btn btn-sm" style="background:#f0fdf4;color:#166534;border:1.5px solid #bbf7d0;width:100%">
                      <i class="bi bi-check-all"></i> Completar ({{ $entregar }} uds.)
                    </button>
                  </form>
                @endif

              @else
                <span class="text-muted text-sm">Procesada</span>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="flex-between" style="padding:16px 20px;border-top:1px solid #f1f5f9">
    <span class="text-muted text-sm">{{ $requests->total() }} solicitudes en total</span>
    @include('components.pagination', ['paginator' => $requests])
  </div>
  @else
  <div class="empty-state">
    <i class="bi bi-clipboard-check"></i>
    <p>No hay solicitudes registradas</p>
  </div>
  @endif
</div>
@endsection
