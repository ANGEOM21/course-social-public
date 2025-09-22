<div class="min-h-screen flex flex-col justify-center items-center pt-2 sm:pt-0 backdrop-blur">
	<div>
		<a href="/" wire:navigate>
			<div class="flex justify-center items-center gap-2">
				<img src="{{ $logo }}" class="w-[50px]" alt="">
				<h1
					{{ $attributes->merge(['class' => 'text-3xl font-extrabold uppercase leading-tight bg-clip-text text-transparent drop-shadow bg-gradient-to-bl from-secondary to-primary']) }}>
					{{ $app_name }}
				</h1>
			</div>
		</a>
	</div>
	<div class="w-full card sm:max-w-md mt-6 bg-base-100 shadow-xl lg:rounded-badge overflow-hidden ">
		{{ $slot }}
	</div>
</div>