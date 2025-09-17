@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h3>📈 Progress Belajar</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($progress)
        <p>Kursus ID: {{ $progress->course_id }}</p>
        <div class="progress mb-3" style="height: 25px;">
            <div class="progress-bar bg-success" 
                 role="progressbar" 
                 style="width: {{ ($progress->completed / $progress->total) * 100 }}%">
                 {{ $progress->completed }} / {{ $progress->total }}
            </div>
        </div>

        <form method="POST" action="{{ route('progress.update', $progress->course_id) }}">
            @csrf
            <input type="hidden" name="total" value="{{ $progress->total }}">
            <button type="submit" class="btn btn-primary">+ Tambah Progress</button>
        </form>
    @else
        <div class="alert alert-info">Belum ada progress untuk kursus ini.</div>
        <form method="POST" action="{{ route('progress.update', request()->id) }}">
            @csrf
            <input type="hidden" name="total" value="5"><!-- contoh total modul -->
            <button type="submit" class="btn btn-success">Mulai Kursus</button>
        </form>
    @endif
</div>
@endsection
