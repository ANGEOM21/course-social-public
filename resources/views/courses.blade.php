<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kursus Saya - Kursus Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('home') }}">Kursus Online</a>
            <div class="ms-auto d-flex">
                <a href="{{ route('courses.list') }}" class="btn btn-outline-light me-2">
                    <i class="bi bi-journal-bookmark"></i> Semua Kursus
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <div class="container my-5">
        <h2 class="fw-bold mb-4">
            <i class="bi bi-collection-play"></i> Kursus Saya
        </h2>

        <!-- Alert -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show">
                <i class="bi bi-info-circle"></i> {{ session('info') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- List Kursus -->
        <div class="row">
            @forelse($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow border-0">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $course->name_course }}</h5>
                            <p class="card-text text-muted">
                                {{ Str::limit($course->desc_course, 100) }}
                            </p>
                            <a href="{{ route('courses.show', $course->id_course) }}" class="btn btn-primary">
                                <i class="bi bi-play-circle"></i> Lanjut Belajar
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i> Anda belum mendaftar di kursus manapun.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
