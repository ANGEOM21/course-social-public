<?php 

// Login Google dengan role (student | mentor)
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/google/{role}', [AuthController::class, 'redirectToGoogle'])
    ->where('role', 'student')
    ->name('google.login');

Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->name('google.callback');