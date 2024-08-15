<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/end-of-shift', function(){
   Auth::user()->statuses()->create([
      'status' => 'END OF SHIFT'
   ]);
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});


Route::post('/change-status', [StatusController::class, 'update']);

Route::get('/', function () {
    $users = User::with(['statuses' => function ($query) {
        $query->latest()->whereDate('created_at', Carbon::today())->limit(1);
    }])->get();
    return view('dashboard', ['users' => $users]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/tags-history', function(){
    $tags = Status::where('user_id', Auth::id())->whereDate('created_at', Carbon::today())->get();
    $tags = $tags->map(function ($tag, $index) use ($tags) {
        if ($index < count($tags) - 1) {
            $tagTime = new DateTime($tag->created_at->format('Y-m-d H:i:s'));
            $endTagTime = new DateTime($tags[$index + 1]->created_at->format('Y-m-d H:i:s'));
            $interval = $endTagTime->diff($tagTime);
            $tag->duration = sprintf('%02d:%02d:%02d', $interval->h, $interval->i, $interval->s);
        } else {
            $tag->duration = 'N/A'; // Or some other default value for the last item
        }
        return $tag;
    });
   return view('tags-history', ['tags' => $tags]);
})->middleware('auth');

Route::post('/tags', function(){
    $tags = Status::where('user_id', Auth::id())->whereDate('created_at', request('date'))->get();
    $tags = $tags->map(function ($tag, $index) use ($tags) {
        if ($index < count($tags) - 1) {
            $tagTime = new DateTime($tag->created_at->format('Y-m-d H:i:s'));
            $endTagTime = new DateTime($tags[$index + 1]->created_at->format('Y-m-d H:i:s'));
            $interval = $endTagTime->diff($tagTime);
            $tag->duration = sprintf('%02d:%02d:%02d', $interval->h, $interval->i, $interval->s);
        } else {
            $tag->duration = 'N/A'; // Or some other default value for the last item
        }
        return $tag;
    });
   return json_encode(['data' => $tags]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
