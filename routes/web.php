<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/chats', [UserController::class, 'chats'])->name('dashboard');

    Route::get('/fetch-messages', [ChatController::class, 'fetchMessages'])->name('messages.fetch');
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('message.send');

});

require __DIR__.'/auth.php';
