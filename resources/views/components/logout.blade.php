<?php

use App\Geomlive\Utils\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<li>
  <button class="normal-case text-red-500 flex items-center gap-2" wire:click="logout">
    <i class="fa-solid fa-right-from-bracket"></i>
    Logout
  </button>
</li>
