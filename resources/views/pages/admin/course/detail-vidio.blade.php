<div>
  <title>{{ $title }} - {{ $app_name }}</title>
  {{-- Breadcrumbs --}}
  <div class="breadcrumbs text-sm mb-2">
    <ul>
      <li><a wire:navigate href="{{ route('admin.dashboard') }}">Dashboard</a></li>
      <li><a wire:navigate href="{{ route('admin.courses.index') }}">Kursus</a></li>
      <li><a wire:navigate href="{{ route('admin.courses.detail', $course->slug) }}"
          class="truncate max-w-xs">{{ $course->name_course }}</a></li>
      <li class="truncate max-w-xs">{{ $activeModule->title }}</li>
    </ul>
  </div>

  {{-- Layout Utama: Pemutar Video (Kiri) & Playlist (Kanan) --}}
  <div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-4 gap-4">
    <div class="lg:col-span-2 xl:col-span-3 space-y-6">
      <div class="card bg-base-100 shadow-lg border border-base-300">
        <div class="card-body p-4 sm:p-6">
          <h2 class="card-title text-xl sm:text-2xl font-bold mb-4">{{ $activeModule->title }}</h2>

          {{-- Embed Video YouTube --}}
          <div class="aspect-video w-full bg-black rounded-lg overflow-hidden">
            @php $youtubeId = $this->getYoutubeId($activeModule->video_url); @endphp
            @if ($youtubeId)
              <iframe class="w-full h-full" src="https://www.youtube.com/embed/{{ $youtubeId }}?autoplay=1&rel=0"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                allowfullscreen>
              </iframe>
            @else
              <div class="w-full h-full flex items-center justify-center text-error">URL Video YouTube tidak valid.
              </div>
            @endif
          </div>

          {{-- Deskripsi Modul Aktif --}}
          <div class="prose max-w-none mt-6">
            @if ($activeModule->description)
              {!! $activeModule->description !!}
            @endif
          </div>
        </div>
      </div>
    </div>

    {{-- Kolom Kanan: Playlist Modul --}}
    <div class="lg:col-span-1 xl:col-span-1">
      <div class="card bg-base-100 shadow-lg border border-base-300 sticky top-4">
        <div class="card-body">
          <h2 class="card-title mb-4">Daftar Modul</h2>
          <div class="space-y-2 max-h-[70vh] overflow-y-auto">
            @foreach ($allModules as $index => $module)
              <a wire:navigate
                href="{{ route('admin.courses.detail.vidio', [
                    'slug_course' => $course->slug,
                    'slug_module' => $module->slug,
                ]) }}"
                wire:key="module-playlist-{{ $module->id_module }}" @class([
                    'p-3 rounded-lg flex items-start gap-3 transition-all',
                    'bg-primary text-primary-content shadow-md' =>
                        $activeModule->id_module == $module->id_module,
                    'bg-base-200 hover:bg-base-300' =>
                        $activeModule->id_module != $module->id_module,
                ])>

                <span @class([
                    'font-bold text-lg w-6 text-center',
                    'text-primary-content/50' => $activeModule->id_module == $module->id_module,
                    'text-base-content/30' => $activeModule->id_module != $module->id_module,
                ])>{{ $index + 1 }}</span>

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
</div>
