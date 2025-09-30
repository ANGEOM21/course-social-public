<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

$routes = [
    'auth' => [
        'middleware' => ['auth'],
        'uris' => [
            // Dashboard
            [
                'route' => '/',
                'name' => 'dashboard',
                'component' => 'pages.students.dashboard',
            ],	
            [
                'route' => '/courses',
                'name' => 'courses',
                'class' => \App\Http\Controllers\Students\Courses::class,
            ],	
        ],
    ],
];

// Prefix Route: admin
Route::prefix('student')
    ->name('student.')
    ->group(function () use ($routes) {
        foreach ($routes as $group) {
            Route::middleware($group['middleware'])->group(function () use ($group) {
                foreach ($group['uris'] as $url) {
                    if (isset($url['class'])) {
                        if (isset($url['methods'])) {
                            Route::match($url['methods'], $url['route'], $url['class'])->name($url['name']);
                        }
                        Route::get($url['route'], $url['class'])->name($url['name']);
                    } else {
                        Volt::route($url['route'], $url['component'])->name($url['name']);
                    }
                }
            });
        }
    });
