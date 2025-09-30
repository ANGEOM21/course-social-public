<?php

use App\Http\Controllers\Admins\Categories;
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
                'route' => '/categories',
                'name' => 'categories',
                'class' => Categories::class,
            ],
            // Profile
            [
                'route' => 'profile',
                'name' => 'profile',
                'component' => 'pages.admin.profile',
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
                                    Route::get($url['route'], $url['class'])->name($url['name']);
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
                                Route::get($url['route'], $url['class'])->name($url['name']);
                            }
                        } else {
                            Volt::route($url['route'], $url['component'])->name($url['name']);
                        }
                    }
                }
            });
        }
    });
