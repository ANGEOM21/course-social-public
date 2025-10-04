<div>
  <title>Detail Kursus - {{ $app_name }}</title>

  {{-- Breadcrumbs --}}
  <div class="breadcrumbs text-sm mb-2">
    <ul>
      <li><a wire:navigate href="{{ route('admin.courses.index') }}">Manajemen Kursus</a></li>
      <li class="truncate">{{ $course->name_course }}</li>
    </ul>
  </div>

  {{-- Layout Utama --}}
  <div class="grid grid-cols-1 gap-4">
    <div class="space-y-6">
      <div>
        <div class="card bg-base-100 shadow-lg border border-base-300">
          <div class="card-body">
            <div class="flex lg:flex-row lg:items-center lg:justify-between gap-6 flex-col-reverse">
              <div>
                <div class="flex flex-wrap items-center gap-4 mb-4">
                  <div class="flex items-center gap-2">
                    <div class="avatar" title="Mentor: {{ $course->tbl_admin?->name_admin ?? 'N/A' }}">
                      <div class="w-10 rounded-full">
                        <img
                          src="{{ $course->tbl_admin?->img_admin ? Storage::url($course->tbl_admin->img_admin) : 'https://ui-avatars.com/api/?name=' . urlencode($course->tbl_admin?->name_admin ?? 'M') }}"
                          loading="lazy" />
                      </div>
                    </div>
                    <div>
                      <div class="text-xs text-base-content/60">Mentor</div>
                      <div class="font-semibold">
                        {{ $course->tbl_admin?->name_admin ?? 'Tidak diketahui' }}
                      </div>
                    </div>
                  </div>
                  <div class="flex items-center gap-2"><i class="fa-solid fa-folder-open text-2xl text-primary"></i>
                    <div>
                      <div class="text-xs text-base-content/60">Kategori</div>
                      <div class="font-semibold">
                        {{ $course->tbl_category?->name_category ?? 'Tanpa Kategori' }}
                      </div>
                    </div>
                  </div>
                </div>
                <h1 class="card-title text-3xl font-bold !leading-tight">{{ $course->name_course }}</h1>
                <div class="prose max-w-none mt-4 text-base-content/80">
                  @if ($course->desc_course)
                    {!! $course->desc_course !!}
                  @else
                    <p class="italic">Tidak ada deskripsi untuk kursus ini.</p>
                  @endif
                </div>
                <div class="mt-6 flex flex-wrap gap-4">
                  <div class="badge badge-outline">
                    <i class="fa-solid fa-calendar-days mr-2"></i>
                    Dibuat pada {{ $course->created_at->translatedFormat('d F Y') }}
                  </div>
                  <div class="badge badge-outline">
                    <i class="fa-solid fa-file-video mr-2"></i>
                    {{ $modules->count() }} Modul
                  </div>
                  <div class="badge badge-outline">
                    <i class="fa-solid fa-users mr-2"></i>
                    {{ $course->enrollments_count ?? 0 }} Peserta Terdaftar
                  </div>
                </div>
              </div>
              <figure class="aspect-video bg-base-200 shadow-lg rounded-lg w-48 h-48 flex-shrink-0 group">
                @if ($course->tbl_category->img_category)
                  <img src="{{ Storage::url($course->tbl_category->img_category) }}" alt="{{ $course->tbl_category->name_category }}"
                    class="w-full h-full group-hover:scale-105 transition-transform duration-300" />
                @else
                  <div class="w-full h-full flex items-center justify-center"><i
                      class="fa-solid fa-image text-4xl text-base-content/20"></i></div>
                @endif
              </figure>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Manajemen Modul --}}
    <div class="space-y-6 w-full">
      <div class="card bg-base-100 shadow-lg border border-base-300">
        <div class="card-body">
          <div class="flex justify-between items-center mb-4">
            <h2 class="card-title">Manajemen Modul</h2>
            <button wire:click="createModule" class="btn btn-primary btn-sm">
              <i class="fa-solid fa-plus"></i>
              Tambah
            </button>
          </div>
          <div class="space-y-3">
            @forelse ($modules as $index => $module)
              <div wire:key="module-{{ $module->id_module }}" class="collapse collapse-arrow bg-base-200">
                <input type="checkbox" name="module-accordion" />
                <div class="collapse-title text-md font-medium flex justify-between items-center">
                  <span>
                    #{{ $index + 1 }} {{ $module->title }}
                  </span>
                </div>
                <div class="collapse-content flex justify-between items-start gap-4">
                  <div class="flex flex-col gap-1 w-full">
                    {{-- Deskripsi Modul --}}
                    <div class="prose prose-sm max-w-none">
                      @if ($module->description)
                        {!! $module->description !!}
                      @else
                        <p class="italic">Tidak ada deskripsi.</p>
                      @endif
                    </div>
                    <a wire:navigate
                      href="{{ route('admin.courses.detail.vidio', [
                          'slug_course' => $course->slug,
                          'slug_module' => $module->slug,
                      ]) }}"
                      class="btn btn-sm btn-outline btn-primary"><i class="fa-solid fa-play"></i> Putar Video</a>
                    <div class="mt-2 text-xs">
                      <strong>URL Video:</strong>
                      <a href="{{ $module->video_url }}" target="_blank" class="link link-primary">
                        {{ $module->video_url }}
                      </a>
                    </div>
                  </div>
                  <div class="flex gap-2" onclick="event.stopPropagation();">
                    <button wire:click="editModule({{ $module->id_module }})" class="btn btn-xs btn-ghost btn-circle"
                      title="Edit">
                      <i class="fa fa-pencil"></i>
                    </button>
                    <button wire:click="deleteModule({{ $module->id_module }})"
                      wire:confirm="Anda yakin ingin menghapus modul ini?"
                      class="btn btn-xs btn-ghost btn-circle text-error" title="Hapus">
                      <i class="fa fa-trash"></i>
                    </button>
                  </div>

                </div>
              </div>
            @empty
              <div class="text-center text-sm text-base-content/50 py-6">
                <p>Belum ada modul.</p>
                <p>Klik tombol "Tambah" untuk membuat modul pertama.</p>
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>


  {{-- MODAL UNTUK CREATE/EDIT MODUL (DIPERBARUI) --}}
  <x-modal wire:model="moduleModal" :title="$isEditModule ? 'Edit Modul' : 'Tambah Modul Baru'" separator box-class="max-w-3xl">
    <form wire:submit="saveModule" id="module-form" class="space-y-4">
      {{-- JUDUL MODUL --}}
      <div class="form-control w-full">
        <label class="label"><span class="label-text font-medium">Judul Modul</span></label>
        <input type="text" placeholder="Contoh: Instalasi & Setup Awal" class="input input-bordered w-full"
          wire:model="title" autofocus />
        @error('title')
          <span class="text-error text-xs mt-1">{{ $message }}</span>
        @enderror
      </div>

      {{-- URL VIDEO YOUTUBE --}}
      <div class="form-control w-full">
        <label class="label"><span class="label-text font-medium">URL Video YouTube</span></label>
        <input type="url" placeholder="https://www.youtube.com/watch?v=xxxx" class="input input-bordered w-full"
          wire:model="video_url" />
        @error('video_url')
          <span class="text-error text-xs mt-1">{{ $message }}</span>
        @enderror
      </div>

      {{-- DESKRIPSI MODUL (DENGAN TRIX) --}}
      <div class="form-control w-full">
        <label class="label"><span class="label-text font-medium">Deskripsi Modul (Opsional)</span></label>
        <div wire:ignore x-data x-init="const trixEditor = $refs.trix;
        trixEditor.addEventListener('trix-change', (event) => {
            $wire.set('description', event.target.value);
        });
        $el.closest('.modal').addEventListener('trix-update-module', (event) => {
            const newValue = event.detail.value;
            if (trixEditor.editor.html !== newValue) {
                trixEditor.editor.loadHTML(newValue || '');
            }
        });">
          <input id="module_description_editor" type="hidden">
          <trix-editor x-ref="trix" input="module_description_editor"
            class="trix-content bg-base-100"></trix-editor>
        </div>
        @error('description')
          <span class="text-error text-xs mt-1">{{ $message }}</span>
        @enderror
      </div>
    </form>

    <x-slot:actions>
      <button @click="$wire.set('moduleModal', false); $wire.resetForm()" class="btn btn-ghost">Batal</button>
      <button type="submit" form="module-form" class="btn btn-primary">
        {{ $isEditModule ? 'Simpan Perubahan' : 'Buat Modul' }}
      </button>
    </x-slot:actions>
  </x-modal>
</div>
