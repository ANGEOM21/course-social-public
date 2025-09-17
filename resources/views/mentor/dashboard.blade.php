@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">🧑‍🏫 Dashboard Mentor</h2>

    <div class="mb-3 text-end">
        <a href="{{ route('courses.create') }}" class="btn btn-success">
            ➕ Buat Kursus Baru
        </a>
    </div>

    @if($courses->isEmpty())
        <div class="alert alert-info">
            Anda belum membuat kursus apapun.
        </div>
    @else
        <div class="row">
            @foreach($courses as $course)
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $course->thumbnail ?? 'https://via.placeholder.com/400x200' }}" 
                             class="card-img-top" alt="{{ $course->name_course }}">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $course->name_course }}</h5>
                            <p class="card-text text-muted">
                                {{ Str::limit($course->desc_course, 100) }}
                            </p>
                            <div class="mt-auto d-flex justify-content-between">
                                <a href="{{ route('courses.edit', $course->id_course) }}" 
                                   class="btn btn-warning btn-sm">✏️ Edit</a>
                                <form action="{{ route('courses.destroy', $course->id_course) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus kursus ini?')">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
