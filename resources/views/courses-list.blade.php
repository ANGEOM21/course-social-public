<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kursus Saya - Kursus Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/home">Kursus Online</a>
            <div class="ms-auto d-flex">
                <a href="{{ route('profile') }}" class="btn btn-outline-light me-2">👤 Profil</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-outline-light">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">📚 Kursus Saya</h3>
            
            <!-- Search / Filter -->
            <form action="{{ route('courses.list') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" 
                       placeholder="Cari kursus..." value="{{ request('search') }}">
                <select name="category" class="form-select me-2">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id_category }}" 
                            {{ request('category') == $category->id_category ? 'selected' : '' }}>
                            {{ $category->name_category }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary">🔍 Cari</button>
            </form>
        </div>

        <!-- List Kursus -->
        <div class="row">
            @forelse($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="https://picsum.photos/400/200?random={{ $course->id_course }}" 
                             class="card-img-top" alt="Course Image">
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $course->name_course }}</h5>
                            <p class="text-muted">Kategori: {{ $course->category->name_category ?? '-' }}</p>
                            <p class="small">👨‍🏫 Mentor: {{ $course->mentor_name ?? 'TBA' }}</p>
                        </div>
                        <div class="card-footer bg-white">
                            <a href="{{ route('courses.show', $course->id_course) }}" class="btn btn-sm btn-outline-dark w-100">
                                ➡️ Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center text-muted">Belum ada kursus ditemukan.</p>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
