<ul class="pagination justify-content-center">
    {{-- Previous Page Link --}}
    <li class="page-item{{ $paginator->onFirstPage() ? ' disabled' : '' }}">
        <a class="page-link page-link--with-arrow"
            href="{{ $paginator->onFirstPage() ? '' : $paginator->previousPageUrl() }}" aria-label="Previous">
            <svg class="page-link__arrow page-link__arrow--left" aria-hidden="true" width="8px" height="13px">
                <use xlink:href="/public/main/images/sprite.svg#arrow-rounded-left-8x13">
                </use>
            </svg>
        </a>
    </li>
    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        @if (is_string($element))
            <li class="page-item disabled"><span class="page-link">{{ $element }}</span>
            </li>
        @else
            @foreach ($element as $page => $url)
                @if ($page === $paginator->currentPage())
                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                @else
                    <li class="page-item"><a class="page-link"
                            href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach
        @endif
    @endforeach
    {{-- Next Page Link --}}
    <li class="page-item{{ $paginator->hasMorePages() ? '' : ' disabled' }}">
        <a class="page-link page-link--with-arrow"
            href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() : '' }}" aria-label="Next">
            <svg class="page-link__arrow page-link__arrow--right" aria-hidden="true" width="8px" height="13px">
                <use xlink:href="/public/main/images/sprite.svg#arrow-rounded-right-8x13">
                </use>
            </svg>
        </a>
    </li>
</ul>
