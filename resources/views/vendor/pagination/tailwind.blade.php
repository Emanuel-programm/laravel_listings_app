@if ($paginator->hasPages())
    <nav class="flex justify-center" role="navigation">
        {{-- previous link --}}
        @if($paginator->onFirstPage())
            <span class="px-4 py-2 bg-gray-500 text-gray-500 rounded-l-lg">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="px-4 py-2 bg-blue-500 text-white rounded-l-lg hover:bg-blue-600">
                Previous
            </a>
        @endif

        {{-- pagination elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if(is_string($element))
                <span class="px-4 py-2 bg-gray-500 text-gray-500">...</span>
            @endif

            {{-- Array Of Links --}}
            @if(is_array($element))
                @foreach ($element as $page => $url)
                    @if($page == $paginator->currentPage())
                        <span class="px-4 py-2 bg-blue-500 text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="px-4 py-2 bg-blue-500 text-white hover:bg-blue-600">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- next link --}}
        @if($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="px-4 py-2 bg-blue-500 text-white rounded-r-lg hover:bg-blue-600">
                Next
            </a>
        @else
            <span class="px-4 py-2 bg-gray-500 text-gray-500 rounded-r-lg">Next</span>
        @endif
    </nav>
@endif