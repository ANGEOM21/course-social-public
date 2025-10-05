@php
  $menuItem = new \App\Constant\MenuItem();
  $menunList = collect($menuItem->menuList())['dashboard_student'];
@endphp
<div>
  <title>{{ isset($title) ? $title : 'Dashboard' }} {{ $app_name }}</title>
  <div>

    {{-- Navbar --}}
    @include('layouts.section.navbar', [
        'menunList' => $menunList,
    ])

    {{-- Google One Tap --}}
    @push('styles') 
      @guest
        <script src="https://accounts.google.com/gsi/client" async defer></script>
      @endguest
    @endpush
    {{-- Konten Utama --}}
    {{ $slot }}
    @push('scripts')
      @guest
        <div id="g_id_onload" data-auto_select="true"
          data-client_id="{{ config('services.laravel-google-one-tap.client_id') }}"
          data-login_uri="{{ config('services.laravel-google-one-tap.redirect') }}" data-use_fedcm_for_prompt="true"
          data-_token="{{ csrf_token() }}"></div>
      @endguest
    @endpush

    {{-- Footer --}}
    @include('layouts.section.footer')
  </div>
</div>
