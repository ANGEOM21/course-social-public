@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">🎓 Kursus Saya</h3>

    <div class="row">
        @forelse($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <img src="https://via.placeholder.com/400x200?text=Kursus" 
                         class="card-img-top" alt="{{ $course->name_course }}">
                    <div class="card-body d-flex flex-column">
                        <h5>{{ $course->name_course }}</h5>
                        <p class="text-muted">{{ Str::limit($course->desc_course, 100) }}</p>
                        <a href="{{ route('learning.show', $course->id_course) }}" 
                           class="btn btn-success mt-auto">Lanjut Belajar</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Anda belum mengikuti kursus apapun.</p>
        @endforelse
    </div>
</div>
@endsection
