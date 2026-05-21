@extends('layouts.app')
@section('title','Dashboard')
@section('content')

<div class="page-header">
  <div>
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">{{ now()->locale('es')->translatedFormat('l, d \d\e F Y') }}</p>
  </div>
  <a href="{{ route('movements.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-lg"></i> Nuevo movimiento
  </a>
</div>

{{-- Stats principales --}}
<div class="grid grid-4 mb-6">
  <div class="stat-card">
    <div class="stat-icon blue"><i class="bi bi-box"></i></div>
    <div>
      <div class="stat-label">Productos</div>
      <div class="stat-value">{{ $totalProducts }}</div>
      <div class="stat-desc">registrados</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green"><i class="bi bi-arrow-down-left"></i></div>
    <div>
      <div class="stat-label">Entradas</div>
      <div class="stat-value">{{ $totalEntries }}</div>
      <div class="stat-desc">totales</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon red"><i class="bi bi-arrow-up-right"></i></div>
    <div>
      <div class="stat-label">Salidas</div>
      <div class="stat-value">{{ $totalOutputs }}</div>
      <div class="stat-desc">totales</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon amber"><i class="bi bi-exclamation-triangle"></i></div>
    <div>
      <div class="stat-label">Stock bajo</div>
      <div class="stat-value">{{ $lowStockCount }}</div>
      <div class="stat-desc">productos</div>
    </div>
  </div>
</div>

{{-- Stats secundarios --}}
<div class="grid grid-3 mb-6">
  <div class="stat-card">
    <div class="stat-icon teal"><i class="bi bi-clock"></i></div>
    <div>
      <div class="stat-label">Hoy</div>
      <div class="stat-value">{{ $todayMovements }}</div>
      <div class="stat-desc">movimientos hoy</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon purple"><i class="bi bi-graph-up"></i></div>
    <div>
      <div class="stat-label">Balance neto</div>
      <div class="stat-value">{{ $totalEntries - $totalOutputs }}</div>
      <div class="stat-desc">unidades</div>
    </div>
  </div>
  <div class="stat-card" style="{{ $pendingRequestsCount > 0 ? 'border-color:#fde68a' : '' }}">
    <div class="stat-icon amber"><i class="bi bi-clipboard-check"></i></div>
    <div style="flex:1">
      <div class="stat-label">Solicitudes</div>
      <div class="stat-value">{{ $pendingRequestsCount }}</div>
      <div class="stat-desc">pendientes</div>
    </div>
    @if($pendingRequestsCount > 0)
      <a href="{{ route('admin.requests.index') }}" class="btn btn-sm btn-ghost">Ver</a>
    @endif
  </div>
</div>

{{-- Gráfico + tabla --}}
<div class="grid grid-12" style="grid-template-columns:1fr 1.8fr">
  <div class="card">
    <div class="card-header-custom">
      <span class="fw-semibold" style="font-size:14px"><i class="bi bi-bar-chart-line me-2" style="color:#4f46e5"></i>Últimos 7 días</span>
    </div>
    <div class="card-body">
      <canvas id="chart" height="220"></canvas>
    </div>
  </div>

  <div class="card">
    <div class="card-header-custom">
      <span class="fw-semibold" style="font-size:14px"><i class="bi bi-clock-history me-2" style="color:#4f46e5"></i>Últimos movimientos</span>
      <a href="{{ route('movements.index') }}" class="btn btn-sm btn-ghost">Ver todos</a>
    </div>
    @if($recentMovements->count())
    <div class="table-wrap">
      <table>
        <thead>
          <tr>
            <th>Producto</th>
            <th>Cant.</th>
            <th>Tipo</th>
            <th>Receptor</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          @foreach($recentMovements as $m)
          <tr>
            <td class="fw-semibold">{{ $m->product->name ?? 'Eliminado' }}</td>
            <td><span class="badge badge-gray">{{ $m->quantity }}</span></td>
            <td>
              <span class="badge {{ $m->type === 'entrada' ? 'badge-green' : 'badge-red' }}">
                {{ $m->type }}
              </span>
            </td>
            <td class="text-muted text-sm">{{ $m->receptor ?? '—' }}</td>
            <td class="text-muted text-sm">{{ $m->created_at->format('d/m H:i') }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @else
    <div class="empty-state">
      <i class="bi bi-inbox"></i>
      <p>Sin movimientos aún</p>
    </div>
    @endif
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const data = @json($weeklyData);
const keys = [], entries = [], salidas = [];
for (let i = 6; i >= 0; i--) {
  const d = new Date(); d.setDate(d.getDate() - i);
  const key = d.toISOString().split('T')[0];
  keys.push(d.toLocaleDateString('es', {weekday:'short', day:'numeric'}));
  const row = data.find(r => r.date === key) || {};
  entries.push(row.entradas || 0);
  salidas.push(row.salidas || 0);
}
new Chart(document.getElementById('chart'), {
  type:'bar',
  data: {
    labels: keys,
    datasets: [
      { label:'Entradas', data: entries, backgroundColor:'rgba(16,185,129,.75)', borderRadius:6, borderSkipped:false },
      { label:'Salidas',  data: salidas,  backgroundColor:'rgba(239,68,68,.75)',  borderRadius:6, borderSkipped:false }
    ]
  },
  options:{
    responsive:true, maintainAspectRatio:true,
    plugins:{ legend:{ position:'bottom', labels:{ boxWidth:10, font:{ size:11 } } } },
    scales:{
      y:{ beginAtZero:true, ticks:{ precision:0 }, grid:{ color:'#f1f5f9' } },
      x:{ grid:{ display:false } }
    }
  }
});
</script>
@endpush
