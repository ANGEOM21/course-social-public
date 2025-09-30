<x-layouts.base>

  @php
    $auth_check_admin = auth('admins')->check() && request()->routeIs('admin.*');
    $login_page_admin = request()->routeIs('admin.login');
    $landing_page = request()->routeIs('landing.*');
    $auth_check_students = auth('web')->check() && request()->routeIs('student.*');
  @endphp
  @if ($auth_check_admin)
    @include('partials.admin-app')
  @elseif ($login_page_admin)
    @include('partials.auth-admin-app')
  @elseif ($auth_check_students)
    @include('partials.students-app')
  @elseif ($landing_page)
    <div>
      {{ $slot }}
    </div>
  @else
    <div class="min-h-screen bg-gray-100">
      <div class="container mx-auto px-4 py-8">
        <div class="flex justify-center items-center">
          <div class="card">
            <div class="card-body">
              <h1 class="text-2xl font-bold mb-4">Welcome to Desa Project-Web</h1>
              <p class="mb-4">Please log in or to continue.</p>
              <a href="{{ route('admin.login') }}" class="btn btn-secondary">Login as Admin</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  @endif
</x-layouts.base>
