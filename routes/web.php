<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::get('chats/{id}/send', [ChatController::class, 'send'])->name('chats.send');
Route::resources(
    [
        'users' => UserController::class,
        'chats' => ChatController::class
    ]

);
require __DIR__ . '/auth.php';
