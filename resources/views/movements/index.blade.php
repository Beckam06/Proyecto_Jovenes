@extends('layouts.app')
@section('title','Movimientos')
@section('content')

<div class="page-header">
  <div>
    <h1 class="page-title">Movimientos</h1>
    <p class="page-subtitle">Entradas y salidas de inventario</p>
  </div>
  <div class="flex gap-2">
    <a href="{{ route('movements.create') }}" class="btn btn-success"><i class="bi bi-plus-lg"></i> Nuevo</a>
    <a href="{{ route('movements.pdf', request()->all()) }}" class="btn btn-ghost" target="_blank">
      <i class="bi bi-file-pdf"></i> PDF
    </a>
  </div>
</div>

{{-- Filtros --}}
<div class="filter-card mb-4">
  <form action="{{ route('movements.index') }}" method="GET" id="filterForm">
    <div class="grid" style="grid-template-columns:auto 1fr 1fr 1fr auto;gap:12px;align-items:end">
      <div>
        <label class="form-label">Tipo</label>
        <div class="btn-group">
          <button type="button" class="btn btn-sm btn-outline {{ request('type','')=='' ? 'active' : '' }}"
            onclick="setType('')">Todos</button>
          <button type="button" class="btn btn-sm btn-outline {{ request('type')=='entrada' ? 'active' : '' }}"
            onclick="setType('entrada')">Entradas</button>
          <button type="button" class="btn btn-sm btn-outline {{ request('type')=='salida' ? 'active' : '' }}"
            onclick="setType('salida')">Salidas</button>
        </div>
        <input type="hidden" name="type" id="typeInput" value="{{ request('type') }}">
      </div>
      <div>
        <label class="form-label">Desde</label>
        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
      </div>
      <div>
        <label class="form-label">Hasta</label>
        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
      </div>
      <div>
        <label class="form-label">Receptor</label>
        <input type="text" name="receptor" class="form-control" placeholder="Buscar receptor…" value="{{ request('receptor') }}">
      </div>
      <div class="flex gap-2" style="align-self:flex-end">
        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-funnel"></i> Filtrar</button>
        <a href="{{ route('movements.index') }}" class="btn btn-ghost btn-sm"><i class="bi bi-x"></i></a>
      </div>
    </div>
  </form>
</div>

<div class="card">
  @if($movements->count())
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Producto</th>
          <th>Cantidad</th>
          <th>Tipo</th>
          <th class="hide-mobile">Receptor</th>
          <th class="hide-mobile">Notas</th>
          <th>Fecha</th>
          <th>Acción</th>
        </tr>
      </thead>
      <tbody>
        @php $start = ($movements->currentPage()-1) * $movements->perPage() + 1; @endphp
        @foreach($movements as $i => $m)
        <tr>
          <td class="text-muted text-sm">{{ $start + $i }}</td>
          <td>
            <div class="flex-center gap-2">
              <div class="product-avatar"><i class="bi bi-box-seam"></i></div>
              <span class="fw-semibold">{{ $m->product->name ?? 'Eliminado' }}</span>
            </div>
          </td>
          <td><span class="badge badge-gray">{{ $m->quantity }}</span></td>
          <td>
            <span class="badge {{ $m->type==='entrada' ? 'badge-green' : 'badge-red' }}">
              <i class="bi bi-{{ $m->type==='entrada' ? 'arrow-down-left' : 'arrow-up-right' }} me-1"></i>
              {{ $m->type }}
            </span>
          </td>
          <td class="text-muted text-sm hide-mobile">{{ $m->receptor ?? '—' }}</td>
          <td class="text-muted text-sm hide-mobile" style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
            {{ $m->notes ?? '—' }}
          </td>
          <td class="text-muted text-sm">{{ $m->created_at->format('d/m/Y H:i') }}</td>
          <td>
            <form action="{{ route('movements.destroy', $m) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar este movimiento? El stock se revertirá automáticamente.')">
              @csrf @method('DELETE')
              <button type="submit" class="btn btn-icon" style="background:#fef2f2;color:#ef4444;border:1.5px solid #fecaca" title="Eliminar movimiento">
                <i class="bi bi-trash"></i>
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="flex-between" style="padding:16px 20px;border-top:1px solid #f1f5f9">
    <span class="text-muted text-sm">
      Mostrando {{ $movements->firstItem() }}–{{ $movements->lastItem() }} de {{ $movements->total() }}
    </span>
    @include('components.pagination', ['paginator' => $movements])
  </div>
  @else
  <div class="empty-state">
    <i class="bi bi-inbox"></i>
    <p>Sin movimientos registrados</p>
    <a href="{{ route('movements.create') }}" class="btn btn-primary mt-3 btn-sm">
      <i class="bi bi-plus-lg"></i> Registrar primero
    </a>
  </div>
  @endif
</div>

@endsection
@push('scripts')
<script>
function setType(v) {
  document.getElementById('typeInput').value = v;
  document.getElementById('filterForm').submit();
}
</script>
@endpush
