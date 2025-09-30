<?php 

// Login Google dengan role (student | mentor)
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])
    ->name('google.login');

Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])
    ->name('google.callback');

Route::post('/auth/google/onetap', [AuthController::class, 'googleOneTap'])
    ->middleware('guest')
    ->name('google-one-tap.handler');