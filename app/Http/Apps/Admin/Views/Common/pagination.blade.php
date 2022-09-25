<ul class="pagination">
    {{-- Previous Page Link --}}
    <li class="page-item previous{{ $paginator->onFirstPage() ? ' disabled offset' : '' }}">
        <a class="page-link page-link--with-arrow"
            href="{{ $paginator->onFirstPage() ? '' : $paginator->previousPageUrl() }}" aria-label="Previous">
            <i class="previous"></i>
        </a>
    </li>
    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="page-item disabled offset"><span class="page-link">{{ $element }}</span>
            </li>
        @else
            @foreach ($element as $page => $url)
                @if ($page === $paginator->currentPage())
                    <li class="page-item active offset"><a href="#" class="page-link">{{ $page }}</a></li>
                @else
                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    {{-- Next Page Link --}}
    <li class="page-item next{{ $paginator->hasMorePages() ? '' : ' disabled offset' }}">
        <a class="page-link page-link--with-arrow"
            href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() : '' }}" aria-label="Next">
            <i class="next"></i>
        </a>
    </li>
</ul>
