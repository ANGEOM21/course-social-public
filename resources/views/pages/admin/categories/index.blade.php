<div>
    <title>Manajemen Kategori - {{ $app_name }}</title>
  <div
    class="p-4 sm:p-6 bg-base-100 rounded-xl shadow-sm border border-base-300 min-h-[calc(100vh-40px)] flex flex-col justify-between gap-10">

    {{-- KONTEN UTAMA --}}
    <div>
      {{-- Header --}}
      <div class="flex flex-col sm:flex-row items-center justify-between mb-8 gap-4">
        <div>
          <h1 class="text-2xl font-bold text-base-content">Manajemen Kategori</h1>
          <p class="text-sm text-base-content/60 mt-1">Kelola semua kategori produk atau konten Anda di sini.</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
          <label class="input input-bordered flex items-center gap-3 flex-grow max-w-md shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" class="w-4 h-4 opacity-70"><path fill-rule="evenodd" d="M9.965 11.026a5 5 0 1 1 1.06-1.06l2.755 2.754a.75.75 0 1 1-1.06 1.06l-2.755-2.754ZM10.5 7a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Z" clip-rule="evenodd" /></svg>
            <input wire:model.live.debounce.300ms="search" type="text" class="grow placeholder:text-base-content/50" placeholder="Cari kategori..." />
            <div wire:loading wire:target="search" class="loading loading-spinner loading-xs"></div>
          </label>
          <button wire:click="create" class="btn btn-primary shadow-md hover:shadow-lg transition-all duration-200">
            <i class="fa-solid fa-plus"></i>
            Tambah Baru
          </button>
        </div>
      </div>

      {{-- Loading Utama --}}
      <div wire:loading.flex class="items-center justify-center w-full my-8 py-8">
        <div class="text-center"><span class="loading loading-lg loading-spinner text-primary mb-2"></span><p class="text-base-content/60 text-sm">Memuat data...</p></div>
      </div>

      {{-- Konten Grid --}}
      <div wire:loading.remove class="fade-in">
        @if ($categories->isEmpty())
          <div class="text-center py-16 px-4">
            <div class="max-w-xs mx-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-base-content/20 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
              <h3 class="text-lg font-medium text-base-content mb-2">Belum ada kategori</h3>
              <p class="text-base-content/60 text-sm mb-4">Mulai dengan membuat kategori pertama Anda.</p>
              <button wire:click="create" class="btn btn-primary btn-sm">Buat Kategori Pertama</button>
            </div>
          </div>
        @else
          @if ($search)
            <div class="mb-4 px-1"><p class="text-sm text-base-content/60">Menampilkan hasil untuk "<span class="font-medium">{{ $search }}</span>" · {{ $categories->total() }} hasil ditemukan</p></div>
          @endif

          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
            @foreach ($categories as $category)
              {{-- Pastikan wire:key tetap ada untuk menghindari bug rendering --}}
              <div wire:key="category-{{ $category->id_category }}" class="card bg-base-100 shadow-sm hover:shadow-lg border border-base-300/80 transition-all duration-300 hover:-translate-y-1 group overflow-hidden">
                <figure class="aspect-video bg-base-200">
                  @if ($category->img_category)
                    <img src="{{ Storage::url($category->img_category) }}" alt="{{ $category->name_category }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                  @else
                    <div class="w-full h-full flex items-center justify-center"><i class="fa-solid fa-image text-4xl text-base-content/20"></i></div>
                  @endif
                </figure>
                <div class="card-body p-4">
                  <h2 class="card-title text-base font-semibold group-hover:text-primary transition-colors truncate" title="{{ $category->name_category }}">{{ $category->name_category }}</h2>
                  <div class="flex items-center gap-1.5 text-xs text-base-content/50 mt-1"><i class="fa-regular fa-clock"></i><span>Dibuat: {{ $category->created_at?->diffForHumans() }}</span></div>
                  <div class="card-actions justify-end mt-4 pt-3 border-t border-base-200">
                    <button wire:click="edit({{ $category->id_category }})" class="btn btn-xs btn-outline btn-info hover:text-white"><i class="fa-solid fa-pencil"></i> Edit</button>
                    <button wire:click="delete({{ $category->id_category }})" wire:confirm="Anda yakin ingin menghapus kategori '{{ $category->name_category }}'? Tindakan ini tidak dapat dibatalkan." class="btn btn-xs btn-outline btn-error hover:text-white"><i class="fa-solid fa-trash-can"></i> Hapus</button>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>

    {{-- Pagination --}}
    @if ($categories->hasPages())
      <div class="mt-8 pt-6 border-t border-base-200 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="text-sm text-base-content/60">Menampilkan {{ $categories->firstItem() }} - {{ $categories->lastItem() }} dari {{ $categories->total() }} hasil</div>
        <div class="flex items-center gap-4">
          <div class="flex items-center gap-2"><span class="text-sm text-nowrap">Per halaman:</span><select wire:model.live="perPage" class="select select-bordered select-sm bg-base-100"><option value="10">10</option><option value="15">15</option><option value="20">20</option><option value="25">25</option></select></div>
          {{ $categories->links('vendor.pagination.daisyui') }}
        </div>
      </div>
    @endif
  </div>

  <!-- ================================================================= -->
  <!-- MENGGUNAKAN KOMPONEN MODAL KUSTOM ANDA                            -->
  <!-- ================================================================= -->
  <x-modal
      wire:model="categoryModal"
      id="category-modal"
      :title="$isEdit ? 'Edit Kategori' : 'Buat Kategori Baru'"
      :subtitle="$isEdit ? 'Ubah informasi kategori yang dipilih.' : 'Tambahkan kategori baru ke dalam sistem.'"
      separator
      box-class="max-w-md"
    >

    {{-- Loading overlay untuk form --}}
    <div wire:loading wire:target="save, img_category" class="absolute inset-0 bg-base-100/80 rounded-xl flex items-center justify-center z-10">
      <div class="text-center"><span class="loading loading-spinner loading-lg text-primary mb-2"></span><p class="text-sm text-base-content/60"><span wire:loading wire:target="save">Menyimpan...</span><span wire:loading wire:target="img_category">Mengunggah...</span></p></div>
    </div>

    {{-- Form --}}
    <form wire:submit="save">
      <div class="space-y-6">
        <label class="form-control w-full">
          <div class="label"><span class="label-text font-medium">Nama Kategori</span></div>
          <input wire:model="name_category" type="text" placeholder="Contoh: Pemrograman Web" class="input input-bordered w-full focus:input-primary" autofocus />
          @error('name_category')<div class="label"><span class="label-text-alt text-error">{{ $message }}</span></div>@enderror
        </label>
        <div x-data="{ isDragging: false }" class="w-full">
          <div class="label"><span class="label-text font-medium">Gambar Kategori (Opsional)</span></div>
          <div @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false" @drop.prevent="isDragging = false; const files = $event.dataTransfer.files; if (files.length > 0) { $wire.upload('img_category', files[0]) }" :class="{ 'border-primary bg-primary/10': isDragging }" class="relative flex flex-col items-center justify-center w-full aspect-video border-2 border-dashed border-base-300 rounded-lg cursor-pointer transition-all duration-300">
            <div class="w-full h-full">
              @if ($img_category)<img src="{{ $img_category->temporaryUrl() }}" class="w-full h-full object-cover rounded-lg">
              @elseif ($existing_img_category)<img src="{{ Storage::url($existing_img_category) }}" class="w-full h-full object-cover rounded-lg">
              @else<div class="flex flex-col items-center justify-center h-full text-base-content/50"><i class="fa-solid fa-camera text-4xl mb-3"></i><p class="text-sm font-semibold">Drag & drop atau klik di sini</p><p class="text-xs mt-1">PNG, JPG, WEBP (maks. 2MB)</p></div>
              @endif
            </div>
            <input type="file" wire:model="img_category" class="hidden" x-ref="fileInput">
            <button type="button" @click="$refs.fileInput.click()" class="absolute inset-0 w-full h-full z-5"></button>
          </div>
          @error('img_category')<div class="label"><span class="label-text-alt text-error">{{ $message }}</span></div>@enderror
        </div>
      </div>
    </form>

    {{-- Slot untuk Actions --}}
    <x-slot:actions>
        {{-- Tombol Batal akan menutup modal dan mereset form --}}
        <button @click="$wire.set('categoryModal', false); $wire.resetForm()" class="btn btn-ghost">Batal</button>
        {{-- Tombol Simpan akan memanggil method `save` --}}
        <button wire:click="save" class="btn btn-primary shadow-md">
            {{ $isEdit ? 'Update Kategori' : 'Simpan Kategori' }}
        </button>
    </x-slot:actions>
  </x-modal>

  <style>
    .fade-in { animation: fadeIn 0.4s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
  </style>
</div>