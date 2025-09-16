<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Kursus Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <div class="d-flex flex-wrap justify-content-center gap-3">
    <a href="{{ route('courses.list') }}" class="btn btn-primary">
        <i class="bi bi-journal-bookmark"></i> Daftar Kursus
    </a>

    @if(Auth::user()->role_user === 'mentor')
        <a href="{{ route('courses.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Tambah Kursus
        </a>
    @endif

    <a href="{{ route('profile') }}" class="btn btn-outline-secondary">
        <i class="bi bi-person-circle"></i> Pengaturan Profil
    </a>
</div>


    <!-- Dashboard Content -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow border-0">
                    <div class="card-body text-center p-5">
                        <!-- Foto Profil -->
                        <img src="{{ Auth::user()->img_user }}" 
                             alt="Foto Profil" 
                             class="rounded-circle mb-3 border border-3 border-primary" 
                             width="130" height="130">

                        <!-- Nama & Email -->
                        <h3 class="fw-bold mb-0">{{ Auth::user()->name_user }}</h3>
                        <p class="text-muted">{{ Auth::user()->email_user }}</p>

                        <hr class="my-4">

                        <!-- Aksi -->
                        <div class="d-flex flex-wrap justify-content-center gap-3">
                            <a href="{{ route('courses.list') }}" class="btn btn-primary">
                                <i class="bi bi-journal-bookmark"></i> Daftar Kursus
                            </a>
                            <a href="{{ route('profile') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-gear"></i> Pengaturan Profil
                            </a>
                            <a href="{{ route('certificates.index') }}" class="btn btn-outline-primary">
                             <i class="bi bi-award"></i> Sertifikat Saya
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
