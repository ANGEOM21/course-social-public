<?php

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
