<?php

use App\Http\Controllers\Students\Catalog;
use App\Http\Controllers\Students\CertificateController;
use App\Http\Controllers\Students\Courses;
use App\Http\Controllers\Students\CoursesEnroll;
use App\Http\Controllers\Students\CourseWatch;
use App\Http\Controllers\Students\MyCertificates;
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
                'route' => '/my-profile',
                'name' => 'profile',
                'component' => 'pages.students.profile',
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
            [
                'route' => '/courses/{course}/enroll',
                'name' => 'course.enroll',
                'class' => CoursesEnroll::class,
            ],
            [
                'route' => '/courses/{course:slug}/watch/{module:slug}',
                'name' => 'courses.watch',
                'class' => CourseWatch::class,
            ],
            [
                'route' => '/my-certificates',
                'name' => 'certificates',
                'class' => MyCertificates::class,
            ],
            [
                'route' => '/certificate/{course}/download',
                'name' => 'certificate.download',
                'class' => CertificateController::class,
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
