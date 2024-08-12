<?php

namespace App\Http\Controllers;

use App\Events\StatusChange;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function update($id)
    {
        broadcast(new StatusChange(User::find(Auth::id()), request('status')));
        return json_encode(['success' => true, 'status' => request('status')]);
    }
}
