@props(['paginator', 'showPageSize' => false])

@if ($paginator->hasPages())
    <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6 mt-8">
        <!-- Results Info -->
        <div class="flex-1 flex justify-between sm:hidden">
            <div class="flex items-center">
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>
        </div>
        
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ $paginator->firstItem() }}</span>
                    to
                    <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    of
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    results
                </p>
            </div>
            
            <!-- Page Size Selector -->
            @if($showPageSize)
            <div class="flex items-center space-x-2">
                <label for="page-size" class="text-sm text-gray-700">Show:</label>
                <select id="page-size" class="rounded-md border-gray-300 text-sm focus:border-emerald-500 focus:ring-emerald-500">
                    <option value="10" {{ $paginator->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $paginator->perPage() == 20 ? 'selected' : '' }}>20</option>
                    <option value="50" {{ $paginator->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $paginator->perPage() == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span class="text-sm text-gray-700">per page</span>
            </div>
            @endif
        </div>

        <!-- Pagination Controls -->
        <div class="flex-1 flex justify-between sm:justify-end">
            <!-- Previous Button -->
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 rounded-md cursor-not-allowed">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md transition-colors duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Previous
                </a>
            @endif

            <!-- Page Numbers -->
            <div class="hidden sm:flex sm:items-center sm:space-x-1">
                @php
                    $currentPage = $paginator->currentPage();
                    $lastPage = $paginator->lastPage();
                    $start = max(1, $currentPage - 2);
                    $end = min($lastPage, $currentPage + 2);
                @endphp

                @if($start > 1)
                    <a href="{{ $paginator->url(1) }}" 
                       class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        1
                    </a>
                    @if($start > 2)
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500">
                            ...
                        </span>
                    @endif
                @endif

                @for($i = $start; $i <= $end; $i++)
                    @if($i == $currentPage)
                        <span class="relative z-10 inline-flex items-center px-4 py-2 border border-emerald-500 bg-emerald-50 text-sm font-medium text-emerald-800 rounded-md">
                            {{ $i }}
                        </span>
                    @else
                        <a href="{{ $paginator->url($i) }}" 
                           class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                            {{ $i }}
                        </a>
                    @endif
                @endfor

                @if($end < $lastPage)
                    @if($end < $lastPage - 1)
                        <span class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-500">
                            ...
                        </span>
                    @endif
                    <a href="{{ $paginator->url($lastPage) }}" 
                       class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                        {{ $lastPage }}
                    </a>
                @endif
            </div>

            <!-- Next Button -->
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="relative ml-3 inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md transition-colors duration-200">
                    Next
                    <svg class="h-5 w-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @else
                <span class="relative ml-3 inline-flex items-center px-4 py-2 border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 rounded-md cursor-not-allowed">
                    Next
                    <svg class="h-5 w-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            @endif
        </div>
    </div>

    <!-- Mobile Pagination -->
    <div class="sm:hidden">
        <div class="flex justify-between items-center mt-4 px-4">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-3 py-2 border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 rounded-md cursor-not-allowed">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Previous
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="relative inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Previous
                </a>
            @endif

            <div class="flex items-center space-x-1">
                @for($i = max(1, $currentPage - 1); $i <= min($lastPage, $currentPage + 1); $i++)
                    @if($i == $currentPage)
                        <span class="relative z-10 inline-flex items-center px-3 py-2 border border-emerald-500 bg-emerald-50 text-sm font-medium text-emerald-800 rounded-md">
                            {{ $i }}
                        </span>
                    @else
                        <a href="{{ $paginator->url($i) }}" 
                           class="relative inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                            {{ $i }}
                        </a>
                    @endif
                @endfor
            </div>

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="relative inline-flex items-center px-3 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-md">
                    Next
                    <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @else
                <span class="relative inline-flex items-center px-3 py-2 border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 rounded-md cursor-not-allowed">
                    Next
                    <svg class="h-4 w-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </span>
            @endif
        </div>
    </div>
@endif
