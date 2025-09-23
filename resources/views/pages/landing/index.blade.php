<div>
  <title>Kursus {{ $app_name }}</title>
  <nav
    class="navbar bg-base-100/80 backdrop-blur-sm shadow-lg px-4 sm:px-8 sticky top-0 z-50 transition-all duration-300"
    id="navbar">
    <div class="navbar-start">
      <a href="{{ route('landing.index') }}" class="btn btn-ghost text-xl p-0 hover:bg-transparent">
        <span class="text-2xl floating">🎓</span>
        <span
          class="font-bold ml-2 bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent gradient-text">Kursus
          Online</span>
      </a>
    </div>

    <!-- Desktop Navigation -->
    <div class="navbar-center hidden lg:flex">
      <ul class="menu menu-horizontal px-1 font-medium gap-2">
        <li>
          <a href="#promo"
            class="text-base-content hover:text-primary transition-all duration-300 transform hover:scale-105">Promo</a>
        </li>
        <li>
          <a href="#testimoni"
            class="text-base-content hover:text-primary transition-all duration-300 transform hover:scale-105">Testimoni</a>
        </li>
        <li>
          <a href="#footer"
            class="text-base-content hover:text-primary transition-all duration-300 transform hover:scale-105">Tentang</a>
        </li>
      </ul>
    </div>

    <!-- Auth Section -->
    <div class="navbar-end gap-3">
      <!-- Dropdown Masuk -->
      <div class="hidden md:block">
        <div class="dropdown dropdown-end">
          <label tabindex="0" class="btn btn-outline hover:scale-105 transition-transform duration-300">Masuk
            Sebagai</label>
          <ul tabindex="0"
            class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 mt-4 border border-base-300">
            <li>
              <a href="{{ route('google.login', ['role' => 'student']) }}"
                class="hover:scale-105 transition-transform duration-300">
                👨‍🎓 Student
              </a>
            </li>
            <li>
              <a href="{{ route('admin.login') }}"
                class="hover:scale-105 transition-transform duration-300">
                🧑‍🏫 Mentor
              </a>
            </li>
          </ul>
        </div>
      </div>

      <!-- Mobile menu button -->
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

  <!-- Drawer (mobile menu) -->
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
          <li><a href="#promo" class="py-3 text-lg hover:translate-x-2 transition-transform duration-300">Promo</a>
          </li>
          <li><a href="#testimoni"
              class="py-3 text-lg hover:translate-x-2 transition-transform duration-300">Testimoni</a></li>
          <li><a href="#footer" class="py-3 text-lg hover:translate-x-2 transition-transform duration-300">Tentang</a>
          </li>
          <li class="divider my-4"></li>
          <li>
            <a href="{{ route('google.login', ['role' => 'student']) }}"
              class="btn btn-outline my-2 w-full hover:scale-105 transition-transform duration-300">
              👨‍🎓 Masuk sebagai Student
            </a>
          </li>
          <li>
            <a href="{{ route('google.login', ['role' => 'mentor']) }}"
              class="btn btn-outline my-2 w-full hover:scale-105 transition-transform duration-300">
              🧑‍🏫 Masuk sebagai Mentor
            </a>
          </li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Hero Section dengan efek paralax -->
  <section
    class="relative py-20 bg-gradient-to-br from-base-content to-neutral text-base-100 overflow-hidden mt-0 min-h-screen flex items-center parallax-bg">
    <div class="absolute inset-0 opacity-10">
      <div
        class="absolute top-0 left-0 w-full h-full pattern-dots pattern-blue-500 pattern-bg-white pattern-size-6 pattern-opacity-20">
      </div>
    </div>

    <!-- Elemen paralax -->
    <div class="parallax-element absolute top-20 left-10 opacity-20" data-speed="0.3">🚀</div>
    <div class="parallax-element absolute top-40 right-20 opacity-20" data-speed="0.5">💻</div>
    <div class="parallax-element absolute bottom-40 left-20 opacity-20" data-speed="0.4">📚</div>
    <div class="parallax-element absolute bottom-20 right-10 opacity-20" data-speed="0.6">🎓</div>

    <div class="container mx-auto px-4 relative z-10">
      <div class="max-w-3xl mx-auto text-center scroll-reveal">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 animate-fade-in floating">Belajar Kapan Saja, Dimana
          Saja <span class="text-primary floating" style="animation-delay: 0.5s">🚀</span></h1>
        <p class="text-xl mb-8 opacity-90 scroll-reveal" data-delay="200">Akses ratusan kursus online dengan mentor
          berpengalaman</p>
        <a href="{{ route('google.login', ['role' => 'student']) }}"
          class="btn btn-primary btn-lg rounded-full px-8 animate-bounce hover:scale-105 transition-transform duration-300 scroll-reveal"
          data-delay="400">
          Mulai Sebagai Student
        </a>
      </div>
    </div>
  </section>

  <!-- Promo Kelas dengan animasi scroll -->
  <section id="promo" class="py-16 bg-base-100 scroll-section">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12 scroll-reveal">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text">🔥 Promo Kelas Terbaru</h2>
        <p class="text-base-content/70 max-w-2xl mx-auto">Jangan lewatkan kesempatan untuk mengembangkan skillmu dengan
          harga spesial</p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Card 1 -->
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

        <!-- Card 2 -->
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
                Detail</button>
            </div>
          </div>
        </div>

        <!-- Card 3 -->
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

  <!-- Testimoni dengan efek scroll yang lebih smooth -->
  <section id="testimoni" class="py-16 bg-base-200 relative overflow-hidden scroll-section">
    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-b from-base-100 to-base-200"></div>
    <div class="px-2 relative z-10">
      <div class="text-center mb-12 container mx-auto px-4 scroll-reveal">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text">💬 Testimoni Siswa</h2>
        <p class="text-base-content/70 max-w-2xl mx-auto">Apa kata mereka yang sudah bergabung dengan kursus kami</p>
      </div>

      <!-- Marquee for desktop -->
      <div class="hidden md:block overflow-hidden py-4 scroll-reveal">
        <div class="marquee">
          <div class="marquee-content">
            <!-- Testimonial Items (sama seperti sebelumnya) -->
            <div class="testimonial-item mx-4">
              <div class="card bg-base-100 shadow-xl w-80">
                <div class="card-body">
                  <div class="rating rating-sm mb-2">
                    <input type="radio" name="rating-4" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-4" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-4" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-4" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-4" class="mask mask-star-2 bg-primary" checked />
                  </div>
                  <p class="mb-4 italic">"Belajarnya mudah dipahami, mentornya keren!"</p>
                  <footer class="text-base-content/70 font-semibold">Andi, Mahasiswa</footer>
                </div>
              </div>
            </div>
            <div class="testimonial-item mx-4">
              <div class="card bg-base-100 shadow-xl w-80">
                <div class="card-body">
                  <div class="rating rating-sm mb-2">
                    <input type="radio" name="rating-5" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-5" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-5" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-5" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-5" class="mask mask-star-2 bg-primary" checked />
                  </div>
                  <p class="mb-4 italic">"Banyak materi praktikal, langsung bisa diterapkan di kerja."</p>
                  <footer class="text-base-content/70 font-semibold">Siti, Web Developer</footer>
                </div>
              </div>
            </div>
            <div class="testimonial-item mx-4">
              <div class="card bg-base-100 shadow-xl w-80">
                <div class="card-body">
                  <div class="rating rating-sm mb-2">
                    <input type="radio" name="rating-6" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-6" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-6" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-6" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-6" class="mask mask-star-2 bg-primary" checked />
                  </div>
                  <p class="mb-4 italic">"Sertifikatnya membantu banget untuk apply kerja."</p>
                  <footer class="text-base-content/70 font-semibold">Budi, Fresh Graduate</footer>
                </div>
              </div>
            </div>
            <!-- Duplicate for seamless loop -->
            <div class="testimonial-item mx-4">
              <div class="card bg-base-100 shadow-xl w-80">
                <div class="card-body">
                  <div class="rating rating-sm mb-2">
                    <input type="radio" name="rating-7" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-7" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-7" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-7" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-7" class="mask mask-star-2 bg-primary" checked />
                  </div>
                  <p class="mb-4 italic">"Belajarnya mudah dipahami, mentornya keren!"</p>
                  <footer class="text-base-content/70 font-semibold">Andi, Mahasiswa</footer>
                </div>
              </div>
            </div>
            <div class="testimonial-item mx-4">
              <div class="card bg-base-100 shadow-xl w-80">
                <div class="card-body">
                  <div class="rating rating-sm mb-2">
                    <input type="radio" name="rating-8" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-8" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-8" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-8" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-8" class="mask mask-star-2 bg-primary" checked />
                  </div>
                  <p class="mb-4 italic">"Banyak materi praktikal, langsung bisa diterapkan di kerja."</p>
                  <footer class="text-base-content/70 font-semibold">Siti, Web Developer</footer>
                </div>
              </div>
            </div>
            <div class="testimonial-item mx-4">
              <div class="card bg-base-100 shadow-xl w-80">
                <div class="card-body">
                  <div class="rating rating-sm mb-2">
                    <input type="radio" name="rating-9" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-9" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-9" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-9" class="mask mask-star-2 bg-primary" checked />
                    <input type="radio" name="rating-9" class="mask mask-star-2 bg-primary" checked />
                  </div>
                  <p class="mb-4 italic">"Sertifikatnya membantu banget untuk apply kerja."</p>
                  <footer class="text-base-content/70 font-semibold">Budi, Fresh Graduate</footer>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Slider for mobile -->
      <div class="md:hidden carousel rounded-box space-x-4 py-5 px-4 scroll-reveal">
        <div class="carousel-item">
          <div class="card bg-base-100 shadow-xl w-80">
            <div class="card-body">
              <div class="rating rating-sm mb-2">
                <input type="radio" name="rating-1" class="mask mask-star-2 bg-primary" checked />
                <input type="radio" name="rating-1" class="mask mask-star-2 bg-primary" checked />
                <input type="radio" name="rating-1" class="mask mask-star-2 bg-primary" checked />
                <input type="radio" name="rating-1" class="mask mask-star-2 bg-primary" checked />
                <input type="radio" name="rating-1" class="mask mask-star-2 bg-primary" checked />
              </div>
              <p class="mb-4 italic">"Belajarnya mudah dipahami, mentornya keren!"</p>
              <footer class="text-base-content/70 font-semibold">Andi, Mahasiswa</footer>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="card bg-base-100 shadow-xl w-80">
            <div class="card-body">
              <div class="rating rating-sm mb-2">
                <input type="radio" name="rating-2" class="mask mask-star-2 bg-primary" checked />
                <input type="radio" name="rating-2" class="mask mask-star-2 bg-primary" checked />
                <input type="radio" name="rating-2" class="mask mask-star-2 bg-primary" checked />
                <input type="radio" name="rating-2" class="mask mask-star-2 bg-primary" checked />
                <input type="radio" name="rating-2" class="mask mask-star-2 bg-primary" checked />
              </div>
              <p class="mb-4 italic">"Banyak materi praktikal, langsung bisa diterapkan di kerja."</p>
              <footer class="text-base-content/70 font-semibold">Siti, Web Developer</footer>
            </div>
          </div>
        </div>
        <div class="carousel-item">
          <div class="card bg-base-100 shadow-xl w-80">
            <div class="card-body">
              <div class="rating rating-sm mb-2">
                <input type="radio" name="rating-3" class="mask mask-star-2 bg-primary" checked />
                <input type="radio" name="rating-3" class="mask mask-star-2 bg-primary" checked />
                <input type="radio" name="rating-3" class="mask mask-star-2 bg-primary" checked />
                <input type="radio" name="rating-3" class="mask mask-star-2 bg-primary" checked />
                <input type="radio" name="rating-3" class="mask mask-star-2 bg-primary" checked />
              </div>
              <p class="mb-4 italic">"Sertifikatnya membantu banget untuk apply kerja."</p>
              <footer class="text-base-content/70 font-semibold">Budi, Fresh Graduate</footer>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer id="footer" class="bg-base-content text-base-100 py-12 scroll-section">
    <div class="container mx-auto px-4">
      <div class="flex flex-col md:flex-row justify-between items-center">
        <div class="mb-6 md:mb-0">
          <span class="text-2xl font-bold floating">🎓 Kursus Online</span>
          <p class="mt-2 opacity-80">Platform belajar online terbaik di Indonesia</p>
        </div>
        <div>
          <p class="text-center md:text-right opacity-80">&copy; {{ date('Y') }} Kursus Online.</p>
        </div>
      </div>
    </div>
  </footer>
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

      /* Marquee animation (tetap sama) */
      .marquee {
        width: 100%;
        overflow: hidden;
        position: relative;
      }

      .marquee-content {
        display: flex;
        padding: 20px 0;
        animation: marquee 30s linear infinite;
      }

      @keyframes marquee {
        0% {
          transform: translateX(0);
        }

        100% {
          transform: translateX(-50%);
        }
      }

      .marquee:hover .marquee-content {
        animation-play-state: paused;
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
  @endpush
</div>
