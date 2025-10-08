<div>
  <title>Sertifikat Saya - {{ $app_name }}</title>
  {{-- Hero Section --}}
  <section class="py-16 bg-gradient-to-r from-primary to-secondary text-primary-content">
    <div class="container mx-auto px-4">
      <h1 class="text-4xl font-bold">Sertifikat Saya</h1>
      <p class="text-lg text-base-100/70 mt-2">Semua pencapaian Anda tersimpan di sini. Teruslah belajar!</p>
    </div>
  </section>
  
  {{-- Daftar Sertifikat --}}
  <div class="container mx-auto px-4 py-12">
    @if ($certificates->isEmpty())
      <div class="text-center py-20 bg-base-100 rounded-2xl shadow-sm border border-base-300">
        <i class="fa-solid fa-award text-8xl text-base-content/10 mb-6"></i>
        <h3 class="text-2xl font-bold text-base-content mb-3">Belum Ada Sertifikat</h3>
        <p class="text-base-content/60 max-w-md mx-auto">Selesaikan kursus Anda hingga 100% untuk mendapatkan sertifikat
          pencapaian.</p>
      </div>
    @else
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($certificates as $certificate)
          <div class="card bg-base-100 shadow-lg border border-base-300">
            <div class="card-body">
              <div class="badge badge-success gap-2 mb-2"><i class="fa-solid fa-check-circle"></i>SELESAI</div>
              <h2 class="card-title">{{ $certificate->tbl_course->name_course ?? 'Kursus Telah Dihapus' }}</h2>
              <p>Sertifikat dibuat pada {{ $certificate->created_at->translatedFormat('d F Y') }}.</p>
              <div class="card-actions justify-end mt-4">
                {{-- Link download langsung ke file di storage public --}}
                <a href="{{ Storage::url($certificate->file_path) }}" download class="btn btn-primary">
                  <i class="fa-solid fa-download mr-2"></i>
                  Unduh Sertifikat
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>
