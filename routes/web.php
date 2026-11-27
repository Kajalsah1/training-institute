<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', fn () => redirect()->route('courses.index'));

// Only for logged-out users
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

// Only for logged-in users
Route::middleware('auth')->group(function () {
    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
