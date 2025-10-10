<?php

use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\TblCourse;
use App\Models\TblProgress;

new class extends Component {
    // Properti untuk menyimpan data
    public $student;
    public $recentCourses;
    public int $enrolledCount = 0;
    public int $certificateCount = 0;
    public array $progressData = [];
    public array $resumeLinks = [];

    public function mount(): void
    {
        $this->student = Auth::user();
        $this->loadDashboardData();
    }

    public function loadDashboardData(): void
    {
        $this->student = Auth::user();

        $this->enrolledCount = $this->student->tbl_courses()->count();
        $this->certificateCount = $this->student->tbl_certificates()->count();

        $recentlyAccessedCourseIds = TblProgress::where('student_id', $this->student->id_student)->select('course_id', DB::raw('MAX(created_at) as last_accessed'))->groupBy('course_id')->orderByDesc('last_accessed')->take(3)->pluck('course_id')->toArray();

        $this->recentCourses = collect();
        $this->progressData = [];
        $this->resumeLinks = [];

        if (!empty($recentlyAccessedCourseIds)) {
            $this->recentCourses = TblCourse::with(['tbl_modules' => fn($q) => $q->orderBy('created_at', 'asc')])
                ->whereIn('id_course', $recentlyAccessedCourseIds)
                ->orderByRaw('FIELD(id_course, ?)', [$recentlyAccessedCourseIds])
                ->get();

            $allCompletedModuleIds = TblProgress::where('student_id', $this->student->id_student)->whereIn('course_id', $recentlyAccessedCourseIds)->pluck('module_id')->toArray();

            foreach ($this->recentCourses as $course) {
                $totalModules = $course->tbl_modules->count();
                $completedCount = $course->tbl_modules->whereIn('id_module', $allCompletedModuleIds)->count();

                $this->progressData[$course->id_course] = $totalModules > 0 ? round(($completedCount / $totalModules) * 100) : 100;

                if ($totalModules > 0) {
                    $firstUncompletedModule = $course->tbl_modules->first(function ($module) use ($allCompletedModuleIds) {
                        return !in_array($module->id_module, $allCompletedModuleIds);
                    });

                    if ($firstUncompletedModule) {
                        $this->resumeLinks[$course->id_course] = $firstUncompletedModule->slug;
                    } else {
                        $this->resumeLinks[$course->id_course] = $course->tbl_modules->first()->slug;
                    }
                } else {
                    $this->resumeLinks[$course->id_course] = null;
                }
            }
        }
    }
}; ?>

<div>
  <title>Dashboard - {{ $app_name ?? 'Kursus Online' }}</title>

  {{-- Hero Section dengan Sambutan --}}
  <section class="py-20 bg-gradient-to-l from-primary to-secondary text-base-100">
    <div class="container mx-auto px-4">
      <h1 class="text-4xl lg:text-5xl font-bold">Selamat Datang Kembali, <br class="sm:hidden" />
        {{ $student->name_student }}!</h1>
      <p class="text-lg lg:text-xl text-base-100/70 mt-2">Siap untuk melanjutkan perjalanan belajar Anda hari ini?</p>
    </div>
  </section>

  <div class="container mx-auto -mt-10 bg-base-100 p-4 rounded-t-2xl shadow">
    {{-- Grid Utama --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="lg:col-span-2 space-y-6">
        <h2 class="text-2xl font-bold">Lanjutkan Belajar</h2>

        @if ($recentCourses && $recentCourses->isNotEmpty())
          @foreach ($recentCourses as $course)
            <div wire:key="recent-course-{{ $course->id_course }}"
              class="card lg:card-side bg-base-100 shadow-lg border border-base-300">
              <figure class="w-full lg:w-1/3">
                @if ($course->tbl_category?->img_category && Storage::disk('public')->exists($course->tbl_category->img_category))
                  <img src="{{ Storage::url($course->tbl_category->img_category) }}" alt="{{ $course->name_course }}"
                    class="w-full h-48 lg:h-full object-cover" />
                @else
                  <div class="w-full h-48 lg:h-full bg-base-200 flex items-center justify-center"><i
                      class="fa-solid fa-book-open text-5xl text-base-content/20"></i></div>
                @endif
              </figure>
              <div class="card-body">
                <h3 class="card-title">{{ $course->name_course }}</h3>
                <div>
                  @php $progress = $progressData[$course->id_course] ?? 0; @endphp
                  <div class="flex justify-between text-xs mb-1">
                    <span class="font-semibold">Progress</span>
                    <span class="font-bold text-primary">{{ $progress }}%</span>
                  </div>
                  <progress class="progress progress-primary w-full" value="{{ $progress }}"
                    max="100"></progress>
                </div>
                <div class="card-actions justify-end mt-4">
                  @php
                    $resumeModuleSlug = $resumeLinks[$course->id_course] ?? null;
                  @endphp

                  @if ($resumeModuleSlug)
                    <a wire:navigate
                      href="{{ route('student.courses.watch', [
                          'course' => $course->slug,
                          'module' => $resumeModuleSlug,
                      ]) }}"
                      class="btn btn-primary">
                      @if ($progress < 100)
                          <span>Lanjutkan Belajar</span>
                      @else
                          <span>Resume Belajar</span>
                      @endif
                    </a>
                  @else
                    <a wire:navigate href="{{ route('student.courses') }}" class="btn btn-primary">
                      Lihat Kursus
                    </a>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        @else
          <div class="text-center py-12 bg-base-200 rounded-lg">
            <p class="font-semibold">Anda belum memulai kursus apa pun.</p>
            <p class="text-sm text-base-content/60">Mulailah dengan menjelajahi katalog kami!</p>
          </div>
        @endif
      </div>

      {{-- Statistik  Aksi --}}
      <div class="lg:col-span-1 space-y-6">
        <h2 class="text-2xl font-bold">Statistik Anda</h2>
        <div class="stats stats-vertical shadow-lg border border-base-300 w-full">
          <div class="stat">
            <div class="stat-figure text-primary"><i class="fa-solid fa-graduation-cap text-2xl"></i></div>
            <div class="stat-title">Kursus Diikuti</div>
            <div class="stat-value">{{ $enrolledCount }}</div>
          </div>
          <div class="stat">
            <div class="stat-figure text-success"><i class="fa-solid fa-award text-2xl"></i></div>
            <div class="stat-title">Sertifikat Diraih</div>
            <div class="stat-value">{{ $certificateCount }}</div>
          </div>
        </div>

        <div class="card bg-base-100 shadow-lg border border-base-300">
          <div class="card-body text-center">
            <h3 class="card-title mx-auto">Cari Tantangan Baru?</h3>
            <p>Temukan kursus menarik lainnya di katalog kami.</p>
            <div class="card-actions justify-center mt-4">
              <a wire:navigate href="{{ route('student.catalog') }}" class="btn btn-primary btn-outline">
                Jelajahi Katalog <i class="fa-solid fa-arrow-right ml-2"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
