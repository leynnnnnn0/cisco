<?php

use App\Http\Controllers\ExcelController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use App\Models\Schedule;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/excel', [ExcelController::class, 'index'])->name('index');

Route::post('/end-of-shift', function(){
   Auth::user()->statuses()->create([
      'status' => 'END OF SHIFT'
   ]);
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
});

Route::get('/employees-tag', function(){
    $status = Status::with('user')->latest()->paginate(20);
    $names = User::all()->pluck('name', 'id')->toArray();
   return view('employees-tag', ['status' => $status, 'names' => $names]);
});

Route::post('request-user-tags', function(){
    $validated = request()->validate([
        'id' => 'required',
        'from' => 'required',
        'to' => 'required',
    ]);
    if($validated['id'] === 'all'){
        $status = Status::with('user')
            ->whereBetween('created_at', [$validated['from'], $validated['to']])
            ->latest()
            ->paginate(20);
    }else {
        $status = Status::with('user')->where('user_id', $validated['id'])->latest()->paginate(20);
    }
    return response()->json(['success' => true, 'status' => $status, 'request' => request()->all()]);
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
