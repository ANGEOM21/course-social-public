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
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 animate-fade-in floating">Belajar Kapan Saja,
        Dimana
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
