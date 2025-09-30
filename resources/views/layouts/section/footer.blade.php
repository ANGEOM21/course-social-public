{{-- Footer --}}
<footer id="contact" class="bg-base-content text-base-100 scroll-section">
	<div class="container mx-auto p-10">
		<div class="footer">
			<aside>
				<div class="flex items-center text-2xl font-bold gap-3">
					<div class="w-12 h-12 p-1 bg-base-100 rounded-full">
						<img src="{{ asset('logo.png') }}" class="w-full h-full object-cover" alt="">
					</div>
					<span class="text-3xl font-bold">
						Study Club Programming
					</span>
				</div>
				<p class="mt-2 opacity-80 max-w-xs">
					Platform belajar online terbaik untuk meningkatkan skill digital Anda.
				</p>
				<div class="mt-4 flex gap-2">
					<a href="#" class="btn btn-square btn-ghost">
						<svg aria-label="Facebook logo" width="24" height="24" xmlns="http://www.w3.org/2000/svg"
							class="fill-current" viewBox="0 0 32 32">
							<path fill="white" d="M8 12h5V8c0-6 4-7 11-6v5c-4 0-5 0-5 3v2h5l-1 6h-4v12h-6V18H8z"></path>
						</svg>

					</a>
					<a href="#" class="btn btn-square btn-ghost">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
							class="fill-current">
							<path
								d="M19.6 2h-15.2c-1.3 0-2.4 1.1-2.4 2.4v15.2c0 1.3 1.1 2.4 2.4 2.4h15.2c1.3 0 2.4-1.1 2.4-2.4V4.4C22 3.1 20.9 2 19.6 2zM8.9 18.2H6V9.4h2.9v8.8zM7.4 8.2c-1 0-1.8-.8-1.8-1.8s.8-1.8 1.8-1.8 1.8.8 1.8 1.8-.8 1.8-1.8 1.8zm11.2 10H16v-4.4c0-1.1 0-2.4-1.5-2.4s-1.7 1.1-1.7 2.3V18.2h-2.9V9.4h2.8v1.3h.1c.4-.7 1.3-1.5 2.7-1.5 2.9 0 3.4 1.9 3.4 4.4v4.6z">
							</path>
						</svg>
					</a>
					<a href="#" class="btn btn-square btn-ghost">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
							class="fill-current">
							<path
								d="M17.6 2H6.4C4 2 2 4 2 6.4v11.2C2 20 4 22 6.4 22h11.2c2.4 0 4.4-2 4.4-4.4V6.4C20.8 4 18.8 2 16.4 2zM12 17.2c-2.9 0-5.2-2.3-5.2-5.2s2.3-5.2 5.2-5.2 5.2 2.3 5.2 5.2-2.3 5.2-5.2 5.2zm5.3-7.8c-1 0-1.8-.8-1.8-1.8s.8-1.8 1.8-1.8 1.8.8 1.8 1.8-.8 1.8-1.8 1.8z">
							</path>
						</svg>
					</a>
				</div>
			</aside>

			<div class="grid grid-cols-1 md:grid-cols-3 gap-8">
				{{-- Kolom 2: Menu Jelajahi --}}
				<nav class="flex flex-col mt-8 md:mt-0">
					<header class="footer-title">Jelajahi</header>
					<a class="link link-hover">Beranda</a>
					<a class="link link-hover">Semua Kursus</a>
					<a class="link link-hover">Tentang Kami</a>
					<a class="link link-hover">Blog</a>
				</nav>

				{{-- Kolom 3: Menu Kategori --}}
				<nav class="flex flex-col mt-8 md:mt-0 md:border-x md:px-10">
					<header class="footer-title">Kategori Populer</header>
					<a class="link link-hover">Web Development</a>
					<a class="link link-hover">UI/UX Design</a>
					<a class="link link-hover">Data Science</a>
					<a class="link link-hover">Digital Marketing</a>
				</nav>

				{{-- Hubungi Kami --}}
				<nav class="flex flex-col mt-8 md:mt-0">
					<header class="footer-title">Hubungi Kami</header>
					<p class="opacity-80">
						Punya pertanyaan atau butuh bantuan? Jangan ragu untuk menghubungi kami.
					</p>
					<div class="mt-2 space-y-1 flex flex-col">
						<a href="mailto:info@kursusonline.com" class="link link-hover">
							📧 info@kursusonline.com
						</a>
						<a href="tel:+6281234567890" class="link link-hover">
							📞 +62 812 3456 7890
						</a>
					</div>
				</nav>
			</div>
		</div>

		{{-- Garis Pemisah dan Copyright --}}
		<div class="mt-10 pt-6 border-t border-base-100/20 text-center">
			<p class="opacity-80">&copy; {{ date('Y') }} studyclubeprogrammingsr.</p>
		</div>
	</div>
</footer>
