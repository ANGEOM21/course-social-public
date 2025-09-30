@php
  $menuItem = new \App\Constant\MenuItem();
  $menunList = collect($menuItem->menuList())['dashboard_student'];
@endphp
<div>
  <title>Dashboard {{ $app_name }}</title>
  <div>
    <nav
      class="navbar bg-base-100/80 backdrop-blur-sm shadow-lg px-4 sm:px-8 sticky top-0 z-50 transition-all duration-300"
      id="navbar">
      <div class="navbar-start">
        <a href="{{ route('landing.index') }}" class="flex item-center text-xl p-0 hover:bg-transparent">
          <img src="{{ asset('logo.png') }}" alt="Logo SCP" class="h-8 w-8 mr-2" />
          <span class="font-bold bg-clip-text">
            SCP
          </span>
        </a>
      </div>

      <!-- Desktop Navigation -->
      <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1 font-medium gap-2">
          @foreach ($menunList as $menu)
            @php
              $href = $menu['route_name'] ? route($menu['route_name']) : $menu['href'] ?? '#';
            @endphp
            <li>
              <a href="{{ $href }}" @class([
                  'text-base-content hover:text-primary transition-all duration-300 transform hover:scale-105',
                  'font-bold text-primary' =>
                      $menu['route_name'] && request()->routeIs($menu['route_name']),
              ])>
                {{ ucfirst($menu['text']) }}
              </a>
            </li>
          @endforeach

        </ul>
      </div>

      <!-- Auth Section -->

      <div class="navbar-end">
        @if (auth('web')->check())
          <div class="flex justify-center items-center gap-3 dropdown dropdown-bottom dropdown-end">
            <span class="text-lg font-semibold max-w-[100px] truncate text-base-content">
              {{ Str::before(auth('web')->user()->name_student, ' ') }}
            </span>
            <div tabindex="0" role="button" class="normal-case avatar btn btn-ghost btn-circle ">
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
            <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-32 p-2 mt-2 shadow">
              <livewire:components.logout />
              <li>
                <a href="#" wire:navigate class="flex items-center gap-2">
                  <i class="fa-solid fa-user"></i>
                  Profile
                </a>
              </li>
            </ul>
          </div>
        @endif

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
            <li>
              <a href="#"
                class="text-base-content hover:text-primary transition-all duration-300 transform hover:scale-105">Courses</a>
            </li>
            <li>
              <a href="#"
                class="text-base-content hover:text-primary transition-all duration-300 transform hover:scale-105">Catalog</a>
            </li>
            <li>
              <a href="#"
                class="text-base-content hover:text-primary transition-all duration-300 transform hover:scale-105">Certificate</a>
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

    {{ $slot }}

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
</div>
