<div class="my-3  bg-white rounded-t-badge rounded-b-3xl">
  <title>Profile - {{ config('app.name', 'Laravel') }}</title>

  <!-- BANNER -->
  <div class="relative w-full h-60 rounded-t-badge overflow-hidden">
    <img src="{{ asset('banner.png') }}" alt="Banner" class="w-full h-full object-cover "
      style="filter: blur(5px);" />
  </div>

  <!-- AVATAR + NAMA -->
  <div class="relative mt-[-4rem] flex items-center flex-col sm:flex-row sm:items-end sm:justify-between px-4">
    <!-- Avatar -->
    <div class="flex flex-col md:flex-row items-center gap-4">
      <livewire:layouts.profile.avatar-user-form />
      <div class="mt-3 sm:mt-0">
        <h1
          class="cursor-default text-3xl font-extrabold uppercase leading-tight bg-base-content sm:bg-base-100 shadow-[0_0_0_10px] bg-clip-text text-transparent drop-shadow select-none pointer-events-none">
          {{ Auth::guard('admins')->user()->name_admin }}</h1>
        <p class="text-md text-base-content font-semibold mt-2">{{ 'Perbarui informasi akun anda' }}</p>
      </div>
    </div>
  </div>

  <!-- FORM SECTION -->
  <div class="mt-6 flex flex-col md:flex-row justify-center items-start gap-10 max-w-5xl mx-auto px-6 py-4">
    <!-- Update Profile Info -->
    <div class="w-full md:w-1/2">
      <livewire:layouts.profile.update-profile-information-form />
    </div>

    <!-- Update Password -->
    <div class="w-full md:w-1/2">
      <livewire:layouts.profile.update-password-form />
    </div>
  </div>
</div>
