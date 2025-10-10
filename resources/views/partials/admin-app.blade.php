<div class="drawer lg:drawer-open">
	<input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
	<div class="drawer-content flex flex-col">
		<!-- Navbar -->
		@include('layouts.topbar')
		<!-- Page content here -->
		<main class="container mx-auto p-1 md:p-4 ">
			{{ $slot }}
		</main>
	</div>
	<!-- Sidebar content here -->
	@include('layouts.sidenav')
</div>
