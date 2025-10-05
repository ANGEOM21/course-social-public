<?php

use App\Http\Controllers\Students\Catalog;
use App\Http\Controllers\Students\Courses;
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
                'route' => '/my-courses',
                'name' => 'courses',
                'class' => Courses::class,
            ],
            [
                'route' => '/catalog',
                'name' => 'catalog',
                'class' => Catalog::class,
            ],
        ],
    ],
];

// Prefix Route: student
Route::prefix('student')
    ->name('student.')
    ->group(function () use ($routes) {
        foreach ($routes as $group) {
            Route::middleware($group['middleware'])->group(function () use ($group) {
                foreach ($group['uris'] as $url) {
                    // If this specific URI declares its own middleware, apply it
                    if (isset($url['middleware']) && is_array($url['middleware']) && count($url['middleware']) > 0) {
                        Route::middleware($url['middleware'])->group(function () use ($url) {
                            if (isset($url['class'])) {
                                if (isset($url['methods'])) {
                                    Route::match($url['methods'], $url['route'], $url['class'])->name($url['name']);
                                } else {
                                    $r = Route::get($url['route'], $url['class'])->name($url['name']);
                                    if (!empty($url['scoped'])) $r->scopeBindings();
                                }
                            } else {
                                Volt::route($url['route'], $url['component'])->name($url['name']);
                            }
                        });
                    } else {
                        // No per-route middleware: register directly under group middleware
                        if (isset($url['class'])) {
                            if (isset($url['methods'])) {
                                Route::match($url['methods'], $url['route'], $url['class'])->name($url['name']);
                            } else {
                                $r = Route::get($url['route'], $url['class'])->name($url['name']);
                                if (!empty($url['scoped'])) $r->scopeBindings();
                            }
                        } else {
                            Volt::route($url['route'], $url['component'])->name($url['name']);
                        }
                    }
                }
            });
        }
    });
