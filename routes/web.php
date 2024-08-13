<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::post('/change-status', [StatusController::class, 'update']);

Route::get('/', function () {
    $users = User::with(['statuses' => function ($query) {
        $query->latest()->whereDate('created_at', Carbon::today())->limit(1);
    }])->get();
    return view('dashboard', ['users' => $users]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tags-history', function(){
   return view('tags-history');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
