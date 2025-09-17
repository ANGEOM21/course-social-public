<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Landing & Auth
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Login Google dengan role (student | mentor)
Route::get('/auth/google/{role}', [AuthController::class, 'redirectToGoogle'])
    ->where('role', 'student|mentor')
    ->name('google.login');

// Callback Google
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->name('google.callback');

/*
|--------------------------------------------------------------------------
| Protected Routes (require login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    // Route utama dashboard → redirect sesuai role
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Student Dashboard
    Route::get('/student/dashboard', [DashboardController::class, 'student'])
        ->name('student.dashboard')
        ->middleware('role:student');

    // Mentor Dashboard
    Route::get('/mentor/dashboard', [DashboardController::class, 'mentor'])
        ->name('mentor.dashboard')
        ->middleware('role:mentor');

    /*
    |--------------------------------------------------------------------------
    | Courses (Student + Mentor)
    |--------------------------------------------------------------------------
    */
    Route::prefix('courses')->group(function () {
        // Semua user bisa lihat daftar & detail
        Route::get('/list', [CourseController::class, 'listView'])->name('courses.list');
        Route::get('/{id}', [CourseController::class, 'show'])->name('courses.show');

        // Student daftar kursus
        Route::post('/{id}/enroll', [EnrollmentController::class, 'enroll'])
            ->name('courses.enroll')
            ->middleware('role:student');

        // Mentor CRUD kursus
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
    | My Courses (dibedakan student & mentor)
    |--------------------------------------------------------------------------
    */
        // Student Dashboard
        Route::get('/student/dashboard', [DashboardController::class, 'student'])
        ->name('student.dashboard')
        ->middleware('role:student');

        // Mentor Dashboard
        Route::get('/mentor/dashboard', [DashboardController::class, 'mentor'])
        ->name('mentor.dashboard')
        ->middleware('role:mentor');


    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('profile.edit');

    /*
    |--------------------------------------------------------------------------
    | Certificates
    |--------------------------------------------------------------------------
    */
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::post('/certificates', [CertificateController::class, 'store'])->name('certificates.store');
    Route::get('/certificates/{id}/download', [CertificateController::class, 'download'])->name('certificates.download');

    /*
    |--------------------------------------------------------------------------
    | Learning
    |--------------------------------------------------------------------------
    */
    Route::get('/learning/{course}/{module?}', [LearningController::class, 'show'])->name('learning.show');

    /*
    |--------------------------------------------------------------------------
    | Logout
    |--------------------------------------------------------------------------
    */
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
