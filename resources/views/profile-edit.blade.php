<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Edit Profile</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name_user" class="form-label">Nama</label>
            <input type="text" name="name_user" class="form-control" value="{{ old('name_user', $user->name_user) }}" required>
        </div>

        <div class="mb-3">
            <label for="email_user" class="form-label">Email</label>
            <input type="email" name="email_user" class="form-control" value="{{ old('email_user', $user->email_user) }}" required>
        </div>

        <div class="mb-3">
            <label for="img_user" class="form-label">Foto Profil</label><br>
            @if($user->img_user)
                <img src="{{ asset('storage/'.$user->img_user) }}" alt="Foto Profil" width="100" class="mb-2 rounded">
            @endif
            <input type="file" name="img_user" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="/profile" class="btn btn-secondary">Batal</a>
    </form>
</div>

</body>
</html>
