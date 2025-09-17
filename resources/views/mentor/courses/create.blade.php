@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">➕ Buat Kursus Baru</h3>

    <form action="{{ route('courses.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Kursus</label>
            <input type="text" name="name_course" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="desc_course" class="form-control" rows="4"></textarea>
        </div>
        <div class="mb-3">
            <label>Kategori</label>
            <select name="category_course" class="form-control" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id_category }}">{{ $cat->name_category }}</option>
                @endforeach
            </select>
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>
</div>
@endsection
