@php

  $isAuth = auth('web')->check();
  $user = $isAuth ? auth('web')->user() : null;

  $forwardSectionToDashboard ??= true;
  $dashboardRouteName ??= 'student.dashboard';
  $landingRouteName ??= 'landing.index';

  // jadikan numerik, buang key asosiatif ("beranda","about",dst) biar gampang loop
  $rawItems = collect($menunList ?? [])->values();

  // normalisasi -> semua item punya: text, href, route_name (opsional)
  $items = $rawItems->map(function ($it) use ($isAuth, $forwardSectionToDashboard, $dashboardRouteName) {
      $text = $it['text'] ?? 'Menu';
      $nav = !empty($it['navigation']); // selalu boolean

      // route_name
      if (!empty($it['route_name'])) {
          return [
              'text' => $text,
              'route_name' => $it['route_name'],
              'href' => route($it['route_name']),
              'is_section' => false,
              'navigation' => $nav, // hanya true kalau diminta
          ];
      }

      // href
      if (!empty($it['href'])) {
          return [
              'text' => $text,
              'route_name' => null,
              'href' => $it['href'],
              'is_section' => false,
              'navigation' => $nav,
          ];
      }

      // section anchor landing_page
      if (!empty($it['section'])) {
          $href = $it['section'];

          return [
              'text' => $text,
              'route_name' => null,
              'href' => $href,
              'is_section' => true,
              'section_raw' => $it['section'],
              'navigation' => $nav,
          ];
      }

      // fallback
      return [
          'text' => $text,
          'route_name' => null,
          'href' => '#',
          'is_section' => false,
          'navigation' => $nav,
      ];
  });

  // aktif state
  $isActive = fn($item) => !empty($item['route_name']) && request()->routeIs($item['route_name']);

  $appName = $app_name ?? config('app.name', 'App');

  // avatar
  $displayName = \Illuminate\Support\Str::before($user->name_student ?? ($user->name ?? 'User'), ' ');
  $imageUrl =
      $user->img_student ??
      'https://ui-avatars.com/api/?name=' . urlencode($user->name_student ?? ($user->name ?? 'User')) . '&size=50';
  $fallback = 'https://ui-avatars.com/api/?name=' . urlencode($user->name_student ?? ($user->name ?? 'User'));
@endphp

<nav class="navbar bg-base-100/80 backdrop-blur-sm shadow-lg px-4 sm:px-8 sticky top-0 z-50 transition-all duration-300"
  id="navbar">
  <div class="navbar-start w-full md:w-[50%]">
    <a href="{{ route($landingRouteName) }}" class="flex item-center text-xl p-0 hover:bg-transparent">
      <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8 w-8 mr-2" />
      <span class="font-bold bg-clip-text capitalize truncate elipsis">{{ $appName }}</span>
    </a>
  </div>

  {{-- Desktop Nav --}}
  <div class="navbar-center hidden lg:flex">
    <ul class="menu menu-horizontal px-1 font-medium gap-4">
      @foreach ($items as $it)
        <li>
          <a href="{{ $it['href'] }}" @if (!empty($it['navigation'])) wire:navigate @endif
            @class([
                'text-base-content hover:text-primary transition-all duration-300 transform hover:scale-105',
                'font-bold text-primary' => $isActive($it),
            ])>
            {{ $it['text'] }}
          </a>
        </li>
      @endforeach
    </ul>
  </div>

  {{-- Auth Section --}}
  <div class="navbar-end gap-3">
    @if (!$isAuth)
      <button id="btn-google" class="btn bg-white rounded-full text-black border-[#e5e5e5]">
        <svg aria-label="Google logo" width="16" height="16" xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 512 512">
          <g>
            <path d="m0 0H512V512H0" fill="#fff"></path>
            <path fill="#34a853" d="M153 292c30 82 118 95 171 60h62v48A192 192 0 0190 341"></path>
            <path fill="#4285f4" d="m386 400a140 175 0 0053-179H260v74h102q-7 37-38 57"></path>
            <path fill="#fbbc02" d="m90 341a208 200 0 010-171l63 49q-12 37 0 73"></path>
            <path fill="#ea4335" d="m153 219c22-69 116-109 179-50l55-54c-78-75-230-72-297 55"></path>
          </g>
        </svg>
        Login
      </button>
    @else
      <div class="justify-center items-center gap-3 dropdown dropdown-bottom dropdown-end hidden md:flex">
        <span class="text-lg font-semibold max-w-[120px] truncate text-base-content">
          {{ $displayName }}
        </span>

        <div tabindex="0" role="button" class="normal-case avatar btn btn-ghost btn-circle ">
          <div class="w-10 rounded-full flex">
            <div class="bg-base-300 h-10 w-10 flex items-center justify-center">
              <img src="{{ $imageUrl }}" alt="User Avatar" class="w-10 h-10 rounded-full" loading="lazy"
                referrerpolicy="no-referrer" decoding="async"
                onerror="this.onerror=null;this.src='{{ $fallback }}';" />
            </div>
          </div>
        </div>

        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-44 p-2 mt-2 shadow">
          <li>
            <a href="{{ route($dashboardRouteName) }}" class="flex items-center gap-2" wire:navigate>
              <i class="fa-solid fa-user"></i> Dashboard
            </a>
          </li>
          <li>
            <a href="{{ route('student.profile') }}" wire:navigate class="flex items-center gap-2">
              <i class="fa-solid fa-id-badge"></i> Profile
            </a>
          </li>
          <livewire:components.logout />
        </ul>
      </div>
    @endif

    {{-- Mobile menu button --}}
    <div class="lg:hidden">
      <label for="drawer-menu" class="btn btn-ghost btn-circle hover:scale-110 transition-transform duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </label>
    </div>
  </div>
</nav>

{{-- Drawer (mobile) --}}
<div class="drawer drawer-end z-50">
  <input id="drawer-menu" type="checkbox" class="drawer-toggle" />
  <div class="drawer-side">
    <label for="drawer-menu" class="drawer-overlay"></label>
    <div class="menu p-4 w-80 min-h-full bg-base-100 text-base-content shadow-xl">
      <div class="flex items-center justify-between mb-6">
        <span class="text-xl font-bold gradient-text">Menu</span>
        <label for="drawer-menu" class="btn btn-ghost btn-circle hover:scale-110 transition-transform duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </label>
      </div>

      <ul class="space-y-2">
        @foreach ($items as $it)
          <li>
            <a href="{{ $it['href'] }}"
              class="text-base-content hover:text-primary transition-all duration-300 transform hover:scale-105">
              {{ $it['text'] }}
            </a>
          </li>
        @endforeach

        <li class="divider my-4"></li>

        @if (!$isAuth)
          <li>
            <a class="btn bg-white text-black border-[#e5e5e5]"
              href="{{ route('google.login', ['role' => 'student']) }}">
              <svg aria-label="Google logo" width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 512 512">
                <g>
                  <path d="m0 0H512V512H0" fill="#fff"></path>
                  <path fill="#34a853" d="M153 292c30 82 118 95 171 60h62v48A192 192 0 0190 341"></path>
                  <path fill="#4285f4" d="m386 400a140 175 0 0053-179H260v74h102q-7 37-38 57"></path>
                  <path fill="#fbbc02" d="m90 341a208 200 0 010-171l63 49q-12 37 0 73"></path>
                  <path fill="#ea4335" d="m153 219c22-69 116-109 179-50l55-54c-78-75-230-72-297 55"></path>
                </g>
              </svg>
              Login
            </a>
          </li>
        @else
          <li>
            <a href="{{ route($dashboardRouteName) }}"
              class="btn my-2 w-full hover:scale-105 transition-transform duration-300">
              <i class="fa-solid fa-user"></i> Dashboard
            </a>
          </li>
          <livewire:components.logout />
          <li class="mt-2">
            <div class="flex justify-between items-center">
              <span>{{ $user->name_student ?? $user->name }}</span>
              <div class="w-10 rounded-full flex">
                <div class="bg-base-300 h-10 w-10 flex items-center justify-center">
                  <img src="{{ $imageUrl }}" alt="User Avatar" class="w-10 h-10 rounded-full"
                    onerror="this.onerror=null;this.src='{{ $fallback }}';" />
                </div>
              </div>
            </div>
          </li>
        @endif
      </ul>
    </div>
  </div>
</div>
