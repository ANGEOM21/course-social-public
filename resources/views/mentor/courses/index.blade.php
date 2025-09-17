@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">🧑‍🏫 Kursus Saya (Mentor)</h3>
    <a href="{{ route('courses.create') }}" class="btn btn-primary mb-3">+ Tambah Kursus</a>

    <div class="row">
        @forelse($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <h5>{{ $course->name_course }}</h5>
                        <p class="text-muted">{{ Str::limit($course->desc_course, 100) }}</p>
                        <div class="mt-auto">
                            <a href="{{ route('courses.edit', $course->id_course) }}" 
                               class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('courses.destroy', $course->id_course) }}" 
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada kursus yang Anda buat.</p>
        @endforelse
    </div>
</div>
@endsection
