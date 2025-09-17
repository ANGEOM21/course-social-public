@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">📚 Semua Kursus</h3>

    <!-- Filter -->
    <form method="GET" action="{{ route('courses.list') }}" class="mb-4 row">
        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" 
                   class="form-control" placeholder="Cari kursus...">
        </div>
        <div class="col-md-4">
            <select name="category" class="form-control">
                <option value="">-- Semua Kategori --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id_category }}" 
                        {{ request('category') == $cat->id_category ? 'selected' : '' }}>
                        {{ $cat->name_category }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary">Filter</button>
        </div>
    </form>

    <!-- Daftar Kursus -->
    <div class="row">
        @forelse($courses as $course)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <img src="https://via.placeholder.com/400x200?text=Kursus" 
                         class="card-img-top" alt="{{ $course->name_course }}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $course->name_course }}</h5>
                        <p class="text-muted">{{ Str::limit($course->desc_course, 100) }}</p>
                        <small class="mb-2">
                            Mentor: {{ $course->mentor->name_user ?? 'Tidak ada' }}
                        </small>
                        <a href="{{ route('courses.show', $course->id_course) }}" 
                           class="btn btn-primary mt-auto">Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted">Belum ada kursus.</p>
        @endforelse
    </div>
</div>
@endsection
