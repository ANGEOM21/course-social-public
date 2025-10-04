<?php

use Livewire\Volt\Component;
use App\Models\TblCourse;
use App\Models\TblStudent;
use App\Models\TblAdmin;
use App\Models\TblCategory;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Asantibanez\LivewireCharts\Facades\LivewireCharts; // 1. Import LivewireCharts

new class extends Component {
    // Properti statistik
    public int $totalCourses;
    public int $totalStudents;
    public int $totalMentors;
    public int $totalCategories;

    public $latestCourses;
    public $latestStudents;

    // Method `mount` akan dipanggil sekali saat komponen dimuat
    public function mount(): void
    {
        $this->loadStats();
    }

    // Method untuk mengambil data statistik
    public function loadStats(): void
    {
        $this->totalCourses = TblCourse::count();
        $this->totalStudents = TblStudent::count();
        $this->totalMentors = TblAdmin::where('role', 'mentor')->count();
        $this->totalCategories = TblCategory::count();

        $this->latestCourses = TblCourse::with(['tbl_admin', 'tbl_category'])
            ->latest()
            ->take(5)
            ->get();
        $this->latestStudents = TblStudent::latest()->take(5)->get();
    }

    // 2. Gunakan `with()` untuk menyediakan data chart ke view
    public function with(): array
    {
        // Ambil data pendaftaran siswa dalam 7 hari terakhir
        $enrollments = TblStudent::query()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->where('created_at', '>=', Carbon::now()->subDays(6))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        // Siapkan LineChartModel
        $lineChartModel = LivewireCharts::lineChartModel()
            ->setTitle('Pendaftaran Siswa Baru (7 Hari Terakhir)')
            ->setAnimated(false)
            ->withGrid()
            ->setXAxisVisible(true)
            ->setColors(['#570df8']);

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $dateString = $date->format('Y-m-d');
            $count = $enrollments->get($dateString)->count ?? 0;
            $lineChartModel->addPoint($date->format('D, j M'), $count);
        }

        return [
            'lineChartModel' => $lineChartModel,
        ];
    }
}; ?>

<div>
  <title>Dashboard - {{ $app_name ?? 'Admin Panel' }}</title>

  {{-- Header Sambutan --}}
  <div class="mb-8">
    <h1 class="text-3xl font-bold">Selamat Datang, {{ auth('admins')->user()->name_admin }}!</h1>
    <p class="text-base-content/60">Berikut adalah ringkasan aktivitas di platform Anda.</p>
  </div>

  {{-- Grid Statistik Utama --}}
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
    {{-- Total Kursus --}}
    <div class="stat bg-base-100 shadow-lg border border-base-300 rounded-2xl">
      <div class="stat-figure text-primary"><i class="fa-solid fa-graduation-cap text-3xl"></i></div>
      <div class="stat-title">Total Kursus</div>
      <div class="stat-value text-primary">{{ $totalCourses }}</div>
    </div>
    {{-- Total Siswa --}}
    <div class="stat bg-base-100 shadow-lg border border-base-300 rounded-2xl">
      <div class="stat-figure text-secondary"><i class="fa-solid fa-users text-3xl"></i></div>
      <div class="stat-title">Total Siswa</div>
      <div class="stat-value text-secondary">{{ $totalStudents }}</div>
    </div>
    {{-- Total Mentor --}}
    <div class="stat bg-base-100 shadow-lg border border-base-300 rounded-2xl">
      <div class="stat-figure text-accent"><i class="fa-solid fa-chalkboard-user text-3xl"></i></div>
      <div class="stat-title">Total Mentor</div>
      <div class="stat-value text-accent">{{ $totalMentors }}</div>
    </div>
    {{-- Total Kategori --}}
    <div class="stat bg-base-100 shadow-lg border border-base-300 rounded-2xl">
      <div class="stat-figure text-info"><i class="fa-solid fa-folder-open text-3xl"></i></div>
      <div class="stat-title">Total Kategori</div>
      <div class="stat-value text-info">{{ $totalCategories }}</div>
    </div>
  </div>

  {{-- Grid Dua Kolom: Chart & Daftar Terbaru --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
    {{-- Kolom Kiri: Chart Pendaftaran --}}
    <div class="lg:col-span-2 card bg-base-100 shadow-lg border border-base-300">
      <div class="card-body">
        {{-- File ini hanya berisi satu baris untuk merender chart --}}
        <div style="height: 18rem;">
          <livewire:livewire-line-chart :line-chart-model="$lineChartModel" />
        </div>
      </div>
    </div>

    {{-- Kolom Kanan: Daftar Terbaru --}}
    <div class="space-y-4">
      {{-- Kursus Terbaru --}}
      <div class="card bg-base-100 shadow-lg border border-base-300">
        <div class="card-body">
          <h2 class="card-title">Kursus Terbaru</h2>
          <div class="space-y-3 mt-2">
            @forelse ($latestCourses as $course)
              <div class="flex items-center gap-3">
                <div class="avatar">
                  <div class="w-10 rounded-lg bg-base-200 flex items-center justify-center text-center">
                    @if ($course->tbl_category?->img_category && Storage::disk('public')->exists($course->tbl_category->img_category))
                      <img src="{{ Storage::url($course->tbl_category->img_category) }}" />
                    @else
                      <div class="w-full h-full flex items-center justify-center">
                        <span class="text-xl text-primary fa-solid fa-folder">
                      </div>
                    @endif
                  </div>
                </div>
                <div>
                  <a wire:navigate href="{{ route('admin.courses.detail', ['slug_course' => $course->slug]) }}"
                    class="font-semibold link link-hover">{{ $course->name_course }}</a>
                  <p class="text-xs text-base-content/60">oleh {{ $course->tbl_admin?->name_admin ?? 'N/A' }}</p>
                </div>
              </div>
            @empty
              <p class="text-sm text-base-content/60">Belum ada kursus yang dibuat.</p>
            @endforelse
          </div>
        </div>
      </div>
      {{-- Siswa Terbaru --}}
      <div class="card bg-base-100 shadow-lg border border-base-300">
        <div class="card-body">
          <h2 class="card-title">Siswa Terbaru</h2>
          <div class="space-y-3 mt-2">
            @forelse ($latestStudents as $student)
              <div class="flex items-center gap-3">
                <div class="avatar">
                  <div class="w-10 rounded-full">
                    @php
                      $imageUrl = $student->img_student
                          ? "$student->img_student?sz=50"
                          : 'https://ui-avatars.com/api/?name=' .
                              urlencode($student->name_student) .
                              '&background=random';
                      $fallback = 'https://ui-avatars.com/api/?name=' . $student->name_student;
                    @endphp
                    <img src="{{ $imageUrl }}" alt="User Avatar" class="w-10 h-10 rounded-full" loading="lazy"
                      referrerpolicy="no-referrer" decoding="async"
                      onerror="this.onerror=null;this.src='{{ $fallback }}';" />
                  </div>
                </div>
                <div>
                  <p class="font-semibold">{{ $student->name_student }}</p>
                  <p class="text-xs text-base-content/60">Bergabung {{ $student->created_at->diffForHumans() }}</p>
                </div>
              </div>
            @empty
              <p class="text-sm text-base-content/60">Belum ada siswa yang mendaftar.</p>
            @endforelse
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
