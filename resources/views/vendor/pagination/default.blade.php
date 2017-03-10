@if ($paginator->hasPages())
    <ul class="pagination text-center" role="navigation" aria-label="Pagination">
        @if ($paginator->onFirstPage())
            <li class="pagination-previous disabled">上一页</li>
        @else
            <li class="pagination-previous"><a href="{{ $paginator->previousPageUrl() }}" aria-label="Previous Page">上一页</a></li>
        @endif
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="ellipsis"></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="current">{{ $page }}</li>
                    @else
                        <li><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach
        @if ($paginator->hasMorePages())
            <li class="pagination-next"><a href="{{ $paginator->nextPageUrl() }}" aria-label="Next Page">下一页</a></li>
        @else
            <li class="pagination-next disabled">下一页</li>
        @endif
        </ul>
@endif