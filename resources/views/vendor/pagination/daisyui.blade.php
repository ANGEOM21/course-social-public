@if ($paginator->hasPages())
    <div class="flex flex-col items-center  gap-2">
        {{-- Showing info (disembunyi) --}}
        <div class="text-sm">
            {{ __('pagination.showing') }}
            @if ($paginator->firstItem())
                <span class="font-semibold">{{ $paginator->firstItem() }}</span>
                {{ __('pagination.to') }}
                <span class="font-semibold">{{ $paginator->lastItem() }}</span>
            @else
                {{ $paginator->count() }}
            @endif
            {{ __('pagination.of') }}
            <span class="font-semibold">{{ $paginator->total() }}</span>
            {{ __('pagination.results') }}
        </div>

        {{-- Mobile pagination (prev/next only) --}}
        <div class="flex justify-center sm:hidden gap-2">
            @if ($paginator->onFirstPage())
                <button class="btn btn-disabled">Prev</button>
            @else
                <button wire:click="previousPage" class="btn">Prev</button>
            @endif

            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" class="btn">Next</button>
            @else
                <button class="btn btn-disabled">Next</button>
            @endif
        </div>

        {{-- Desktop pagination (full join buttons) --}}
        <div class="hidden sm:flex join">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <button class="btn join-item btn-disabled">«</button>
            @else
                <button wire:click="previousPage" class="btn join-item">«</button>
            @endif

            {{-- Page numbers --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <button class="btn join-item btn-disabled">{{ $element }}</button>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <button class="btn join-item btn-active">{{ $page }}</button>
                        @else
                            <button wire:click="gotoPage({{ $page }})" class="btn join-item">{{ $page }}</button>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <button wire:click="nextPage" class="btn join-item">»</button>
            @else
                <button class="btn join-item btn-disabled">»</button>
            @endif
        </div>
    </div>
@endif
