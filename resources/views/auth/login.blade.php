<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Kursus Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card p-4 shadow" style="min-width: 300px;">
        <h4 class="mb-3 text-center">Login</h4>
        <a href="{{ route('google.login') }}" class="btn btn-danger w-100">Login with Google</a>
    </div>
</body>
</html>
