<?php
use Livewire\Volt\Component;

new class extends Component {
    public $activeTab = 'users';

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
        if ($tab === 'users') {
            $this->redirect(route('admin.settings.index'), navigate: true);
        }
    }
};
?>

<div>
  <title>Pengaturan Sistem - {{ $app_name }}</title>

  <div class="flex flex-wrap justify-between items-center mb-6 gap-4">
    <h1 class="text-2xl font-bold text-gray-800">
      <i class="fa fa-cogs mr-2"></i>Pengaturan Sistem
    </h1>
  </div>

  {{-- Tabs Lifted --}}
  <div role="tablist" class="tabs tabs-lift tabs-md md:tabs-lg">
    {{-- Tab 1 --}}
    <a role="tab" @class([
        'tab md:text-sm text-xs flex gap-3 items-center m-0',
        'tab-active' => $activeTab === 'users',
    ]) wire:click="switchTab('users')">
      <i class="fa fa-users"></i>
      <span class="hidden md:inline">
        Manajemen Pengguna
      </span>
    </a>
    <a role="tab" @class([
        'tab md:text-sm text-xs flex gap-3 items-center m-0',
        'tab-active' => $activeTab === 'students',
    ]) wire:click="switchTab('students')">
      <i class="fa fa-graduation-cap"></i>
      <span class="hidden md:inline">
        Para Murid
      </span>
    </a>
  </div>
  {{-- Konten Tab --}}
  <div class="bg-base-100 m-0 p-0 md:p-4">
    @if ($activeTab === 'users')
      <livewire:admin.settings.user-management :key="$activeTab === 'users' ? now()->timestamp : 'users'" />
    @elseif($activeTab === 'students')
      <livewire:admin.settings.students-management :key="$activeTab === 'students' ? now()->timestamp : 'students'" />
    @endif
  </div>
</div>
