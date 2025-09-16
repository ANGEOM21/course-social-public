<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Landing Page - Kursus Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Kursus Online</a>
            <div class="ms-auto">
                <a href="{{ route('google.login') }}" class="btn btn-outline-light">Sign In with Google</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="py-5 text-center bg-primary text-white" style="margin-top: 56px;">
        <div class="container">
            <h1 class="fw-bold">Belajar Kapan Saja, Dimana Saja 🚀</h1>
            <p class="lead">Akses ratusan kursus online dengan mentor berpengalaman</p>
            <a href="{{ route('google.login') }}" class="btn btn-light btn-lg mt-3">Mulai Sekarang</a>
        </div>
    </section>

    <!-- Promo Kelas -->
    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold text-center mb-4">🔥 Promo Kelas Terbaru</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">Laravel Dasar</h5>
                            <p class="text-muted">Diskon 50% - Belajar dari nol sampai mahir.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">React JS</h5>
                            <p class="text-muted">Bangun aplikasi web modern dengan React.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <h5 class="card-title">UI/UX Design</h5>
                            <p class="text-muted">Belajar desain pengalaman pengguna profesional.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimoni -->
    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="fw-bold text-center mb-4">💬 Testimoni Siswa</h2>
            <div class="row">
                <div class="col-md-4">
                    <blockquote class="blockquote text-center">
                        <p class="mb-3">"Belajarnya mudah dipahami, mentornya keren!"</p>
                        <footer class="blockquote-footer">Andi, Mahasiswa</footer>
                    </blockquote>
                </div>
                <div class="col-md-4">
                    <blockquote class="blockquote text-center">
                        <p class="mb-3">"Banyak materi praktikal, langsung bisa diterapkan di kerja."</p>
                        <footer class="blockquote-footer">Siti, Web Developer</footer>
                    </blockquote>
                </div>
                <div class="col-md-4">
                    <blockquote class="blockquote text-center">
                        <p class="mb-3">"Sertifikatnya membantu banget untuk apply kerja."</p>
                        <footer class="blockquote-footer">Budi, Fresh Graduate</footer>
                    </blockquote>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Kursus Online. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
