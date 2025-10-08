<?php
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\TblCourse;
use App\Models\TblFeedback;
use App\Models\TblProgress;

new class extends Component {
    public function with(): array
    {
        $popularCourses = TblCourse::query()
            ->with(['tbl_category', 'tbl_admin'])
            ->withCount('tbl_enrollments')
            ->withAvg('tbl_feedbacks as average_rating', 'rating')
            ->orderByDesc('average_rating')
            ->orderByDesc('tbl_enrollments_count')
            ->take(3)
            ->get();

        $testimonials = TblFeedback::with('tbl_student')->latest()->take(5)->get();

        return [
            'popularCourses' => $popularCourses,
            'testimonials' => $testimonials,
        ];
    }
}; ?>

<div>
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

  {{-- Tentang Kami --}}
  <section id="about" class="py-20 bg-base-200">
    <div class="container mx-auto px-4">
      <div class="grid lg:grid-cols-2 gap-12 items-center">
        {{-- Kolom Kiri: Gambar --}}
        <div class="scroll-reveal">
          <div class="relative w-full max-w-md mx-auto">
            <div class="absolute -top-4 -left-4 w-full h-full bg-primary rounded-2xl transform -rotate-3"></div>
            @php
            // Ganti spasi menjadi - 
              $logosAbout = Str::slug($app_name)
            @endphp
            <img src="{{ asset($logosAbout.'.jpg') }}"
              alt="Tim {{ $app_name }}" class="relative w-full h-full object-cover rounded-2xl shadow-lg">
          </div>
        </div>

        {{-- Kolom Kanan: Teks --}}
        <div class="scroll-reveal" data-delay="100">
          <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text capitalize">Tentang {{ $app_name }}</h2>
          <p class="text-lg text-base-content/80 mb-4 leading-relaxed">
            <strong class="capitalize">{{ $app_name }}</strong> adalah komunitas dan platform edukasi yang lahir dari semangat untuk
            memberdayakan individu di era digital. Kami percaya bahwa setiap orang memiliki potensi untuk meraih karier
            impian, dan pendidikan yang tepat adalah kuncinya.
          </p>
          <p class="text-base-content/70 mb-6">
            Misi kami adalah menyediakan jalur pembelajaran yang terstruktur, praktis, dan relevan dengan industri,
            mulai dari pengembangan web, desain UI/UX, hingga strategi menjadi freelancer sukses. Bersama mentor
            berpengalaman dan komunitas yang suportif, kami siap menemani setiap langkah perjalanan belajar Anda.
          </p>
          <div class="flex items-center gap-4">
            <a href="#program" class="btn btn-primary">Lihat Kursus</a>
            <a href="#community" class="btn btn-ghost">Gabung Komunitas</a>
          </div>
        </div>
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

  {{-- Program kelas --}}
  <section id="program" class="py-16 bg-base-100">
    <div class="container mx-auto px-4">
      <div class="text-center mb-12 scroll-reveal">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text">Kursus Populer</h2>
        <p class="text-base-content/70 max-w-2xl mx-auto">
          Kursus pilihan yang paling banyak diminati dan mendapatkan ulasan terbaik dari siswa kami.
        </p>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        {{-- Loop melalui kursus populer dari komponen --}}
        @forelse ($popularCourses as $index => $course)
          <div
            class="card bg-base-content text-base-100 shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 scroll-reveal"
            data-delay="{{ ($index + 1) * 100 }}">
            <div class="card-body">
              <div class="text-center w-full">
                <span class="badge badge-primary badge-lg mb-2 text-center">
                  @if ($index == 0)
                    TERPOPULER
                  @elseif($index == 1)
                    BANYAK DIMINATI
                  @else
                    REKOMENDASI
                  @endif
                </span>
              </div>
              <h3 class="card-title text-2xl justify-center h-16">{{ $course->name_course }}</h3>
              <p class="opacity-90 text-center">oleh {{ $course->tbl_admin->name_admin ?? 'N/A' }}</p>
              <div class="card-actions justify-center mt-4">
                <a wire:navigate href="{{ route('student.course.enroll', ['course' => $course->slug]) }}"
                  class="btn btn-primary btn-outline group-hover:btn-primary transition-all transform hover:scale-105">
                  Lihat Detail
                </a>
              </div>
            </div>
          </div>
        @empty
          <p class="md:col-span-3 text-center text-base-content/60">Kursus populer akan segera ditampilkan.</p>
        @endforelse
      </div>
    </div>
  </section>

  {{-- Community --}}
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

        {{-- Teks & Keuntungan --}}
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

        {{-- Widget Discord --}}
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

  {{-- Testimoni / Feedback --}}
  <section id="testimoni" class="py-16 bg-base-200">
    <div class="">
      <div class="text-center mb-12 scroll-reveal">
        <h2 class="text-3xl md:text-4xl font-bold mb-4 gradient-text">💬 Testimoni Siswa</h2>
        <p class="text-base-content/70 max-w-2xl mx-auto">Apa kata mereka yang sudah bergabung dengan kursus kami</p>
      </div>

      @if ($testimonials->isNotEmpty())
        <div class="slick marquee py-5">
          @foreach ($testimonials as $testimonial)
            <div class="p-2 md:p-4 slick-slide">
              <div class="card bg-base-100 shadow h-full">
                <div class="card-body">
                  <div class="rating rating-sm mb-2">
                    @for ($i = 1; $i <= 5; $i++)
                      <input type="radio" name="rating-{{ $testimonial->id_feedback }}"
                        class="mask mask-star-2 bg-orange-400" {{ $i == $testimonial->rating ? 'checked' : '' }}
                        disabled />
                    @endfor
                  </div>
                  <p class="mb-4 italic line-clamp-3">"{{ $testimonial->description }}"</p>
                  <footer class="text-base-content/70 font-semibold">
                    {{ $testimonial->tbl_student->name_student ?? 'Siswa' }}</footer>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      @else
        <p class="text-center text-base-content/60">Jadilah yang pertama memberikan testimoni!</p>
      @endif
    </div>
  </section>

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
