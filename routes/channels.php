<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('status', function (User $user) {
    return true;
});

Broadcast::channel('room', function (User $user) {
   return [
       'id' => $user->id,
       'name' => $user->name,
       'status' => 'Not Ready',
       'start_time' => round(microtime(true) * 1000),
   ];
});

Broadcast::channel('history', function (User $user){
    return true;
});
