@extends('layouts.app')
@section('title','Productos')
@section('content')

<div class="page-header">
  <div>
    <h1 class="page-title">Productos</h1>
    <p class="page-subtitle">Gestión de inventario</p>
  </div>
  <div class="flex gap-2">
    @if(request('stock')==='low')
      <a href="{{ route('products.index') }}" class="btn btn-ghost btn-sm"><i class="bi bi-x"></i> Limpiar filtro</a>
    @else
      <a href="{{ route('products.index') }}?stock=low" class="btn btn-ghost btn-sm" style="border-color:#fde68a;color:#92400e">
        <i class="bi bi-exclamation-triangle"></i> Stock bajo
      </a>
    @endif
    <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Nuevo producto</a>
  </div>
</div>

{{-- Buscador --}}
<div class="card mb-4">
  <div class="card-body" style="padding:14px 20px">
    <form action="{{ route('products.index') }}" method="GET" class="flex gap-3 align-items-center">
      @if(request('stock')) <input type="hidden" name="stock" value="{{ request('stock') }}"> @endif
      <div class="search-wrap" style="flex:1">
        <i class="bi bi-search"></i>
        <input type="text" name="search" placeholder="Buscar productos…" value="{{ request('search') }}">
      </div>
      <button type="submit" class="btn btn-primary btn-sm">Buscar</button>
      @if(request('search'))
        <a href="{{ route('products.index') }}{{ request('stock') ? '?stock=low' : '' }}" class="btn btn-ghost btn-sm"><i class="bi bi-x"></i></a>
      @endif
    </form>
  </div>
</div>

<div class="card">
  @if($products->count())
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Producto</th>
          <th class="hide-mobile">SKU</th>
          <th class="hide-mobile">Precio</th>
          <th>Stock</th>
          <th>Estado</th>
          <th style="text-align:center">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @php $start = ($products->currentPage()-1)*$products->perPage()+1; @endphp
        @foreach($products as $i => $p)
        <tr>
          <td class="text-muted text-sm">{{ $start+$i }}</td>
          <td>
            <div class="flex-center gap-2">
              <div class="product-avatar"><i class="bi bi-box-seam"></i></div>
              <div>
                <a href="{{ route('products.show',$p) }}" style="font-weight:600;color:#0f172a;text-decoration:none;font-size:13.5px">
                  {{ $p->name }}
                </a>
                @if($p->description)
                  <div class="text-muted text-sm" style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                    {{ $p->description }}
                  </div>
                @endif
              </div>
            </div>
          </td>
          <td class="hide-mobile"><span class="badge badge-gray" style="font-family:monospace">{{ $p->sku }}</span></td>
          <td class="hide-mobile fw-semibold">L{{ number_format($p->price,2) }}</td>
          <td>
            <span class="badge {{ $p->stock>10 ? 'badge-green' : ($p->stock>0 ? 'badge-amber' : 'badge-red') }}">
              {{ $p->stock }} uds.
            </span>
          </td>
          <td>
            @if($p->stock==0)
              <span class="badge badge-red">Agotado</span>
            @elseif($p->stock<5)
              <span class="badge badge-amber">Bajo stock</span>
            @else
              <span class="badge badge-green">Disponible</span>
            @endif
          </td>
          <td>
            <div class="flex-center gap-1" style="justify-content:center">
              <a href="{{ route('products.show',$p) }}" class="btn btn-icon btn-ghost" title="Ver"><i class="bi bi-eye"></i></a>
              <a href="{{ route('products.edit',$p) }}" class="btn btn-icon btn-ghost" title="Editar" style="color:#4f46e5"><i class="bi bi-pencil"></i></a>
              <a href="{{ route('movements.create',['product'=>$p->id]) }}" class="btn btn-icon btn-ghost" title="Añadir stock" style="color:#10b981"><i class="bi bi-plus-lg"></i></a>
              <form action="{{ route('products.destroy',$p) }}" method="POST" onsubmit="return confirm('¿Eliminar este producto?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-icon btn-ghost" title="Eliminar" style="color:#ef4444"><i class="bi bi-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="flex-between" style="padding:16px 20px;border-top:1px solid #f1f5f9">
    <span class="text-muted text-sm">Mostrando {{ $products->firstItem() }}–{{ $products->lastItem() }} de {{ $products->total() }}</span>
    @include('components.pagination', ['paginator' => $products])
  </div>
  @else
  <div class="empty-state">
    <i class="bi bi-box"></i>
    <p>No se encontraron productos</p>
    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-lg"></i> Crear producto</a>
  </div>
  @endif
</div>
@endsection
