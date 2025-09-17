<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $course->name_course }} - Detail Kursus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/home">Kursus Online</a>
            <a href="{{ route('courses.list') }}" class="btn btn-outline-light ms-auto">⬅️ Kembali</a>
        </div>
    </nav>

    <div class="container my-5">
        <div class="card shadow border-0">
            <div class="card-body p-5">
                <h2 class="fw-bold">{{ $course->name_course }}</h2>
                <p class="text-muted">Kategori: {{ $course->category->name_category ?? '-' }}</p>
                <p>👨‍🏫 Mentor: {{ $course->mentor_name ?? 'TBA' }}</p>

                <hr>
                <p>{{ $course->description ?? 'Deskripsi kursus belum tersedia.' }}</p>

                {{-- ✅ Tombol Enrollment --}}
                @if(Auth::check())
                    <a href="{{ route('enroll', $course->id) }}" class="btn btn-success">
                        🚀 Enroll & Mulai Belajar
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-warning">
                        🔑 Login untuk Enroll
                    </a>
                @endif
            </div>
        </div>
    </div>

</body>
</html>
