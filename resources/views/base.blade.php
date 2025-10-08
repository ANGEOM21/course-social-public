<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="bg-indigo-100" data-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link rel="manifest" href="{{ asset('favicon/manifest.json') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('logo.png') }}">

  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
  <meta name="theme-color" content="#ffffff">
  <meta name="viewport" content="width=device-width,initial-scale=1,shrink-to-fit=no">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
  <meta http-equiv="Pragma" content="no-cache" />
  <meta http-equiv="Expires" content="0" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
    rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />


  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

  {{-- LeaftJs css --}}
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

  {{-- TomJs --}}
  <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
  <link rel="stylesheet" type="text/css"
    href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />


  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
  <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>

  <style>
    #nprogress .bar {
      background: #3b82f6 !important;
      height: 4px !important;
    }

    #mapRegister {
      height: 350px;
      z-index: 1;
    }
  </style>
  <style>
    .trix-button-group--file-tools {
      display: none !important;
    }

    trix-editor {
      min-height: 12rem;
      /* Atur tinggi minimal editor */
      --tw-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05);
      --tw-shadow-colored: 0 1px 2px 0 var(--tw-shadow-color);
      box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
      border-radius: var(--rounded-btn, 0.5rem);
      border-width: 1px;
      border-color: oklch(var(--b3, var(--b2)) / 1);
      background-color: oklch(var(--b1));
    }

    trix-editor:focus-within {
      outline: 2px solid oklch(var(--p));
      outline-offset: 2px;
      border-color: oklch(var(--p));
    }
  </style>

  @livewireStyles()
  @stack('styles')

  @if (isset($titlePage))
    <title>{{ $titlePage }} - {{ $app_name }}</title>
  @endif
</head>

<body>
  {{ $slot }}
  {{-- Date picker --}}
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  {{-- LeaftJs --}}
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script>
    document.addEventListener('alpine:init', () => {
      Alpine.store('confirmModal', {
        isOpen: false,
        action: null,
        payload: null,
        open(action, payload = null) {
          this.action = action;
          this.payload = payload;
          this.isOpen = true;
        },
        close() {
          this.action = null;
          this.payload = null;
          this.isOpen = false;
        },
        confirm() {
          if (this.action) {
            Livewire.dispatch(this.action, this.payload);
            this.close();
          }
        }
      });
    });


    document.addEventListener("alpine:init", () => {
      Alpine.data("youtubePlayer", (videoId) => ({
        player: null,
        init() {
          let checkReady = setInterval(() => {
            if (
              window.isYouTubeAPIReady &&
              typeof YT !== "undefined" &&
              YT.Player
            ) {
              clearInterval(checkReady);
              if (!videoId) {
                console.error("YouTube Video ID is missing.");
                return;
              }

              if (this.player) {
                this.player.destroy();
              }

              this.player = new YT.Player("youtube-player", {
                height: "100%",
                width: "100%",
                videoId: videoId,
                playerVars: {
                  playsinline: 1,
                  autoplay: 1,
                  rel: 0
                },
                events: {
                  onStateChange: this.onPlayerStateChange.bind(this),
                },
              });
            }
          }, 100);
        },
        onPlayerStateChange(event) {
          if (event.data == YT.PlayerState.ENDED) {
            console.log("Video finished. Marking as complete.");
            Livewire.dispatch("markAsComplete");
          }
        },
      }));
    });
  </script>

  <x-toaster-hub />
  @livewireChartsScripts
  @livewireScripts
  <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
  @stack('scripts')
</body>

</html>
