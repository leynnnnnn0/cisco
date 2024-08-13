<?php

namespace App\Http\Controllers;

use App\Events\StatusChange;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StatusController extends Controller
{
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
}
