<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Landing & Auth
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Google OAuth
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('google.login');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback');

/*
|--------------------------------------------------------------------------
| Protected Routes (require login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    /*
    |--------------------------------------------------------------------------
    | Courses
    |--------------------------------------------------------------------------
    */
    Route::prefix('courses')->group(function () {
        Route::get('/list', [CourseController::class, 'listView'])->name('courses.list');
        Route::get('/{id}', [CourseController::class, 'show'])->name('courses.show');

        // hanya mentor yang boleh akses
        Route::middleware('role:mentor')->group(function () {
            Route::get('/create', [CourseController::class, 'create'])->name('courses.create');
            Route::post('/', [CourseController::class, 'store'])->name('courses.store');
            Route::get('/{id}/edit', [CourseController::class, 'edit'])->name('courses.edit');
            Route::put('/{id}', [CourseController::class, 'update'])->name('courses.update');
            Route::delete('/{id}', [CourseController::class, 'destroy'])->name('courses.destroy');
        });
    });

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Certificates
    Route::get('/certificates', [App\Http\Controllers\CertificateController::class, 'index'])
    ->name('certificates.index');
    Route::post('/certificates', [App\Http\Controllers\CertificateController::class, 'store'])
    ->name('certificates.store');


    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
