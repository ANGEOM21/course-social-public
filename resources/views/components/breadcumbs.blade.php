@props(['items'])

<div class="breadcrumbs text-sm">
	<ul>
		@forelse ($items as $item)
			<li>
				<a href="{{ route($item['url']) ?? '#' }}" wire:navigate class="{{ $loop->last ? 'font-semibold' : '' }}">
					<i class="fa {{ $item['icon'] ?? 'fa-home' }} mr-1"></i>
					{{ $item['text'] ?? 'Home' }}
				</a>
			</li>
		@empty
			<li>
				<a href="#" class="font-semibold">
					<i class="fa fa-home mr-1"></i>
					Home
				</a>
			</li>
		@endforelse
	</ul>
</div>
