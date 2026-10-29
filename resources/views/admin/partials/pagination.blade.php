@if ($paginator->hasPages())
    <nav class="admin-pagination-nav" role="navigation" aria-label="Pagination Navigation">
        <div class="admin-pagination-info">
            Showing <span class="font-bold">{{ $paginator->firstItem() }}</span> to <span class="font-bold">{{ $paginator->lastItem() }}</span> of <span class="font-bold">{{ $paginator->total() }}</span> results
        </div>

        <ul class="admin-pagination-list">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="&laquo; Previous">
                    <span class="page-link" aria-hidden="true">&lsaquo; Prev</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="&laquo; Previous">&lsaquo; Prev</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span class="page-link dots">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next &raquo;">Next &rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="Next &raquo;">
                    <span class="page-link" aria-hidden="true">Next &rsaquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@else
    <div class="admin-pagination-info single-page">
        Showing all <span class="font-bold">{{ $paginator->total() }}</span> results
    </div>
@endif
