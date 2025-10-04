@php
  $menuItem = new \App\Constant\MenuItem();
  $menunList = collect($menuItem->menuList())['landing_page'];
@endphp

<div>
  <title>Kursus {{ $app_name }}</title>
  <nav
    class="navbar bg-base-100/80 backdrop-blur-sm shadow-lg px-4 sm:px-8 sticky top-0 z-50 transition-all duration-300"
    id="navbar">
    <div class="navbar-start">
      <a href="{{ route('landing.index') }}" class="flex item-center text-xl p-0 hover:bg-transparent">
        <img src="{{ asset('logo.png') }}" alt="Logo SCP" class="h-8 w-8 mr-2" />
        <span class="font-bold bg-clip-text capitalize">
          {{ $app_name }}
        </span>
      </a>
    </div>

    {{-- Desktop Navigation --}}
    <div class="navbar-center hidden lg:flex">
      <ul class="menu menu-horizontal px-1 font-medium gap-4">
        @foreach ($menunList as $menu)
          <li>
            <a href="{{ $menu['section'] }}"
              class="text-base-content hover:text-primary transition-all duration-300 transform hover:scale-105">
              {{ $menu['text'] }}
            </a>
          </li>
        @endforeach
        @auth
          <li>
            <a href="{{ route('student.dashboard') }}"
              class="text-base-content hover:text-primary transition-all duration-300 transform hover:scale-105">
              Dashboard
            </a>
          </li>
        @endauth
        @guest
          <li>
            <a href="#contact"
              class="text-base-content hover:text-primary transition-all duration-300 transform hover:scale-105">
              Contact
            </a>
          </li>

        @endguest
      </ul>
    </div>

    {{-- Auth Section --}}
    <div class="navbar-end gap-3">
      {{-- Dropdown Masuk --}}
      @if (!auth('web')->check())
        <button id="btn-google" class="btn bg-white btn-circle text-black border-[#e5e5e5]">
          <svg aria-label="Google logo" width="16" height="16" xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 512 512">
            <g>
              <path d="m0 0H512V512H0" fill="#fff"></path>
              <path fill="#34a853" d="M153 292c30 82 118 95 171 60h62v48A192 192 0 0190 341"></path>
              <path fill="#4285f4" d="m386 400a140 175 0 0053-179H260v74h102q-7 37-38 57"></path>
              <path fill="#fbbc02" d="m90 341a208 200 0 010-171l63 49q-12 37 0 73"></path>
              <path fill="#ea4335" d="m153 219c22-69 116-109 179-50l55-54c-78-75-230-72-297 55"></path>
            </g>
          </svg>
        </button>
      @else
        <div class="justify-center items-center gap-3 dropdown dropdown-bottom dropdown-end hidden md:flex">
          <span class="text-lg font-semibold max-w-[100px] truncate text-base-content">
            {{ Str::before(auth('web')->user()->name_student, ' ') }}
          </span>
          <div tabindex="0" role="button" class="normal-case avatar btn btn-ghost btn-circle ">
            <div class="w-10 rounded-full flex">
              <div class="bg-base-300 h-10 w-10 flex items-center justify-center">
                  @php
                    $imageUrl =
                        auth('web')->user()->img_student ??
                        'https://ui-avatars.com/api/?name=' . urlencode(auth('web')->user()->name_student) . '?sz=50';
                    $fallback = 'https://ui-avatars.com/api/?name=' . urlencode(auth('web')->user()->name_student);
                  @endphp
                  <img 
                  src="{{ $imageUrl }}" 
                  alt="User Avatar"
                  class="w-10 h-10 rounded-full"
                  loading="lazy"
                  referrerpolicy="no-referrer"
                  decoding="async" onerror="this.onerror=null;this.src='{{ $fallback }}';" />
              </div>
            </div>
          </div>
          <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
            <li>
              <a href="{{ route('student.dashboard') }}" class="flex items-center gap-2">
                <i class="fa-solid fa-user"></i>
                Dashboard
              </a>
            </li>
            <livewire:components.logout />
          </ul>
        </div>
      @endif

      {{-- Mobile menu button --}}
      <div class="lg:hidden">
        <label for="drawer-menu" class="btn btn-ghost btn-circle hover:scale-110 transition-transform duration-300">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
            stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </label>
      </div>
    </div>
  </nav>

  {{-- Drawer (mobile menu) --}}
  <div class="drawer drawer-end z-50">
    <input id="drawer-menu" type="checkbox" class="drawer-toggle" />
    <div class="drawer-side">
      <label for="drawer-menu" class="drawer-overlay"></label>
      <div class="menu p-4 w-80 min-h-full bg-base-100 text-base-content shadow-xl">
        <div class="flex items-center justify-between mb-6">
          <span class="text-xl font-bold gradient-text">Menu</span>
          <label for="drawer-menu" class="btn btn-ghost btn-circle hover:scale-110 transition-transform duration-300">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
              stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </label>
        </div>
        <ul class="space-y-2">
          @foreach ($menunList as $menu)
            <li>
              <a href="{{ $menu['section'] }}"
                class="text-base-content hover:text-primary transition-all duration-300 transform hover:scale-105">
                {{ $menu['text'] }}
              </a>
            </li>
          @endforeach
          <li class="h-1 bg-slate-700 w-full rounded-lg p-0 my-1 mx-0"></li>
          @if (!auth('web')->check())
            <li>
              <a class="btn bg-white text-black border-[#e5e5e5]"
                href="{{ route('google.login', ['role' => 'student']) }}">
                <svg aria-label="Google logo" width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 512 512">
                  <g>
                    <path d="m0 0H512V512H0" fill="#fff"></path>
                    <path fill="#34a853" d="M153 292c30 82 118 95 171 60h62v48A192 192 0 0190 341"></path>
                    <path fill="#4285f4" d="m386 400a140 175 0 0053-179H260v74h102q-7 37-38 57"></path>
                    <path fill="#fbbc02" d="m90 341a208 200 0 010-171l63 49q-12 37 0 73"></path>
                    <path fill="#ea4335" d="m153 219c22-69 116-109 179-50l55-54c-78-75-230-72-297 55"></path>
                  </g>
                </svg>
                Login with Google
              </a>
            </li>
          @else
            <li>
              <a href="{{ route('student.dashboard') }}"
                class="btn my-2 w-full hover:scale-105 transition-transform duration-300">
                <i class="fa-solid fa-user"></i> Dashboard
              </a>
            </li>
            <livewire:components.logout />
            <li>
              <div class="flex justify-between items-center">
                <span>{{ auth('web')->user()->name_student }}</span>
                <div class="w-10 rounded-full flex">
                  <div class="bg-base-300 h-10 w-10 flex items-center justify-center">
                    <img
                      src="{{ auth('web')->user()->img_student
                          ? auth('web')->user()->img_student
                          : 'https://ui-avatars.com/api/?name=' . urlencode(auth('web')->user()->name_student) }}"
                      alt="User Avatar" class="w-10 h-10 rounded-full" />
                  </div>
                </div>
              </div>
            </li>
          @endif
        </ul>
      </div>
    </div>
  </div>

  {{-- Hero Section dengan efek paralax --}}
  <section id="hero"
    class="relative py-20 bg-gradient-to-br from-base-content to-neutral text-base-100 overflow-hidden mt-0 min-h-screen flex items-center parallax-bg">
    <div class="absolute inset-0 opacity-10">
      <div
        class="absolute top-0 left-0 w-full h-full pattern-dots pattern-blue-500 pattern-bg-white pattern-size-6 pattern-opacity-20">
      </div>
    </div>

    {{-- Elemen paralax --}}
    <div class="parallax-element absolute top-20 left-10 opacity-20" data-speed="0.3">🚀</div>
    <div class="parallax-element absolute top-40 right-20 opacity-20" data-speed="0.5">💻</div>
    <div class="parallax-element absolute bottom-40 left-20 opacity-20" data-speed="0.4">📚</div>
    <div class="parallax-element absolute bottom-20 right-10 opacity-20" data-speed="0.6">🎓</div>

    <div class="container mx-auto px-4 relative z-10">
      <div class="max-w-xl mx-auto text-center scroll-reveal">
        <h3 class="text-xl md:text-2xl lg:text-3xl text-primary font-bold animate-fade-in floating">
          #studyclubprogrammingsr
        </h3>
        <h1 class="text-3xl md:text-4xl lg:text-6xl font-bold mb-6 animate-fade-in floating">
          Karier Impian Anda Dimulai Bersama Kami
        </h1>
        <p class="text-xl mb-8 opacity-90 scroll-reveal" data-delay="200">
          Kami menyediakan kelas & jasa UI/UX design, Web Development, dan Freelancer untuk pemula.
        </p>
        @guest
          <a href="{{ route('google.login', ['role' => 'student']) }}"
            class="btn btn-primary btn-lg rounded-full px-8 animate-bounce hover:scale-105 transition-transform duration-300 scroll-reveal"
            data-delay="400">
            Mulai Sebagai Student
          </a>
        @endguest
      </div>
    </div>
  </section>

  {{-- Journey Kelas --}}
  <section id="journey" class="py-16 bg-base-100 scroll-section">
    <div class="container mx-auto px-4">
      <div class="text-center mb-16 scroll-reveal">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text">
          Perjalanan Belajar Anda
        </h2>
        <p class="text-base-content/70 max-w-2xl mx-auto">
          Mulailah perjalanan Anda dari dasar hingga menjadi seorang ahli bersama kami.
        </p>
      </div>

      <div class="relative max-w-2xl mx-auto">
        {{-- Garis Vertikal di Tengah --}}
        <div class="absolute left-1/2 top-0 h-full w-0.5 bg-neutral-content/80"></div>

        {{-- Item Timeline --}}
        <div class="relative mb-8 scroll-reveal">
          <div class="flex items-center">
            <div class="w-1/2 pr-8 text-right">
              <div class="p-4 bg-base-200 rounded-lg shadow-lg">
                <h3 class="font-bold text-lg">Beginner</h3>
                <p class="text-sm text-base-content/80">
                  Materi pengenalan untuk pemula.
                </p>
              </div>
            </div>
            <div class="w-1/2 pl-8">
              {{-- Ini hanya untuk penyeimbang, bisa dikosongkan --}}
            </div>
            {{-- Titik di Tengah --}}
            <div class="absolute left-1/2 -translate-x-1/2 w-4 h-4 bg-primary rounded-full"></div>
          </div>
        </div>

        {{-- Item Timeline --}}
        <div class="relative mb-8 scroll-reveal" data-delay="100">
          <div class="flex items-center">
            <div class="w-1/2 pr-8">
              {{-- Ini hanya untuk penyeimbang, bisa dikosongkan --}}
            </div>
            <div class="w-1/2 pl-8 text-left">
              <div class="p-4 bg-base-200 rounded-lg shadow-lg">
                <h3 class="font-bold text-lg">Fundamental</h3>
                <p class="text-sm text-base-content/80">
                  Konsep-konsep dasar yang wajib dikuasai.
                </p>
              </div>
            </div>
            {{-- Titik di Tengah --}}
            <div class="absolute left-1/2 -translate-x-1/2 w-4 h-4 bg-primary rounded-full"></div>
          </div>
        </div>

        {{-- Item Timeline --}}
        <div class="relative mb-8 scroll-reveal" data-delay="200">
          <div class="flex items-center">
            <div class="w-1/2 pr-8 text-right">
              <div class="p-4 bg-base-200 rounded-lg shadow-lg">
                <h3 class="font-bold text-lg">Intermediate</h3>
                <p class="text-sm text-base-content/80">
                  Meningkatkan keahlian ke tingkat menengah.
                </p>
              </div>
            </div>
            <div class="w-1/2 pl-8">
              {{-- Ini hanya untuk penyeimbang, bisa dikosongkan --}}
            </div>
            {{-- Titik di Tengah --}}
            <div class="absolute left-1/2 -translate-x-1/2 w-4 h-4 bg-primary rounded-full"></div>
          </div>
        </div>

        {{-- Item Timeline --}}
        <div class="relative mb-8 scroll-reveal" data-delay="300">
          <div class="flex items-center">
            <div class="w-1/2 pr-8">
              {{-- Ini hanya untuk penyeimbang, bisa dikosongkan --}}
            </div>
            <div class="w-1/2 pl-8 text-left">
              <div class="p-4 bg-base-200 rounded-lg shadow-lg">
                <h3 class="font-bold text-lg">Advanced</h3>
                <p class="text-sm text-base-content/80">
                  Topik lanjutan untuk para profesional.
                </p>
              </div>
            </div>
            {{-- Titik di Tengah --}}
            <div class="absolute left-1/2 -translate-x-1/2 w-4 h-4 bg-primary rounded-full"></div>
          </div>
        </div>

        {{-- Item Timeline --}}
        <div class="relative scroll-reveal" data-delay="400">
          <div class="flex items-center">
            <div class="w-1/2 pr-8 text-right">
              <div class="p-4 bg-base-200 rounded-lg shadow-lg">
                <h3 class="font-bold text-lg">Expert</h3>
                <p class="text-sm text-base-content/80">
                  Menjadi ahli di bidang pilihan Anda.
                </p>
              </div>
            </div>
            <div class="w-1/2 pl-8">
              {{-- Ini hanya untuk penyeimbang, bisa dikosongkan --}}
            </div>
            {{-- Titik di Tengah --}}
            <div class="absolute left-1/2 -translate-x-1/2 w-4 h-4 bg-primary rounded-full"></div>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- Promo Kelas --}}
  <section id="program" class="py-16 bg-base-100 scroll-section">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12 scroll-reveal">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text">Kursus Populer</h2>
        <p class="text-base-content/70 max-w-2xl mx-auto">
          Jangan lewatkan kesempatan untuk mengembangkan skillmu dengan
          harga spesial
        </p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        {{-- Card 1 --}}
        <div
          class="card bg-base-content text-base-100 shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 scroll-reveal"
          data-delay="100">
          <div class="card-body">
            <div class="text-center w-full">
              <span class="badge badge-primary badge-lg mb-2 text-center animate-pulse">
                DISKON 50%
              </span>
            </div>
            <h3 class="card-title text-2xl justify-center">Laravel Dasar</h3>
            <p class="opacity-90 text-center">Belajar dari nol sampai mahir.</p>
            <div class="card-actions justify-center mt-4">
              <button
                class="btn btn-primary btn-outline group-hover:btn-primary transition-all transform hover:scale-105">Lihat
                Detail</button>
            </div>
          </div>
        </div>

        {{-- Card 2 --}}
        <div
          class="card bg-base-content text-base-100 shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 scroll-reveal"
          data-delay="200">
          <div class="card-body">
            <div class="text-center w-full">
              <span class="badge badge-primary badge-lg mb-2 text-center">
                TERPOPULER
              </span>
            </div>
            <h3 class="card-title text-2xl justify-center">React JS</h3>
            <p class="opacity-90 text-center">Bangun aplikasi web modern dengan React.</p>
            <div class="card-actions justify-center mt-4">
              <button
                class="btn btn-primary btn-outline group-hover:btn-primary transition-all transform hover:scale-105">Lihat
                Detail
              </button>
            </div>
          </div>
        </div>

        {{-- Card 3 --}}
        <div
          class="card bg-base-content text-base-100 shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 scroll-reveal"
          data-delay="300">
          <div class="card-body">
            <div class="text-center w-full">
              <span class="badge badge-primary badge-lg mb-2 text-center">
                BARU
              </span>
            </div>
            <h3 class="card-title text-2xl justify-center">UI/UX Design</h3>
            <p class="opacity-90 text-center">Belajar desain pengalaman pengguna profesional.</p>
            <div class="card-actions justify-center mt-4">
              <button class="btn btn-outline group-hover:btn-primary transition-all transform hover:scale-105">Lihat
                Detail</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="community" class="py-16 bg-base-100 scroll-section">
    <div class="container mx-auto px-4">

      {{-- Judul Section --}}
      <div class="text-center mb-12 scroll-reveal">
        <h2 class="text-3xl md:text-3xl font-bold mb-4 gradient-text">🚀 Bergabunglah dengan Komunitas Kami</h2>
        <p class="text-base-content/70 max-w-2xl mx-auto">Jangan belajar sendirian! Diskusikan materi, dapatkan
          bantuan, dan jalin relasi dengan ribuan developer lainnya.</p>
      </div>

      {{-- Layout Utama Dua Kolom --}}
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

        {{-- Kolom Kiri: Teks & Keuntungan --}}
        <div class="scroll-reveal" data-delay="100">
          <h3 class="text-2xl font-bold mb-4">Kenapa Bergabung?</h3>
          <p class="text-base-content/80 mb-6">
            Komunitas Discord kami adalah tempat di mana pembelajaran tidak pernah berhenti. Dapatkan akses langsung ke
            mentor, bagikan proyek Anda, dan tumbuh bersama kami.
          </p>
          <ul class="space-y-4">
            <li class="flex items-start">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-primary flex-shrink-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <span><strong class="font-semibold">Tanya Jawab Real-time:</strong> Terjebak pada sebuah bug? Tanyakan
                langsung dan dapatkan solusi dari sesama anggota atau mentor.</span>
            </li>
            <li class="flex items-start">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-primary flex-shrink-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
              </svg>
              <span><strong class="font-semibold">Showcase Proyek:</strong> Pamerkan hasil karyamu, dapatkan feedback,
                dan lihat portofolio anggota lain sebagai inspirasi.</span>
            </li>
            <li class="flex items-start">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-primary flex-shrink-0" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
              </svg>
              <span><strong class="font-semibold">Networking Luas:</strong> Terhubung dengan para profesional,
                mahasiswa, dan sesama pembelajar dari seluruh Indonesia.</span>
            </li>
          </ul>
        </div>

        {{-- Kolom Kanan: Widget Discord --}}
        <div class="scroll-reveal" data-delay="200">
          <div class="card bg-base-200 shadow-xl transition-all duration-300 hover:shadow-2xl hover:-translate-y-2">
            <div class="card-body">
              <iframe src="https://discord.com/widget?id=1045577969013358623&theme=dark" width="100%"
                height="500" allowtransparency="true" frameborder="0"
                sandbox="allow-popups allow-popups-to-escape-sandbox allow-same-origin allow-scripts">
              </iframe>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <section id="testimoni" class="py-16 bg-base-200 scroll-section">
    <div class="">
      <div class="text-center mb-12 scroll-reveal">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text">💬 Testimoni Siswa</h2>
        <p class="text-base-content/70 max-w-2xl mx-auto">Apa kata mereka yang sudah bergabung dengan kursus kami</p>
      </div>

      <!-- Wrapper untuk Slick Slider -->
      <div class="slick marquee py-5 ">
        <!-- Slide 1 -->
        <div class="p-2 md:p-4 slick-slide">
          <div class="card bg-base-100 shadow h-full">
            <div class="card-body">
              <div class="rating rating-sm mb-2">
                @for ($i = 0; $i < 4; $i++)
                  <div class="mask mask-star-2 bg-orange-400" aria-label="{{ $i + 1 }} star"></div>
                @endfor
                <div class="mask mask-star-2 bg-orange-400" aria-label="5 star" aria-current="true"></div>
              </div>
              <p class="mb-4 italic">"Belajarnya mudah dipahami, mentornya keren!"</p>
              <footer class="text-base-content/70 font-semibold">Andi, Mahasiswa</footer>
            </div>
          </div>
        </div>

        <!-- Slide 2 -->
        <div class="p-2 md:p-4 slick-slide">
          <div class="card bg-base-100 shadow h-full">
            <div class="card-body">
              <div class="rating rating-sm mb-2">
                @for ($i = 0; $i < 4; $i++)
                  <div class="mask mask-star-2 bg-orange-400" aria-label="{{ $i + 1 }} star"></div>
                @endfor
                <div class="mask mask-star-2 bg-orange-400" aria-label="5 star" aria-current="true"></div>
              </div>
              <p class="mb-4 italic">"Banyak materi praktikal, langsung bisa diterapkan di kerja."</p>
              <footer class="text-base-content/70 font-semibold">Siti, Web Developer</footer>
            </div>
          </div>
        </div>

        <!-- Slide 3 -->
        <div class="p-2 md:p-4 slick-slide">
          <div class="card bg-base-100 shadow h-full">
            <div class="card-body">
              <div class="rating rating-sm mb-2">
                @for ($i = 0; $i < 4; $i++)
                  <div class="mask mask-star-2 bg-orange-400" aria-label="{{ $i + 1 }} star"></div>
                @endfor
                <div class="mask mask-star-2 bg-orange-400" aria-label="5 star" aria-current="true"></div>
              </div>
              <p class="mb-4 italic">"Sertifikatnya membantu banget untuk apply kerja."</p>
              <footer class="text-base-content/70 font-semibold">Budi, Fresh Graduate</footer>
            </div>
          </div>
        </div>

        <!-- Slide 4 -->
        <div class="p-2 md:p-4 slick-slide">
          <div class="card bg-base-100 shadow h-full">
            <div class="card-body">
              <div class="rating rating-sm mb-2">
                @for ($i = 0; $i < 4; $i++)
                  <div class="mask mask-star-2 bg-orange-400" aria-label="{{ $i + 1 }} star"></div>
                @endfor
                <div class="mask mask-star-2 bg-orange-400" aria-label="5 star" aria-current="true"></div>
              </div>
              <p class="mb-4 italic">"Platformnya sangat intuitif dan mudah digunakan."</p>
              <footer class="text-base-content/70 font-semibold">Dewi, Desainer Grafis</footer>
            </div>
          </div>
        </div>

        <!-- Slide 5 -->
        <div class="p-2 md:p-4 slick-slide">
          <div class="card bg-base-100 shadow h-full">
            <div class="card-body">
              <div class="rating rating-sm mb-2">
                @for ($i = 0; $i < 4; $i++)
                  <div class="mask mask-star-2 bg-orange-400" aria-label="{{ $i + 1 }} star"></div>
                @endfor
                <div class="mask mask-star-2 bg-orange-400" aria-label="5 star" aria-current="true"></div>
              </div>
              <p class="mb-4 italic">"Komunitasnya sangat membantu dan aktif."</p>
              <footer class="text-base-content/70 font-semibold">Eko, System Analyst</footer>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  {{-- Footer --}}
  @include('layouts.section.footer')

  {{-- Custom Styles dan Scripts --}}
  @push('styles')
    <style>
      /* Efek paralax */
      .parallax-bg {
        background-attachment: fixed;
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
      }

      .parallax-element {
        transition: transform 0.1s ease-out;
        font-size: 3rem;
      }

      /* Animasi scroll reveal */
      .scroll-reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s ease-out;
      }

      .scroll-reveal.active {
        opacity: 1;
        transform: translateY(0);
      }

      /* Gradient text animation */
      .gradient-text {
        background: linear-gradient(45deg, #3b82f6, #8b5cf6, #ec4899);
        background-size: 300% 300%;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        animation: gradient 5s ease infinite;
      }

      @keyframes gradient {
        0% {
          background-position: 0% 50%;
        }

        50% {
          background-position: 100% 50%;
        }

        100% {
          background-position: 0% 50%;
        }
      }

      /* Floating animation */
      @keyframes float {
        0% {
          transform: translateY(0px);
        }

        50% {
          transform: translateY(-10px);
        }

        100% {
          transform: translateY(0px);
        }
      }

      .floating {
        animation: float 3s ease-in-out infinite;
      }

      /* Smooth scroll behavior */
      html {
        scroll-behavior: smooth;
      }

      @keyframes marquee-scroll {
        0% {
          transform: translateX(0%);
        }

        100% {
          transform: translateX(-50%);
        }
      }

      /* Custom pattern background */
      .pattern-dots {
        background-image: radial-gradient(currentColor 1px, transparent 1px);
        background-size: 20px 20px;
      }
    </style>
  @endpush

  @push('scripts')
    <script>
      (function() {
        const OAUTH_URL = '/auth/google/?popup=1'; // route redirect

        function openPopup(url, w = 500, h = 600) {
          const y = window.top.outerHeight / 2 + window.top.screenY - (h / 2);
          const x = window.top.outerWidth / 2 + window.top.screenX - (w / 2);
          return window.open(
            url, 'oauth_popup',
            `width=${w},height=${h},left=${x},top=${y},resizable=yes,scrollbars=yes`
          );
        }

        document.getElementById('btn-google').addEventListener('click', function() {
          const popup = openPopup(OAUTH_URL);
          if (!popup) {
            alert('Popup diblokir browser. Izinkan popup atau klik lagi ya.');
            return;
          }

          // Dengar callback dari window popup
          const onMsg = (e) => {
            // keamanan: hanya terima dari origin sendiri
            if (e.origin !== window.location.origin) return;
            if (e.data && e.data.type === 'oauth' && e.data.provider === 'google') {
              window.removeEventListener('message', onMsg);
              if (e.data.ok) {
                console.log('Login berhasil');
                location.reload();
              } else {
                alert('Login gagal. Coba lagi.');
              }
            }
          };
          window.addEventListener('message', onMsg);
        });
      })();
    </script>

    <script>
      // JavaScript untuk efek paralax dan scroll reveal
      document.addEventListener('DOMContentLoaded', function() {
        // Efek paralax
        const parallaxElements = document.querySelectorAll('.parallax-element');

        window.addEventListener('scroll', function() {
          const scrolled = window.pageYOffset;

          parallaxElements.forEach(function(element) {
            const speed = element.getAttribute('data-speed');
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
          });
        });

        // Scroll reveal animation
        const scrollRevealElements = document.querySelectorAll('.scroll-reveal');

        function checkScroll() {
          scrollRevealElements.forEach(function(element) {
            const elementTop = element.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;

            if (elementTop < windowHeight - 100) {
              const delay = element.getAttribute('data-delay') || 0;
              setTimeout(function() {
                element.classList.add('active');
              }, delay);
            }
          });
        }

        // Check scroll on load and scroll
        checkScroll();
        window.addEventListener('scroll', checkScroll);

        // Navbar background change on scroll
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', function() {
          if (window.scrollY > 100) {
            navbar.classList.add('bg-base-100', 'shadow-lg');
            navbar.classList.remove('bg-base-100/90');
          } else {
            navbar.classList.remove('bg-base-100', 'shadow-lg');
            navbar.classList.add('bg-base-100/90');
          }
        });
      });
    </script>
    <script>
      jQuery(document).ready(function($) {
        $('.slick.marquee').slick({
          speed: 10000,
          autoplay: true,
          autoplaySpeed: 0,
          centerMode: true,
          cssEase: 'linear',
          slidesToShow: 1,
          slidesToScroll: 1,
          variableWidth: true,
          infinite: true,
          initialSlide: 1,
          arrows: false,
          buttons: false,
        });
      });
    </script>
  @endpush
</div>
