<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya - Kursus Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Kursus Online</a>
            <div class="ms-auto d-flex">
                <a href="{{ route('courses.list') }}" class="btn btn-outline-light me-2">
                    <i class="bi bi-journal-bookmark"></i> Kursus
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

    <!-- Profile Content -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <!-- Alert Message -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li><i class="bi bi-exclamation-triangle"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="card shadow border-0">
                    <div class="card-header bg-primary text-white fw-bold">
                        <i class="bi bi-person-circle"></i> Profil Saya
                    </div>
                    <div class="card-body p-4">

                        <!-- Foto Profil -->
                        <div class="text-center mb-4">
                            @if(Auth::user()->img_user)
                                <img src="{{ asset('storage/'.Auth::user()->img_user) }}" 
                                     alt="Foto Profil"
                                     class="rounded-circle border border-3 border-primary"
                                     width="140" height="140">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name_user }}&background=0D8ABC&color=fff" 
                                     alt="Foto Profil"
                                     class="rounded-circle border border-3 border-primary"
                                     width="140" height="140">
                            @endif
                        </div>

                        <!-- Form Update Profil -->
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label for="name_user" class="form-label">Nama</label>
                                <input type="text" id="name_user" name="name_user" 
                                       class="form-control" 
                                       value="{{ old('name_user', Auth::user()->name_user) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="email_user" class="form-label">Email</label>
                                <input type="email" id="email_user" name="email_user" 
                                       class="form-control" 
                                       value="{{ Auth::user()->email_user }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="role_user" class="form-label">Role</label>
                                <input type="text" id="role_user" class="form-control" 
                                       value="{{ ucfirst(Auth::user()->role_user) }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="img_user" class="form-label">Foto Profil Baru</label>
                                <input type="file" name="img_user" id="img_user" class="form-control">
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle"></i> Simpan Perubahan
                                </button>
                                <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                                   <i class="bi bi-arrow-left"></i> Kembali
                                </a>

                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
