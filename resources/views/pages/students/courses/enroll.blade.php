<div>
  <title>{{ $title }} - {{ $app_name }}</title>

  {{-- Layout Utama --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-4 md:mt-8 mb-12 p-4 md:p-8 ">

    {{-- Kolom Kiri: Detail Kursus & Daftar Modul --}}
    <div class="lg:col-span-2 space-y-8">
      {{-- Card Detail Kursus --}}
      <div class="card bg-base-100 shadow-lg border border-base-300">
        <div class="card-body">
          <h1 class="card-title text-3xl font-bold !leading-tight mb-4">{{ $course->name_course }}</h1>
          <div class="flex flex-wrap items-center gap-x-6 gap-y-3 mb-4">
            <div class="flex items-center gap-2" title="Mentor">
              <div class="avatar">
                <div class="w-8 rounded-full"><img
                    src="{{ $course->tbl_admin?->img_admin ? Storage::url($course->tbl_admin->img_admin) : 'https://ui-avatars.com/api/?name=' . urlencode($course->tbl_admin?->name_admin ?? 'M') }}" />
                </div>
              </div>
              <span class="font-semibold">{{ $course->tbl_admin?->name_admin ?? 'N/A' }}</span>
            </div>
            <div class="flex items-center gap-2" title="Kategori">
              <i class="fa-solid fa-folder-open text-primary"></i>
              <span class="font-semibold">{{ $course->tbl_category?->name_category ?? 'N/A' }}</span>
            </div>
            <div class="flex items-center gap-2" title="Jumlah Modul">
              <i class="fa-solid fa-file-video text-primary"></i>
              <span class="font-semibold">{{ $modules->count() }} Modul</span>
            </div>
          </div>
          <div class="prose max-w-none mt-2 text-base-content/80">
            @if ($course->desc_course)
              {!! $course->desc_course !!}
            @else
              <p class="italic">Tidak ada deskripsi.</p>
            @endif
          </div>
        </div>
      </div>

      {{-- Card Daftar Modul --}}
      <div class="card bg-base-100 shadow-lg border border-base-300">
        <div class="card-body">
          <h2 class="card-title mb-4">Materi Kursus</h2>
          <div class="space-y-3">
            @forelse ($modules as $index => $module)
              <div class="collapse collapse-arrow bg-base-200">
                <input type="checkbox" name="module-accordion-{{ $module->id_module }}" />
                <div class="collapse-title text-md font-medium">
                  #{{ $index + 1 }} {{ $module->title }}
                </div>
                <div class="collapse-content">
                  <div class="prose prose-sm max-w-none">
                    @if ($module->description)
                      {!! $module->description !!}
                    @else
                      <p class="italic">Tidak ada deskripsi untuk modul ini.</p>
                    @endif
                  </div>
                </div>
              </div>
            @empty
              <div class="text-center text-sm text-base-content/50 py-6">
                <p>Modul untuk kursus ini akan segera tersedia.</p>
              </div>
            @endforelse
          </div>
        </div>
      </div>
    </div>

    {{-- Kolom Kanan: Tombol Aksi & Info --}}
    <div class="lg:col-span-1">
      <div class="card bg-base-100 shadow-lg border border-base-300 sticky top-6">
        <figure>
          @if ($course->tbl_category?->img_category && Storage::disk('public')->exists($course->tbl_category->img_category))
            <img src="{{ Storage::url($course->tbl_category->img_category) }}" alt="{{ $course->name_course }}"
              class="w-full h-48 object-cover" />
          @else
            <div class="w-full h-48 bg-gradient-to-br from-base-200 to-base-300 flex items-center justify-center"><i
                class="fa-solid fa-book-open text-5xl text-base-content/30"></i></div>
          @endif
        </figure>
        <div class="card-body">
          {{-- Tombol Pendaftaran --}}
          <button wire:click="enroll" class="btn btn-primary btn-lg btn-block" wire:loading.attr="disabled">
            <span wire:loading.remove wire:target="enroll">Ambil Kursus Ini</span>
            <span wire:loading wire:target="enroll" class="loading loading-spinner"></span>
          </button>
          <div class="divider">atau</div>
          <a wire:navigate href="{{ route('student.catalog') }}" class="btn btn-ghost btn-block">Kembali ke Katalog</a>
        </div>
      </div>
    </div>
  </div>
</div>
