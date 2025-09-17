<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kursus Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container my-5">
    <h2 class="mb-4">📚 Kursus Saya</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($courses->isEmpty())
        <div class="alert alert-warning">Anda belum mengikuti kursus apapun.</div>
    @else
        <div class="row">
            @foreach($courses as $course)
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title">{{ $course->name_course }}</h5>
                            <p class="card-text">{{ Str::limit($course->desc_course, 100) }}</p>
                            <a href="{{ route('courses.detail', $course->id_course) }}" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

</body>
</html>
