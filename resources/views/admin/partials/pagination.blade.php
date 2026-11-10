{{-- Pakai: @include('admin.partials.pagination', ['paginator' => $kategoris, 'label' => 'kategori']) --}}
<div class="pagination">
    <div class="pagination-info">
        Menampilkan {{ $paginator->firstItem() ?? 0 }} - {{ $paginator->lastItem() ?? 0 }} dari {{ $paginator->total() }} {{ $label }}
    </div>
    <div class="pagination-links">
        @if($paginator->onFirstPage())
            <span class="page">‹</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="page">‹</a>
        @endif
        <span class="page active">{{ $paginator->currentPage() }}</span>
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="page">›</a>
        @else
            <span class="page">›</span>
        @endif
    </div>
</div>