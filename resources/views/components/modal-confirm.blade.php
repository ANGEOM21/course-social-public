<!-- Modal Component -->
<div
  x-data
  x-show="$store.confirmModal.isOpen"
  x-transition:enter="transition ease-out duration-300"
  x-transition:enter-start="opacity-0"
  x-transition:enter-end="opacity-100"
  x-transition:leave="transition ease-in duration-200"
  x-transition:leave-start="opacity-100"
  x-transition:leave-end="opacity-0"
  class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50"
  style="display: none;"
  @keydown.escape.window="$store.confirmModal.close()"
>

  <div 
      @click.outside="$store.confirmModal.close()"
      class="bg-white dark:bg-base-100 rounded-xl shadow-xl w-full max-w-md mx-auto p-6"
      x-transition:enter="transition ease-out duration-300"
      x-transition:enter-start="scale-90 opacity-0"
      x-transition:enter-end="scale-100 opacity-100"
      x-transition:leave="transition ease-in duration-200"
      x-transition:leave-start="scale-100 opacity-100"
      x-transition:leave-end="scale-90 opacity-0">

    {{-- Title --}}
    @if (isset($title))
      <h2 class="text-lg font-semibold mb-2">{{ $title }}</h2>
    @endif

    {{-- Slot --}}
    <div class="text-sm text-gray-700 mb-4">
      {{ $slot }}
    </div>

    {{-- Buttons --}}
    <div class="flex justify-end gap-2">
      <button @click="$store.confirmModal.close()" class="btn btn-sm">Batal</button>
      <button @click="$store.confirmModal.confirm()" class="btn btn-sm btn-error">Yakin</button>
    </div>
  </div>
</div>
