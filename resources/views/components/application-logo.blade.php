<div class="flex justify-center items-center">
  <img src="{{ asset('logo.png') }}" class="w-[100px]" alt="">
  <h1 {{ $attributes->merge(['class' => 'text-4xl font-extrabold uppercase leading-tight bg-gradient-to-b from-yellow-400 to-yellow-600 bg-clip-text text-transparent drop-shadow']) }}>
    $app_name
  </h1>
</div>
