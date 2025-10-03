@props([
    'title' => null,
    'subtitle' => null,
    'separator' => false,
    'progressIndicator' => null,
    'withAnchor' => false,
    'size' => 'text-3xl',
])

@php
  $anchor = \Illuminate\Support\Str::slug($title ?? 'header');
  $progressTarget = $progressIndicator === '1' ? collect($attributes->getAttributes())
      ->first(fn ($v, $k) => str($k)->startsWith('progress-indicator')) : $progressIndicator;
@endphp

<div id="{{ $anchor }}" {{ $attributes->class(['mb-1', 'mary-header-anchor' => $withAnchor]) }}>
  <div class="flex flex-wrap gap-5 justify-between items-center">
    <div>
      <div class="{{ $size }} font-extrabold">
        @if($withAnchor)
          <a href="#{{ $anchor }}">
        @endif

        {{ $title }}

        @if($withAnchor)
          </a>
        @endif
      </div>

      @if($subtitle)
        <div class="text-gray-500 text-sm mt-1">
          {{ $subtitle }}
        </div>
      @endif
    </div>

    @isset($middle)
      <div class="flex items-center justify-center gap-3 grow order-last sm:order-none">
        <div class="w-full lg:w-auto">
          {{ $middle }}
        </div>
      </div>
    @endisset

    @isset($actions)
      <div class="flex items-center gap-3">
        {{ $actions }}
      </div>
    @endisset
  </div>

  @if($separator)
    <hr class="my-5" />

    @if($progressIndicator)
      <div class="h-0.5 -mt-9 mb-9">
        <progress class="progress progress-primary w-full h-0.5 dark:h-1" wire:loading
          @if($progressTarget)
            wire:target="{{ $progressTarget }}"
          @endif></progress>
      </div>
    @endif
  @endif
</div>
