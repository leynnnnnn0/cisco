<?php

namespace App\Http\Controllers;

use App\Events\StatusChange;
use App\Exports\StatusExport;
use App\Models\Schedule;
use App\Models\Status;
use App\Models\User;
use App\Services\Duration;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class StatusController extends Controller
{
    protected $duration;

    function __construct(Duration $duration)
    {
        $this->duration = $duration;
    }
    public function index()
    {
        $status = Status::with('user')->latest()->paginate(20);
        $names = User::all()->pluck('name', 'id')->toArray();
        return view('employees-tag', ['status' => $status, 'names' => $names]);
    }

    public function getTags()
    {
        $tags = Status::where('user_id', Auth::id())->whereDate('created_at', Carbon::today())->get();
        $schedule = Schedule::where('user_id', Auth::id())->first();
        $tags = $this->duration->getDurationFromCollection($tags);
        return view('tags-history', ['tags' => $tags, 'schedule' => $schedule]);
    }

    public function tags()
    {
        $tags = Status::where('user_id', Auth::id())->whereDate('created_at', request('date'))->get();
        $tags = $this->duration->getDurationFromCollection($tags);
        return json_encode(['data' => $tags]);
    }

    public function search()
    {
        $validated = request()->validate([
            'id' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);
        if($validated['id'] === 'all'){
            $status = Status::with('user')
                ->whereBetween('created_at', [$validated['from'], $validated['to'] . ' 23:59:59'])
                ->latest()
                ->get();
        }else {
            $status = Status::with('user')
                ->where('user_id', $validated['id'])
                ->whereBetween('created_at', [$validated['from'], $validated['to'] . ' 23:59:59'])
                ->latest()
                ->paginate(20);
        }
        return response()->json(['success' => true, 'status' => $status, 'request' => request()->all()]);
    }
    public function update()
    {
        $allowedStatuses = ['READY', 'PERSONAL TIME', 'BREAK', 'LUNCH', 'MEETING'];
        $status = strtoupper(request('status'));
        $validated = Validator::make(['status' => $status], [
            'status' => ['required', Rule::in($allowedStatuses)]
        ]);
        if ($validated->fails()) {
            return response()->json([
                'message' => 'Something went wrong, please contact your administrator',
                'errors' => $validated->errors()
            ], 422);
        }
        try{
            $status = $validated->validated()['status'];
            Auth::user()->statuses()->create([
                'status' => $status
            ]);
            broadcast(new StatusChange(User::find(Auth::id()), $status));
            return json_encode([
                'success' => true,
                'status' => $status
            ]);
        }catch (Exception $e){
            return response()->json([
                'message' => 'Something went wrong, please contact your administrator',
                'errors' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy()
    {
        Auth::user()->statuses()->create([
            'status' => 'END OF SHIFT'
        ]);
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/login');
    }

//    public function export()
//    {
//        return Excel::download(new StatusExport, 'users.xlsx');
//    }

    public function export($id, $from, $to)
    {
        return (new StatusExport)->getQuery($id, $from, $to)->download("employee-$id-history.xlsx");
    }
}
