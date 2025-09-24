<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DbController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DbController::class, 'index'])->name('home');
    Route::post('/upload-db', [DbController::class, 'uploadDb'])->name('upload.db');
    Route::post('/process-query', [DbController::class, 'processQuery'])->name('query.process');
});