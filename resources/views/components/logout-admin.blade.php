<?php

use App\Http\Controllers\Auth\Admin\Utils\Logout;
use Livewire\Volt\Component;
use Masmerise\Toaster\Toastable;

new class extends Component {
  use Toastable;
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        redirect()->route('admin.login')->success('You have been logged out successfully.');
    }
}; ?>

<li>
  <button class="normal-case text-red-500 flex items-center gap-2" wire:click="logout">
    <i class="fa-solid fa-right-from-bracket"></i>
    Logout
  </button>
</li>
