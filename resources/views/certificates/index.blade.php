@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h3 class="fw-bold mb-4">🎓 Sertifikat Saya</h3>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            ✅ {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($certificates->isEmpty())
        <div class="alert alert-info">Belum ada sertifikat yang diterbitkan.</div>
    @else
        <div class="row">
            @foreach($certificates as $cert)
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="bi bi-award fs-1 text-primary"></i>
                            <h5 class="card-title mt-2">
                                {{ $cert->title ?? 'Sertifikat' }}
                            </h5>
                            <p class="text-muted small">
                                Diterbitkan: {{ $cert->created_at->format('d M Y') }}
                            </p>

                            {{-- Tampilkan tombol download jika ada file --}}
                            @if($cert->file_path)
                                <a href="{{ asset('storage/'.$cert->file_path) }}" 
                                   target="_blank" 
                                   class="btn btn-sm btn-primary">
                                    📄 Lihat Sertifikat
                                </a>
                                <a href="{{ route('certificates.download', $cert->id_certificate) }}" 
                                   class="btn btn-sm btn-outline-secondary mt-2">
                                    ⬇️ Unduh
                                </a>
                            @else
                                <p class="text-danger small">File tidak tersedia</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <hr class="my-4">

    {{-- Form tambah sertifikat --}}
    <div class="card shadow border-0">
        <div class="card-body">
            <h5 class="fw-bold mb-3">➕ Tambah Sertifikat Baru</h5>
            <form action="{{ route('certificates.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Judul Sertifikat</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Upload File (PDF/JPG/PNG)</label>
                    <input type="file" name="file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Tambah Sertifikat
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
