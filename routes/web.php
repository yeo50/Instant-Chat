<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('/dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');
Route::get('chats/{id}/send', [ChatController::class, 'send'])->name('chats.send');
Route::resources(
    [
        'chats' => ChatController::class
    ]

);
require __DIR__ . '/auth.php';
