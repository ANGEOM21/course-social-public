<?php
use App\Http\Controllers\Auth\Admin\Utils\LoginForm;

use Illuminate\Support\Facades\Session;
use Livewire\Volt\Component;

new class extends Component {
    public LoginForm $form;
    public $passwordVisible = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();

        Session::regenerate();

        auth('admins')->user()->last_login_at = now();
        auth('admins')->user()->save();

        $this->redirectIntended(default: route('admin.dashboard', absolute: false), navigate: true);
    }

    public function togglePasswordVisibility()
    {
        $this->passwordVisible = !$this->passwordVisible;
    }
}; ?>

<div class="card-body rounded-box">
  <title>Login {{ $app_name }}</title>
  <!-- Session Status -->
  <x-auth-session-status class="mb-4" :status="session('status')" />

  <form wire:submit.prevent="login">
    <!-- Username Address -->
    <div class="form-control">
      <x-input-label for="email" :value="__('Email')" />
      <x-text-input wire:model="form.email" id="email"
        class="block mt-1 w-full {{ $errors->has('form.email') ? 'input-error' : '' }}" type="text" name="email"
        required autofocus autocomplete="email" :placeholder="__('Masukan email anda')" />
      <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
    </div>
    <!-- Password -->
    <div class="form-control my-3">
      <x-input-label for="password" :value="__('Password')" />
      <label class="input input-bordered flex items-center gap-2 w-full">
        <input wire:model="form.password" id="password"
          class="block mt-1 w-full  {{ $errors->has('form.password') ? 'input-error' : '' }}"
          type="{{ $this->passwordVisible ? 'text' : 'password' }}" name="password" required
          autocomplete="current-password" placeholder="Masukan password anda" />
        <button type="button" wire:click="togglePasswordVisibility">
          <i class="fa {{ $this->passwordVisible ? 'fa-eye' : 'fa-eye-slash' }}"></i>
        </button>
      </label>
      <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
    </div>

    <!-- Remember Me -->
    <div class="form-control mt-4">
      <div class="flex justify-between items-center">
        <label for="remember" class="inline-flex items-center cursor-pointer">
          <input wire:model="form.remember" id="remember" type="checkbox" class="checkbox checkbox-primary checkbox-xs"
            name="remember">
          <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>
      </div>
    </div>

    <div class="flex items-center justify-end mt-4">
      <x-primary-button class="w-full">
        {{ __('Log in') }}
      </x-primary-button>
    </div>
  </form>
</div>
