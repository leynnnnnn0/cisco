<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::post('/change-status/{id}', [StatusController::class, 'update', 'id']);

Route::get('/', function () {
    $users = User::get();
    return view('dashboard', ['users' => $users]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
