@props(['item'])

@php
  $currentRouteName = Route::currentRouteName();
  $menuRouteName = $item['route'];
  
  $menuBase = Illuminate\Support\Str::remove('.index', $menuRouteName);
  $currentBase = Illuminate\Support\Str::beforeLast($currentRouteName, '.');

  $isActive = $menuBase === $currentBase;
  $activeClass = 'bg-base-300/20 text-base-100 font-semibold active-menu rounded-lg';
  $inactiveClass = 'text-base-100 font-normal';
  $hoverClass = 'hover:bg-base-100 hover:text-base-content';

  $classes =
      'flex items-center gap-1 p-2 sidebar-link ' . ($isActive ? $activeClass : $inactiveClass) . ' ' . $hoverClass;
@endphp

<a class="{{ $classes }}" wire:navigate href="{{ route($item['route']) }}"
  @if ($isActive) data-active="1" @endif>
  <i class="{{ $item['icon'] }} w-6 text-center"></i>
  <span class="capitalize">{{ $item['text'] }}</span>
</a>
