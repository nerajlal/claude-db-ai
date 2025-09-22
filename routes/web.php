<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [DbController::class, 'index'])->name('home');
Route::post('/upload-db', [DbController::class, 'uploadDb'])->name('upload.db');
Route::post('/process-query', [DbController::class, 'processQuery'])->name('query.process');