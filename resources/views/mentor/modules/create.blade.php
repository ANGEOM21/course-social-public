@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Tambah Modul untuk Kursus: {{ $course->name_course }}</h1>

    <form action="{{ route('mentor.modules.store', $course->id_course) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title_module" class="form-label">Judul Modul</label>
            <input type="text" name="title_module" id="title_module" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="desc_module" class="form-label">Deskripsi Modul</label>
            <textarea name="desc_module" id="desc_module" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="video_url" class="form-label">Link YouTube</label>
            <input type="url" name="video_url" id="video_url" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Modul</button>
    </form>
</div>
@endsection
