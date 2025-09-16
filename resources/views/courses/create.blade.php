<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kursus - Kursus Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/home">Kursus Online</a>
            <form action="{{ route('logout') }}" method="POST" class="ms-auto">
                @csrf
                <button type="submit" class="btn btn-outline-light">Logout</button>
            </form>
        </div>
    </nav>

    <!-- Content -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4">Tambah Kursus</h3>

                        <form action="{{ route('courses.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name_course" class="form-label">Nama Kursus</label>
                                <input type="text" name="name_course" id="name_course" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="category_course" class="form-label">Kategori</label>
                                <select name="category_course" id="category_course" class="form-select">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id_category }}">{{ $category->name_category }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="mentor_course" class="form-label">Mentor</label>
                                <select name="mentor_course" id="mentor_course" class="form-select">
                                    @foreach($mentors as $mentor)
                                        <option value="{{ $mentor->id_user }}">{{ $mentor->name_user }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-success">Simpan</button>
                            <a href="{{ route('courses.list') }}" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
