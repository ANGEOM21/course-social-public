@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h3 class="fw-bold mb-4">🎓 Sertifikat Saya</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($certificates->isEmpty())
        <div class="alert alert-info">Belum ada sertifikat yang diterbitkan.</div>
    @else
        <div class="row">
            @foreach($certificates as $cert)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body text-center">
                            <i class="bi bi-award fs-1 text-primary"></i>
                            <h5 class="card-title mt-2">{{ $cert->title ?? 'Sertifikat' }}</h5>
                            <p class="text-muted">Diterbitkan: {{ $cert->created_at->format('d M Y') }}</p>
                            @if($cert->file)
                                <a href="{{ asset('storage/'.$cert->file) }}" target="_blank" class="btn btn-sm btn-primary">
                                   📄 Lihat Sertifikat
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <hr class="my-4">

    <!-- Form tambah sertifikat -->
    <form action="{{ route('certificates.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Judul Sertifikat</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Upload File (PDF/JPG/PNG)</label>
            <input type="file" name="file" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">+ Tambah Sertifikat</button>
    </form>
</div>
@endsection
