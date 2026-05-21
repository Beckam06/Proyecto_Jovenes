@if($paginator->hasPages())
<div class="pagination">
  @if($paginator->onFirstPage())
    <span class="disabled"><i class="bi bi-chevron-left" style="font-size:11px"></i></span>
  @else
    <a href="{{ $paginator->previousPageUrl() }}"><i class="bi bi-chevron-left" style="font-size:11px"></i></a>
  @endif

  @foreach($paginator->getUrlRange(max(1,$paginator->currentPage()-2), min($paginator->lastPage(),$paginator->currentPage()+2)) as $page => $url)
    @if($page == $paginator->currentPage())
      <span class="active">{{ $page }}</span>
    @else
      <a href="{{ $url }}">{{ $page }}</a>
    @endif
  @endforeach

  @if($paginator->hasMorePages())
    <a href="{{ $paginator->nextPageUrl() }}"><i class="bi bi-chevron-right" style="font-size:11px"></i></a>
  @else
    <span class="disabled"><i class="bi bi-chevron-right" style="font-size:11px"></i></span>
  @endif
</div>
@endif
