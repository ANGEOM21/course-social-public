<div>
  <title>{{ $title }} - {{ $app_name }}</title>

  <div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-4 gap-8 mt-4 mb-12 p-2 md:p-8 ">
    {{-- Kolom Kiri: Video dan Deskripsi Modul --}}
    <div class="lg:col-span-2 xl:col-span-3 space-y-6">
      <div class="card bg-base-100 shadow-lg border border-base-300">
        <div class="card-body p-4 sm:p-6">
          <h2 class="card-title text-xl sm:text-2xl font-bold mb-4">{{ $activeModule->title }}</h2>
          {{-- Pemutar Video --}}
          @php $youtubeId =  $this->getYoutubeId($activeModule->video_url); @endphp
          @if ($youtubeId)
            {{-- Jika ID YouTube valid, tampilkan pemutar --}}
            <div class="aspect-video w-full bg-black rounded-lg overflow-hidden" wire:ignore x-data="youtubePlayer(@js($this->getYoutubeId($activeModule->video_url)))">
              <div id="youtube-player"></div>

            </div>
          @else
            {{-- Jika ID YouTube TIDAK valid, tampilkan pesan --}}
            <div
              class="aspect-video w-full bg-base-200 rounded-lg flex flex-col items-center justify-center text-center p-4">
              <div>
                <i class="fa-solid fa-video-slash text-6xl text-base-content/20 mb-4"></i>
                <h3 class="text-xl font-bold">Video Belum Tersedia</h3>
                <p class="text-base-content/60">Materi video untuk modul ini sedang dalam persiapan. Silakan coba lagi
                  nanti.</p>
              </div>
            </div>
          @endif

          {{-- Deskripsi Modul dan Tombol Berikutnya --}}
          <div class="mt-4">
            {{-- Deskripsi Modul --}}
            <div class="prose max-w-none">
              @if ($activeModule->description)
                {!! $activeModule->description !!}
              @endif
            </div>
            {{-- Tombol Navigasi --}}
            <div class="flex justify-end mb-4">
              {{-- Tombol "Modul Berikutnya" hanya muncul jika ADA modul berikutnya --}}
              @if ($nextModule)
                <button wire:click="goToNextModule" class="btn btn-primary">
                  Modul Berikutnya <i class="fa-solid fa-arrow-right ml-2"></i>
                </button>
              @endif
            </div>

            {{-- Pesan Penyelesaian --}}
            @if ($isCourseCompleted)
              <div class="alert alert-success shadow-lg">
                <i class="fa-solid fa-party-horn text-2xl"></i>
                <div>
                  <h3 class="font-bold">Selamat! Anda Telah Menyelesaikan Kursus Ini!</h3>
                  <div class="text-xs">Anda sekarang bisa mengunduh sertifikat Anda
                    @if ($link_sertifkat !== '')
                      <a href="{{ Storage::url($link_sertifkat) }}" download class="btn btn-link">
                        <i class="fa-solid fa-download"></i>
                        Unduh Sertifikat
                      </a>
                    @endif.
                  </div>
                </div>
                {{-- Tombol kembali ke "Kursus Saya" --}}
                <a wire:navigate href="{{ route('student.courses') }}" class="btn btn-sm btn-ghost">Kembali ke Kursus
                  Saya</a>
              </div>
              <div class="card bg-base-200 border border-base-300">
                <div class="card-body">
                  @if ($hasGivenFeedback)
                    {{-- Tampilan setelah memberi feedback --}}
                    <div class="text-center">
                      <i class="fa-solid fa-heart text-success text-4xl mb-2"></i>
                      <h3 class="font-bold">Terima Kasih!</h3>
                      <p>Kami sangat menghargai ulasan yang telah Anda berikan.</p>
                    </div>
                  @else
                    {{-- Tampilan form feedback --}}
                    <h3 class="card-title">Bagaimana Penilaian Anda Tentang Kursus Ini?</h3>
                    <p>Ulasan Anda akan sangat membantu kami dan siswa lainnya.</p>

                    {{-- Rating Bintang --}}
                    <div class="form-control flex flex-col gap-2">
                      <label class="label"><span class="label-text font-semibold">Rating Keseluruhan</span></label>
                      <div class="rating rating-lg" wire:model.live="rating">
                        <input type="radio" name="rating-2" class="rating-hidden" value="0" checked />
                        <input type="radio" name="rating-2" class="mask mask-star-2 bg-yellow-400" value="1" />
                        <input type="radio" name="rating-2" class="mask mask-star-2 bg-yellow-400" value="2" />
                        <input type="radio" name="rating-2" class="mask mask-star-2 bg-yellow-400" value="3" />
                        <input type="radio" name="rating-2" class="mask mask-star-2 bg-yellow-400" value="4" />
                        <input type="radio" name="rating-2" class="mask mask-star-2 bg-yellow-400" value="5" />
                      </div>
                      @error('rating')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                      @enderror
                    </div>

                    {{-- Komentar --}}
                    <div class="form-control flex flex-col gap-2">
                      <label class="label">
                        <span class="label-text font-semibold">
                          Tulis Ulasan (Opsional)
                        </span>
                      </label>
                      <textarea wire:model="feedback_description" class="textarea textarea-bordered w-full h-24"
                        placeholder="Bagikan pengalaman belajar Anda..."></textarea>
                      @error('feedback_description')
                        <span class="text-error text-xs mt-1">{{ $message }}</span>
                      @enderror
                    </div>

                    <div class="card-actions justify-end mt-2">
                      <button wire:click="submitFeedback" class="btn btn-primary" wire:loading.attr="disabled">
                        Kirim Ulasan
                      </button>
                    </div>
                  @endif
                </div>
              </div>
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- Kolom Kanan: Playlist Modul --}}
    <div class="lg:col-span-1 xl:col-span-1">
      <div class="card bg-base-100 shadow-lg border border-base-300 sticky top-20">
        <div class="card-body">
          <h2 class="card-title mb-2">{{ $course->name_course }}</h2>
          <p class="text-sm text-base-content/60 mb-4">Daftar Modul</p>

          <div class="space-y-2 max-h-[70vh] overflow-y-auto">
            @foreach ($allModules as $index => $module)
              <a wire:navigate
                href="{{ route('student.courses.watch', ['course' => $course->slug, 'module' => $module->slug]) }}"
                wire:key="module-playlist-{{ $module->id_module }}" @class([
                    'p-3 rounded-lg flex items-start gap-3 transition-all w-full',
                    'bg-primary text-primary-content shadow-md' =>
                        $activeModule->id_module == $module->id_module,
                    'bg-base-200 hover:bg-base-300' =>
                        $activeModule->id_module != $module->id_module,
                ])>

                {{-- Ikon Status Selesai/Belum --}}
                <div class="pt-1">
                  @if (in_array($module->id_module, $completedModulesIds))
                    <i class="fa-solid fa-check-circle text-success"></i>
                  @else
                    <i class="fa-regular fa-circle text-base-content/40"></i>
                  @endif
                </div>

                <div>
                  <p class="font-semibold leading-tight">{{ $module->title }}</p>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>

  @push('scripts')
    <script>
      // Hanya muat script API jika belum ada
      if (typeof(YT) == 'undefined' || typeof(YT.Player) == 'undefined') {
        var tag = document.createElement('script');
        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        window.onYouTubeIframeAPIReady = function() {
          window.isYouTubeAPIReady = true;
        };
      } else {
        window.isYouTubeAPIReady = true;
      }
    </script>
  @endpush
</div>
