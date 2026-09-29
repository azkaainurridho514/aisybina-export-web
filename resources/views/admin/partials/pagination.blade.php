{{-- Pagination bergaya admin. Pakai: @include('admin.partials.pagination', ['paginator' => $items]) --}}
@if ($paginator->hasPages())
  @php
    $current = $paginator->currentPage();
    $last    = $paginator->lastPage();
    $end     = min($last, max(1, $current - 2) + 4);
    $start   = max(1, $end - 4);
  @endphp

  <div class="admin-pagination">
    <div class="admin-pagination-info">
      Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }} data
    </div>

    <div class="admin-pagination-buttons">
      @if ($paginator->onFirstPage())
        <button type="button" class="btn-icon" disabled title="Sebelumnya"><i class="bi bi-chevron-left"></i></button>
      @else
        <a class="btn-icon" href="{{ $paginator->previousPageUrl() }}" title="Sebelumnya"><i class="bi bi-chevron-left"></i></a>
      @endif

      @for ($page = $start; $page <= $end; $page++)
        <a class="btn-icon admin-page-number {{ $page === $current ? 'active' : '' }}"
           href="{{ $paginator->url($page) }}"
           @if ($page === $current) aria-current="page" @endif>{{ $page }}</a>
      @endfor

      @if ($paginator->hasMorePages())
        <a class="btn-icon" href="{{ $paginator->nextPageUrl() }}" title="Berikutnya"><i class="bi bi-chevron-right"></i></a>
      @else
        <button type="button" class="btn-icon" disabled title="Berikutnya"><i class="bi bi-chevron-right"></i></button>
      @endif
    </div>
  </div>
@endif
