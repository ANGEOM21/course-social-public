<div>
  <title> {{ isset($title) ? $title : 'Manajemen Kursus' }} - {{ $app_name }}</title>
  <div
    class="p-4 sm:p-6 bg-base-100 rounded-xl shadow-sm border border-base-300 min-h-[calc(100vh-40px)] flex flex-col justify-between gap-10">

    {{-- KONTEN UTAMA --}}
    <div>
      {{-- Header --}}
      <div class="flex flex-col sm:flex-row items-center justify-between mb-8 gap-4">
        <div>
          <h1 class="text-2xl font-bold text-base-content">Manajemen Kursus</h1>
          <p class="text-sm text-base-content/60 mt-1">Kelola semua kursus yang tersedia di platform.</p>
        </div>
        <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
          <label class="input input-bordered flex items-center gap-3 flex-grow max-w-md shadow-sm">
            <i class="fa-solid fa-search opacity-70"></i>
            <input wire:model.live.debounce.300ms="search" type="text" class="grow placeholder:text-base-content/50"
              placeholder="Cari kursus, kategori, atau mentor..." />
            <div wire:loading wire:target="search" class="loading loading-spinner loading-xs"></div>
          </label>
          <button wire:click="create" class="btn btn-primary shadow-md hover:shadow-lg transition-all duration-200">
            <i class="fa-solid fa-plus"></i>
            Tambah Kursus
          </button>
        </div>
      </div>

      {{-- Konten Grid --}}
      <div class="fade-in">
        @if ($courses->isEmpty())
          <div class="text-center py-16 px-4">
            <div class="max-w-xs mx-auto">
              <i class="fa-solid fa-graduation-cap text-6xl text-base-content/20 mb-4"></i>
              <h3 class="text-lg font-medium text-base-content mb-2">Belum ada kursus</h3>
              <p class="text-base-content/60 text-sm mb-4">Mulai dengan menambahkan kursus pertama Anda.</p>
              <button wire:click="create" class="btn btn-primary btn-sm">Buat Kursus Pertama</button>
            </div>
          </div>
        @else
          {{-- Grid Kursus --}}
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
            @foreach ($courses as $course)
              <div wire:key="course-{{ $course->id_course }}"
                class="card bg-base-100 shadow-sm hover:shadow-lg border border-base-300/80 transition-all duration-300 hover:-translate-y-1 group">
                <div class="card-body p-5">
                  <div class="flex justify-between items-start">
                    <div>
                      <div class="badge badge-primary badge-outline">
                        {{ $course->tbl_category->name_category ?? 'Tanpa Kategori' }}</div>
                    </div>
                    <div class="avatar" title="Mentor: {{ $course->tbl_admin->name_admin ?? 'N/A' }}">
                      <div class="w-10 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                        <img
                          src="{{ $course->tbl_admin->img_admin ? Storage::url($course->tbl_admin->img_admin) : 'https://ui-avatars.com/api/?name=' . urlencode($course->tbl_admin->name_admin ?? 'M') . '&background=random' }}" />
                      </div>
                    </div>
                  </div>
                  <h2 class="card-title mt-2 font-semibold group-hover:text-primary transition-colors truncate"
                    title="{{ $course->name_course }}">
                    {{ $course->name_course }}
                  </h2>
                  <p class="text-sm text-base-content/60 mt-1 line-clamp-2">
                    @if ($course->desc_course)
                      {!! Illuminate\Support\Str::limit(strip_tags($course->desc_course), 100) !!}
                    @else
                      <span class="italic text-base-content/40">Tidak ada deskripsi tersedia.</span>
                    @endif
                  </p>
                  <div class="card-actions justify-end mt-4 pt-3 border-t border-base-200">
                    <a href="{{ route('admin.courses.detail', [
                      'slug_course' => $course->slug
                    ]) }}"
                      class="btn btn-xs btn-outline btn-ghost">
                      <i class="fa-solid fa-eye"></i>
                      Detail
                    </a>
                    <button wire:click="edit({{ $course->id_course }})"
                      class="btn btn-xs btn-outline btn-info hover:text-white">
                      <i class="fa-solid fa-pencil"></i>
                      Edit
                    </button>
                    <button wire:click="delete({{ $course->id_course }})"
                      wire:confirm.prompt="Anda yakin? Ini akan menghapus kursus dan semua modul di dalamnya.\n\nKetik 'HAPUS' untuk konfirmasi.|HAPUS"
                      class="btn btn-xs btn-outline btn-error hover:text-white">
                      <i class="fa-solid fa-trash-can"></i>
                      Hapus
                    </button>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>

    {{-- Pagination --}}
    @if ($courses->hasPages())
      <div class="mt-8 pt-6 border-t border-base-200 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="text-sm text-base-content/60">Menampilkan {{ $courses->firstItem() }} - {{ $courses->lastItem() }}
          dari {{ $courses->total() }} hasil</div>
        <div class="flex items-center gap-4">
          <div class="flex items-center gap-2"><span class="text-sm text-nowrap">Per halaman:</span><select
              wire:model.live="perPage" class="select select-bordered select-sm bg-base-100">
              <option value="10">10</option>
              <option value="15">15</option>
              <option value="20">20</option>
              <option value="25">25</option>
            </select></div>
          {{ $courses->links('pagination::daisyui') }}
        </div>
      </div>
    @endif
  </div>


  {{-- MODAL UNTUK CREATE DAN EDIT --}}
  <x-modal wire:model="courseModal" :title="$isEdit ? 'Edit Kursus' : 'Tambah Kursus Baru'" :subtitle="$isEdit ? 'Ubah informasi kursus yang dipilih.' : 'Tambahkan kursus baru ke dalam sistem.'" separator box-class="max-w-3xl">

    <form wire:submit="save" class="space-y-4">
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text font-medium">
            Nama Kursus
          </span>
        </label>
        <input type="text" placeholder="Contoh: Belajar Laravel dari Dasar" class="input input-bordered w-full"
          wire:model="name_course" autofocus />
        @error('name_course')
          <span class="text-error text-xs mt-1">{{ $message }}</span>
        @enderror
      </div>
      {{-- GANTI BLOK TRIX LAMA DENGAN INI --}}
      <div class="form-control w-full">
        <label class="label">
          <span class="label-text font-medium">
            Deskripsi Lengkap
          </span>
        </label>
        <div wire:ignore x-data="{
            value: @entangle('desc_course'),
            init() {
                this.$refs.trix.editor.loadHTML(this.value || '');
                this.$refs.trix.addEventListener('trix-change', () => {
                    this.value = this.$refs.trix.value;
                });
                this.$watch('value', (newValue) => {
                    if (newValue !== this.$refs.trix.value) {
                        this.$refs.trix.editor.loadHTML(newValue || '');
                    }
                });
            }
        }">
          <input id="desc_course_editor" type="hidden">
          <trix-editor x-ref="trix" input="desc_course_editor" class="trix-content bg-base-100"></trix-editor>
        </div>
        @error('desc_course')
          <span class="text-error text-xs mt-1">{{ $message }}</span>
        @enderror
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text font-medium">
              Kategori
            </span>
          </label>
          <select class="select select-bordered" wire:model="category_id">
            <option value="">Pilih Kategori</option>
            @foreach ($categories as $category)
              <option value="{{ $category->id_category }}"
                {{ old('category_id') == $category->id_category ? 'selected' : '' }}>{{ $category->name_category }}
              </option>
            @endforeach
          </select>
          @error('category_id')
            <span class="text-error text-xs mt-1">{{ $message }}</span>
          @enderror
        </div>
        <div class="form-control w-full">
          <label class="label">
            <span class="label-text font-medium">
              Mentor
            </span>
          </label>
          <select class="select select-bordered" wire:model="mentor_id">
            <option value="">Pilih Mentor</option>
            @foreach ($mentors as $mentor)
              <option value="{{ $mentor->id_admin }}" {{ old('mentor_id') == $mentor->id_admin ? 'selected' : '' }}>
                {{ $mentor->name_admin }}</option>
            @endforeach
          </select>
          @error('mentor_id')
            <span class="text-error text-xs mt-1">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="modal-action">
        <button @click="$wire.set('courseModal', false); $wire.resetForm()" class="btn btn-ghost">Batal</button>
        <button type="submit" class="btn btn-primary">
          {{ $isEdit ? 'Simpan Perubahan' : 'Buat Kursus' }}
        </button>

      </div>
    </form>
  </x-modal>
</div>
