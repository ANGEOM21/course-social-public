@extends('layouts.app')

@section('content')
<div class="container">
    <h3>{{ $course->name_course }}</h3>
    <p class="text-muted">{{ $course->desc_course }}</p>

    <p><strong>Kategori:</strong> {{ $course->category->name_category ?? '-' }}</p>
    <p><strong>Mentor:</strong> {{ $course->mentor->name_user ?? '-' }}</p>

    @if(Auth::user()->role_user === 'student')
        @php
            $isEnrolled = Auth::user()->courses->contains($course->id_course);
        @endphp
        @if($isEnrolled)
            <a href="{{ route('learning.show', $course->id_course) }}" class="btn btn-success">
                Mulai Belajar
            </a>
        @else
            <form action="{{ route('courses.enroll', $course->id_course) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary">Daftar Kursus</button>
            </form>
        @endif
    @endif
</div>
@endsection
