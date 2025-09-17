<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Kursus Online') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            {{-- Brand ke dashboard sesuai role --}}
            <a class="navbar-brand fw-bold" 
               href="{{ Auth::user()->role_user === 'mentor' ? route('mentor.dashboard') : route('dashboard') }}">
                Kursus Online
            </a>

            <div class="ms-auto d-flex align-items-center">
                <a href="{{ route('courses.list') }}" class="btn btn-outline-light me-2">
                    <i class="bi bi-book"></i> Kursus
                </a>
                <a href="{{ route('profile') }}" class="btn btn-outline-light me-2">
                    <i class="bi bi-person-circle"></i> Profil
                </a>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
