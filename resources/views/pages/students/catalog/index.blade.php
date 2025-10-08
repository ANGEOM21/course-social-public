<div>
  <title>{{ $title }} - {{ $app_name }}</title>

  {{-- Hero Section --}}
  <section class="py-16 bg-gradient-to-r from-primary to-secondary text-primary-content">
    <div class="container mx-auto px-4 text-center">
      <h1 class="text-5xl font-bold mb-4">Temukan Kursus Berikutnya</h1>
      <p class="text-xl opacity-90 max-w-2xl mx-auto">Perluas wawasan dan tingkatkan keahlian Anda bersama kami.</p>
    </div>
  </section>

  {{--  Filter & Daftar Kursus --}}
  <div class="container mx-auto px-4 pt-8 pb-12">
    <div class="card bg-base-100 shadow-lg border border-base-300 mb-8">
      <div class="card-body p-6 flex flex-col md:flex-row items-center gap-4">
        <div class="w-full md:flex-1">
          <label class="input input-bordered flex items-center gap-3"><i class="fa-solid fa-search opacity-60"></i><input
              wire:model.live.debounce.300ms="search" type="text" class="grow placeholder:opacity-60"
              placeholder="Ketik judul kursus..." /></label>
        </div>
        <div class="w-full md:w-auto md:min-w-64">
          <select wire:model.live="category" class="select select-bordered w-full">
            <option value="">Semua Kategori</option>
            @foreach ($categories as $cat)
              <option value="{{ $cat->slug }}">{{ $cat->name_category }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>

    {{-- Konten Utama --}}
    <main class="w-full">
      <div class="flex justify-between items-center gap-4 mb-6">
        <h2 class="text-2xl font-bold text-base-content">Kursus yang Tersedia Untuk Anda</h2>
        <p class="text-base-content/60 text-sm">Menampilkan {{ $courses->count() }} dari {{ $courses->total() }} kursus
        </p>
      </div>

      @if ($courses->isEmpty())
        <div class="text-center py-20 bg-base-100 rounded-2xl shadow-sm border border-base-300">
          @if ($isFiltered)
            <i class="fa-solid fa-magnifying-glass text-8xl text-base-content/10 mb-6"></i>
            <h3 class="text-2xl font-bold text-base-content mb-3">Kursus Tidak Ditemukan</h3>
            <p class="text-base-content/60 max-w-md mx-auto mb-6">
              Maaf, tidak ada kursus yang sesuai dengan pencarian Anda. Coba gunakan kata kunci atau filter yang
              berbeda.
            </p>
            <button class="btn btn-primary" wire:click="resetFilters">
              <i class="fa-solid fa-rotate-left mr-2"></i>
              Reset Filter
            </button>
          @else
            <i class="fa-solid fa-face-laugh-beam text-8xl text-base-content/10 mb-6"></i>
            <h3 class="text-2xl font-bold text-base-content mb-3">Luar Biasa!</h3>
            <p class="text-base-content/60 max-w-md mx-auto">
              Anda telah mendaftar di semua kursus yang tersedia saat ini. Nantikan kursus baru dari kami!
            </p>
          @endif
        </div>
      @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
          @foreach ($courses as $course)
            <div wire:key="catalog-course-{{ $course->id_course }}"
              class="card bg-base-100 shadow-lg border border-base-300 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 group overflow-hidden">
              <figure class="aspect-video relative overflow-hidden">
                @if ($course->tbl_category?->img_category && Storage::disk('public')->exists($course->tbl_category->img_category))
                  <img src="{{ Storage::url($course->tbl_category->img_category) }}" alt="{{ $course->name_course }}"
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                @else
                  <div
                    class="w-full h-full bg-gradient-to-br from-base-200 to-base-300 flex items-center justify-center">
                    <i class="fa-solid fa-book-open text-5xl text-base-content/30"></i>
                  </div>
                @endif
                <div class="absolute top-4 left-4">
                  <div class="badge badge-primary badge-lg font-semibold shadow-md">
                    {{ $course->tbl_category?->name_category ?? 'N/A' }}</div>
                </div>
              </figure>
              <div class="card-body p-6">
                <h2
                  class="card-title text-lg font-bold group-hover:text-primary transition-colors line-clamp-2 leading-tight h-14">
                  <a wire:navigate href="#" class="hover:no-underline">{{ $course->name_course }}</a>
                </h2>
                <div class="flex items-center gap-3 mt-4 pt-4 border-t border-base-300">
                  <div class="avatar">
                    <div class="w-10 rounded-full ring-2 ring-base-300"><img
                        src="{{ $course->tbl_admin?->img_admin ? Storage::url($course->tbl_admin->img_admin) : 'https://ui-avatars.com/api/?name=' . urlencode($course->tbl_admin?->name_admin ?? '?') }}"
                        alt="{{ $course->tbl_admin?->name_admin ?? 'N/A' }}" /></div>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="font-medium text-sm text-base-content truncate">
                      {{ $course->tbl_admin?->name_admin ?? 'N/A' }}</p>
                    <p class="text-xs text-base-content/60">{{ $course->tbl_admin?->role ?? 'N/A' }}</p>
                  </div>
                </div>
                <div class="card-actions justify-between items-center mt-6">
                  <div class="rating rating-sm rating-half items-center">
                    <input type="radio" class="rating-hidden" checked disabled />
                    @php
                      $rating = $course->average_rating ?? 0;
                      $feedbackCount = $course->tbl_feedbacks->count();
                    @endphp
                    @for ($i = 1; $i <= 10; $i++)
                      <input type="radio" @class([
                          'bg-yellow-400 mask mask-star-2',
                          'mask-half-2' => $i % 2 == 0,
                          'mask-half-1' => $i % 2 != 0,
                      ])
                        {{ round($rating * 2) == $i ? 'checked' : '' }} disabled />
                    @endfor
                  </div>
                  @if (in_array($course->id_course, $enrolledCourseIds))
                    {{-- JIKA SUDAH MENDAFTAR --}}
                    <a wire:navigate href="{{ route('student.courses') }}" class="btn btn-primary btn-sm group/btn"
                      title="Anda sudah terdaftar di kursus ini">
                      <span>Buka Kursus</span>
                      <i class="fa-solid fa-arrow-right ml-2 transition-transform group-hover/btn:translate-x-1"></i>
                    </a>
                  @else
                    {{-- JIKA BELUM MENDAFTAR --}}
                    <a wire:navigate href="{{ route('student.course.enroll', ['course' => $course->slug]) }}"
                      class="btn btn-primary btn-outline btn-sm group/btn">
                      <span>Ambil Kursus</span>
                      <i class="fa-solid fa-arrow-right ml-2 transition-transform group-hover/btn:translate-x-1"></i>
                    </a>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @endif
      @if ($courses->hasPages())
        <div class="mt-12 flex justify-center">
          <div class="join shadow-lg">{{ $courses->links('pagination::daisyui') }}</div>
        </div>
      @endif
    </main>
  </div>
</div>
