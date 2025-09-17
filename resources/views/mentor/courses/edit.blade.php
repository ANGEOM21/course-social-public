@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">✏️ Edit Kursus</h3>

    <form action="{{ route('courses.update', $course->id_course) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Nama Kursus</label>
            <input type="text" name="name_course" value="{{ $course->name_course }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="desc_course" class="form-control" rows="4">{{ $course->desc_course }}</textarea>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="category_course" class="form-control" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id_category }}" 
                        {{ $course->category_course == $cat->id_category ? 'selected' : '' }}>
                        {{ $cat->name_category }}
                    </option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success">Update</button>
    </form>
</div>
@endsection
