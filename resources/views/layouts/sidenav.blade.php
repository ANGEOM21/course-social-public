<div class="drawer-side z-50" x-data="persistScroll()" x-init="init()">
  <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label>
  <ul class="menu p-0 w-64 h-full">
    <!-- Sidebar content here -->
    <div class="bg-slate-900 via-violet-900 min-h-full flex flex-col">
      <!-- Logo Section -->
      <div class="p-3">
        <div class="mb-4 text-base-100">
          <div class="flex justify-start items-center gap-1 select-none pointer-events-none"
            oncontextmenu="return false;">
            <div class="w-[40px] p-1">
              <img src="{{ $logo }}" class="w-[50px] select-none pointer-events-none" alt="logo"
                draggable="false" oncontextmenu="return false;" ondragstart="return false;">
            </div>
            <h1
              class="cursor-default text-lg font-extrabold uppercase leading-tight bg-base-100 bg-clip-text text-transparent drop-shadow select-none pointer-events-none"
              oncontextmenu="return false;">
              {{ $app_name }}
            </h1>
          </div>
        </div>
        <div class="h-px bg-base-300 my-2"></div>
      </div>

      <!-- Scrollable Menu Items -->
      <div id="sidebar-scroll" x-ref="box" class="flex-1 overflow-y-auto p-3 pt-0">
        @php
          
          $menu = new App\Constant\MenuItem();
          $menuItems = collect($menu->getMenuItemAdmin())->filter(function ($item) {
              if (!isset($item['role'])) {
                  return true;
              }
              $allowedRoles = is_array($item['role']) ? $item['role'] : [$item['role']];
              return in_array(auth('admins')->user()->role, $allowedRoles);
          });
        @endphp

        @foreach ($menuItems as $item)
          {{-- Cek apakah item adalah GRUP/COLLAPSE --}}
          @if (isset($item['children']))
            <div class="collapse collapse-arrow bg-base-content !p-0 mb-1">
              <input type="checkbox" class="peer pb-0" {{ Request::is($item['segment'] . '*') ? 'checked' : '' }} />
              <div
                class="collapse-title text-base-content peer-checked:text-base-content peer-checked:bg-base-300 flex items-center gap-2 min-h-1 p-3">
                <i class="{{ $item['icon'] }} w-6 text-center"></i>
                <span class="capitalize">{{ $item['text'] }}</span>
              </div>

              <div class="collapse-content peer-checked:bg-base-300 !p-0">
                <ul class="menu menu-compact">
                  @foreach ($item['children'] as $child)
                    <li class="mb-1">
                      @php
                        $currentRouteName = Route::currentRouteName();
                        $menuRouteName = $child['route'];
                        $menuBase = Illuminate\Support\Str::remove('.index', $menuRouteName);
                        $currentBase = Illuminate\Support\Str::beforeLast($currentRouteName, '.');
                        $isChildActive = $menuBase === $currentBase;
                        $childActiveClass = 'bg-base-content text-base-100 active-menu rounded-lg';
                        $childInactiveClass = 'text-base-content font-normal';
                        $childHoverClass = 'hover:bg-base-content hover:text-base-100';

                        $childClasses =
                            'flex items-center gap-2 sidebar-link ' .
                            ($isChildActive ? $childActiveClass : $childInactiveClass) .
                            ' ' .
                            $childHoverClass;
                      @endphp
                      <a wire:navigate href="{{ route($child['route']) }}" class="{{ $childClasses }}"
                        @if ($isChildActive) data-active="1" @endif>
                        <i class="{{ $child['icon'] }} w-6 text-center"></i>
                        <span class="capitalize">{{ $child['text'] }}</span>
                      </a>
                    </li>
                  @endforeach
                </ul>
              </div>
            </div>
          @else
            <li class="mb-1">
              {{-- Jika bukan grup, render sebagai link tunggal menggunakan komponen --}}
              <x-sidebar.menu-item :item="$item" />
            </li>
          @endif
        @endforeach
      </div>

      <!-- Sticky Footer -->
      <div class="sticky bottom-0 bg-slate-900  text-base-100 p-3 hidden lg:block">
        {{-- ... (Bagian footer profil Anda tetap sama) ... --}}
        <div class="hidden lg:flex items-center justify-between gap-3">
          <div class="items-center justify-center gap-3 flex">
            <div class="normal-case avatar">
              <div class="w-10 rounded-full flex">
                <div class="bg-base-300 h-10 w-10 flex items-center justify-center">
                  <img
                    src="{{ auth('admins')->user()->img_admin ? asset('storage/' . auth('admins')->user()->img_admin) : 'https://ui-avatars.com/api/?name=' . urlencode(auth('admins')->user()->name_admin) }}"
                    alt="User Avatar" class="w-10 h-10 rounded-full" />
                </div>
              </div>
            </div>
            <span class="text-lg font-semibold max-w-[100px] truncate">
              {{ Str::before(auth('admins')->user()->name_admin, ' ') }}
            </span>
          </div>

          <div class="items-center justify-center gap-3 dropdown dropdown-top dropdown-end hidden lg:flex">
            <div tabindex="0" role="button" class="normal-case btn btn-ghost btn-circle">
              <i class="fa fa-ellipsis-v"></i>
            </div>
            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-32 p-2 mt-2 shadow">
              <li>
                <livewire:components.logout />
              </li>
              <li>
                <a wire:navigate href="{{ route('admin.profile') }}" class="flex items-center gap-2 text-base-content">
                  <i class="fa-solid fa-user"></i>
                  Profile
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </ul>
  @push('scripts')
    <script>
      function persistScroll() {
        const KEY = 'sidebar:scrollTop';
        return {
          init() {
            this.restore();
            // simpan scroll
            this.$refs.box?.addEventListener('scroll', () => {
              sessionStorage.setItem(KEY, String(this.$refs.box.scrollTop));
            }, {
              passive: true
            });

            // restore scroll
            document.addEventListener('livewire:navigated', () => this.restore());
            window.addEventListener('popstate', () => this.restore());
          },
          restore() {
            const v = sessionStorage.getItem(KEY);
            if (this.$refs.box && v !== null) {
              this.$refs.box.scrollTop = parseInt(v, 10) || 0;
            }
          }
        }
      }
    </script>
  @endpush

</div>
