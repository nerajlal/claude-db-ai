<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DbController;
use App\Http\Controllers\FileUploadController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [DbController::class, 'index'])->name('home');
    Route::post('/upload', [FileUploadController::class, 'upload'])->name('upload');
    Route::post('/chat', [ChatController::class, 'chat'])->name('chat');
    Route::get('/chat/history/{chatId}', [ChatController::class, 'getChatHistory'])->name('chat.history');
    Route::post('/chat/new', [ChatController::class, 'newChat'])->name('chat.new');
    Route::post('/chat/rename', [ChatController::class, 'renameChat'])->name('chat.rename');
    Route::delete('/chat/delete/{chatId}', [ChatController::class, 'deleteChat'])->name('chat.delete');
});



Route::get('/test', function () {
    return view('test'); // this will load resources/views/test.blade.php
})->name('test');