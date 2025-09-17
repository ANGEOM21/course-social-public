@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2 class="fw-bold">{{ $course->name_course }}</h2>
    <p class="text-muted">{{ $course->description }}</p>

    <div class="row mt-4">
        <!-- Video Player -->
        <div class="col-md-8">
            <div class="ratio ratio-16x9 shadow rounded">
                <iframe src="{{ str_replace('watch?v=', 'embed/', $currentModule->video_url) }}" 
                        title="{{ $currentModule->title_module }}"
                        allowfullscreen></iframe>
            </div>
            <h4 class="mt-3">{{ $currentModule->title_module }}</h4>
            <p>{{ $currentModule->desc_module }}</p>
        </div>

        <!-- List Module -->
        <div class="col-md-4">
            <div class="list-group shadow-sm">
                @foreach($modules as $mod)
                    <a href="{{ route('learning.show', [$course->id_course, $mod->id_module]) }}" 
                       class="list-group-item list-group-item-action {{ $mod->id_module == $currentModule->id_module ? 'active' : '' }}">
                        🎥 {{ $mod->title_module }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
