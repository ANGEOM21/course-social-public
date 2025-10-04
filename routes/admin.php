<?php

use App\Http\Controllers\Admins\Categories;
use App\Http\Controllers\Admins\CourseDetail;
use App\Http\Controllers\Admins\CourseDetailVidio;
use App\Http\Controllers\Admins\Courses;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

$routes = [
    'guest' => [
        'middleware' => ['guest:admins'],
        'uris' => [
            // Login
            [
                'route' => 'login',
                'name' => 'login',
                'component' => 'pages.admin.auth.login',
            ],
        ],
    ],
    'auth' => [
        'middleware' => ['auth.admins', 'role:admin,mentor'],
        'uris' => [
            // Dashboard
            [
                'route' => '/',
                'name' => 'dashboard',
                'component' => 'pages.admin.dashboard',
            ],
            [
                'route' => 'settings',
                'name' => 'settings.index',
                'component' => 'pages.admin.settings.index',
            ],
            // Profile
            [
                'route' => 'profile',
                'name' => 'profile',
                'component' => 'pages.admin.profile',
            ],
            [
                'route' => '/categories',
                'name' => 'categories',
                'class' => Categories::class,
            ],
            [
                'route' => '/courses',
                'name' => 'courses.index',
                'class' => Courses::class,
            ],
            [
                'route' => '/courses/detail/{slug_course:slug}',
                'name' => 'courses.detail',
                'class' => CourseDetail::class,
            ],
            [
                'route' => '/courses/detail/{slug_course:slug}/{slug_module:slug}',
                'name' => 'courses.detail.vidio',
                'class' => CourseDetailVidio::class,
            ],
        ],
    ],
];

// Prefix Route: admin
Route::prefix('admin')
    ->name('admin.')
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
