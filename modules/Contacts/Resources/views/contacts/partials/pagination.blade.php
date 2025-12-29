<div class="d-flex flex-stack flex-wrap pt-10">
    {{-- <div class="fs-6 fw-semibold text-gray-700">
        Showing {{ $items->firstItem() }} to {{ $items->lastItem() }} of
        {{ $items->total() }} entries
    </div> --}}
    <ul class="pagination">
        @if ($items->onFirstPage())
            <li class="page-item previous disabled">
                <a href="#" class="page-link">
                    <i class="previous"></i>
                </a>
            </li>
        @else
            <li class="page-item previous">
                <a href="{{ $items->previousPageUrl() }}" class="page-link">
                    <i class="previous"></i>
                </a>
            </li>
        @endif

        @foreach ($items->getUrlRange(1, $items->lastPage()) as $page => $url)
            @if ($page == $items->currentPage())
                <li class="page-item active">
                    <a href="#" class="page-link">{{ $page }}</a>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                </li>
            @endif
        @endforeach

        @if ($items->hasMorePages())
            <li class="page-item next">
                <a href="{{ $items->nextPageUrl() }}" class="page-link">
                    <i class="next"></i>
                </a>
            </li>
        @else
            <li class="page-item next disabled">
                <a href="#" class="page-link">
                    <i class="next"></i>
                </a>
            </li>
        @endif
    </ul>
</div>