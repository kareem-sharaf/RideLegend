@props(['paginator'])

@if ($paginator->hasPages())
    <nav class="flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-neutral-200 pt-6" aria-label="Pagination">
        {{-- Results Info --}}
        <div class="flex items-center">
            <p class="text-sm text-neutral-600">
                Showing
                <span class="font-medium text-black">{{ $paginator->firstItem() }}</span>
                to
                <span class="font-medium text-black">{{ $paginator->lastItem() }}</span>
                of
                <span class="font-medium text-black">{{ $paginator->total() }}</span>
                results
            </p>
        </div>

        {{-- Pagination Controls --}}
        <div class="flex items-center gap-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-sm text-neutral-400 cursor-not-allowed border border-neutral-200">
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="px-4 py-2 text-sm text-black border border-neutral-200 hover:border-black hover:bg-neutral-50 transition-colors duration-200">
                    Previous
                </a>
            @endif

            {{-- Pagination Elements --}}
            <div class="flex items-center gap-1">
                @php
                    $currentPage = $paginator->currentPage();
                    $lastPage = $paginator->lastPage();
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($lastPage, $currentPage + 2);
                @endphp

                {{-- First Page --}}
                @if ($startPage > 1)
                    <a href="{{ $paginator->url(1) }}" 
                       class="px-4 py-2 text-sm text-neutral-600 border border-neutral-200 hover:border-black hover:text-black hover:bg-neutral-50 transition-colors duration-200">
                        1
                    </a>
                    @if ($startPage > 2)
                        <span class="px-2 text-sm text-neutral-400">...</span>
                    @endif
                @endif

                {{-- Page Range --}}
                @for ($page = $startPage; $page <= $endPage; $page++)
                    @if ($page == $currentPage)
                        <span class="px-4 py-2 text-sm font-medium text-black bg-neutral-100 border border-neutral-200">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $paginator->url($page) }}" 
                           class="px-4 py-2 text-sm text-neutral-600 border border-neutral-200 hover:border-black hover:text-black hover:bg-neutral-50 transition-colors duration-200">
                            {{ $page }}
                        </a>
                    @endif
                @endfor

                {{-- Last Page --}}
                @if ($endPage < $lastPage)
                    @if ($endPage < $lastPage - 1)
                        <span class="px-2 text-sm text-neutral-400">...</span>
                    @endif
                    <a href="{{ $paginator->url($lastPage) }}" 
                       class="px-4 py-2 text-sm text-neutral-600 border border-neutral-200 hover:border-black hover:text-black hover:bg-neutral-50 transition-colors duration-200">
                        {{ $lastPage }}
                    </a>
                @endif
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="px-4 py-2 text-sm text-black border border-neutral-200 hover:border-black hover:bg-neutral-50 transition-colors duration-200">
                    Next
                </a>
            @else
                <span class="px-4 py-2 text-sm text-neutral-400 cursor-not-allowed border border-neutral-200">
                    Next
                </span>
            @endif
        </div>
    </nav>
@endif

