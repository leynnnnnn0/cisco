<?php

use App\Http\Controllers\ExcelController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use App\Models\Schedule;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/excel', [ExcelController::class, 'index'])->name('excel');
Route::get('status/export/', [ExcelController::class, 'export']);

Route::post('/end-of-shift', [StatusController::class, 'destroy'])->middleware('auth');
Route::get('employees-tag', [StatusController::class, 'index'])->middleware('auth');
Route::post('request-user-tags', [StatusController::class, 'search'])->middleware('auth');
Route::post('/change-status', [StatusController::class, 'update']);

Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/tags-history', function(){
    $tags = Status::where('user_id', Auth::id())->whereDate('created_at', Carbon::today())->get();
    $schedule = Schedule::where('user_id', Auth::id())->first();
    $tags = getTags($tags);
   return view('tags-history', ['tags' => $tags, 'schedule' => $schedule]);
})->middleware('auth');

/**
 * @param $tags
 * @return mixed
 * @throws Exception
 */
function getTags($tags): mixed
{
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
    return $tags;
}

Route::post('/tags', function(){
    $tags = Status::where('user_id', Auth::id())->whereDate('created_at', request('date'))->get();
    $tags = getTags($tags);
    return json_encode(['data' => $tags]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
