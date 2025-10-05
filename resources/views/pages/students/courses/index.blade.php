<div>
  <title>{{ $title }} - {{ $app_name }}</title>

  {{-- Hero Section --}}
  <section class="py-16 bg-gradient-to-r from-primary to-secondary text-white">
    <div class="container mx-auto px-4">
      <h1 class="text-4xl font-bold">Kursus Saya</h1>
      <p class="text-lg text-base-100/80">Lanjutkan perjalanan belajar Anda dan raih keahlian baru.</p>
    </div>
  </section>

  {{-- Konten Utama --}}
  <div class="container mx-auto px-4 pt-8 pb-12">
    @if ($enrolledCourses->isEmpty())
      <div class="text-center py-20 bg-base-100 rounded-2xl shadow-sm border border-base-300">
        <i class="fa-solid fa-book-open-reader text-8xl text-base-content/10 mb-6"></i>
        <h3 class="text-2xl font-bold text-base-content mb-3">Anda Belum Memiliki Kursus</h3>
        <p class="text-base-content/60 max-w-md mx-auto mb-6">
          Sepertinya Anda belum mendaftar di kursus mana pun. Jelajahi katalog kami untuk memulai!
        </p>
        <a href="{{ route('student.catalog') }}" class="btn btn-primary btn-lg" wire:navigate>
          <i class="fa-solid fa-compass mr-2"></i>
          Jelajahi Katalog Kursus
        </a>
      </div>
    @else
      <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach ($enrolledCourses as $course)
          <div wire:key="enrolled-course-{{ $course->id_course }}"
            class="card bg-base-100 shadow-lg border border-base-300 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 group overflow-hidden">
            <figure class="aspect-video relative overflow-hidden">
              @if ($course->tbl_category?->img_category && Storage::disk('public')->exists($course->tbl_category->img_category))
                <img src="{{ Storage::url($course->tbl_category->img_category) }}" alt="{{ $course->name_course }}"
                  class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
              @else
                <div class="w-full h-full bg-gradient-to-br from-base-200 to-base-300 flex items-center justify-center">
                  <i class="fa-solid fa-book-open text-5xl text-base-content/30"></i></div>
              @endif
            </figure>
            <div class="card-body p-6 flex flex-col justify-between">
              <div>
                <div class="badge badge-primary badge-outline mb-2">{{ $course->tbl_category?->name_category ?? 'N/A' }}
                </div>
                <h2
                  class="card-title text-lg font-bold group-hover:text-primary transition-colors line-clamp-2 leading-tight h-14">
                  <a wire:navigate href="#" class="hover:no-underline">{{ $course->name_course }}</a>
                </h2>
              </div>

              <div class="mt-4">
                {{-- Progress Bar --}}
                @php $progress = $progressData[$course->id_course] ?? 0; @endphp
                <div class="flex justify-between text-xs mb-1">
                  <span class="font-semibold">Progress</span>
                  <span class="font-bold text-primary">{{ $progress }}%</span>
                </div>
                <progress class="progress progress-primary w-full" value="{{ $progress }}"
                  max="100"></progress>

                <div class="card-actions mt-4">
                  <a wire:navigate href="#" class="btn btn-primary btn-block group/btn">
                    <span>Lanjutkan Belajar</span>
                    <i class="fa-solid fa-arrow-right ml-2 transition-transform group-hover/btn:translate-x-1"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Pagination --}}
      @if ($enrolledCourses->hasPages())
        <div class="mt-12 flex justify-center">
          <div class="join shadow-lg">{{ $enrolledCourses->links('pagination::daisyui') }}</div>
        </div>
      @endif
    @endif
    </main>
  </div>
</div>
