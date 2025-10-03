<div class="navbar p-0 w-full sticky top-0 z-50 lg:hidden bg-base-content">
  <div class="flex w-full px-4 items-center justify-between  py-2">
    <div class="flex-1">
      <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-circle btn-base-100 btn-sm">
        <i class="fa fa-bars"></i>
      </label>
    </div>
    <div class="flex items-center justify-center gap-3 dropdown dropdown-bottom dropdown-end">
      <span class="text-lg font-semibold max-w-[100px] truncate text-base-100">
        {{ Str::before(auth('admins')->user()->name_admin, ' ') }}
      </span>
      <div tabindex="0" role="button" class="normal-case avatar btn btn-ghost btn-circle ">
        <div class="w-10 rounded-full flex">
          <div class="bg-base-300 h-10 w-10 flex items-center justify-center">
            <img
              src="{{ auth('admins')->user()->img_admin
                  ? asset('storage/' . auth('admins')->user()->img_admin)
                  : 'https://ui-avatars.com/api/?name=' . urlencode(auth('admins')->user()->name_admin) }}"
              alt="User Avatar" class="w-10 h-10 rounded-full" />
          </div>
        </div>
      </div>
      <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-32 p-2 mt-2 shadow">
        <livewire:components.logout-admin />
        <li>
          <a href="{{ route('admin.profile') }}" wire:navigate class="flex items-center gap-2">
            <i class="fa-solid fa-user"></i>
            Profile
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
