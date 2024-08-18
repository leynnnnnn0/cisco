<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::with(['statuses' => function ($query) {
            $query->latest()->whereDate('created_at', Carbon::today())->limit(1);
        }])->get();
        return view('dashboard', ['users' => $users]);
    }
}
