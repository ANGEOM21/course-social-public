@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">🎓 Dashboard Student</h2>

    @if($courses->isEmpty())
        <div class="alert alert-info">
            Anda belum mendaftar kursus apapun.
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
                            <a href="{{ route('learning.show', $course->id_course) }}" 
                               class="btn btn-primary mt-auto">
                                Mulai Belajar
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
