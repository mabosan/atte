@if ($paginator->hasPages())
    <nav class="nav__pagination">
        <ul class="Pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="Pagination-Item-Link isActive" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span aria-hidden="true">&laquo;</span>
                </li>
            @else
                <li class="Pagination-Item-Link">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="@lang('pagination.previous')" class="Pagination-Item-Link-Icon">&laquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="Pagination-Item-Link disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="Pagination-Item-Link isActive" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li class="Pagination-Item-Link"><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="Pagination-Item-Link">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="@lang('pagination.next')" class="Pagination-Item-Link-Icon">&raquo;</a>
                </li>
            @else
                <li class="Pagination-Item-Link isActive" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span aria-hidden="true">&raquo;</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
