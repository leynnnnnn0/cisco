<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\Status;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'nathaniel',
            'email' => 'nathaniel@gmail.com',
            'password' => bcrypt('nathaniel'),
        ]);
        User::factory()->create([
            'name' => 'jashreil',
            'email' => 'jashreil@gmail.com',
            'password' => bcrypt('jashreil'),
        ]);
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adminadmin'),
            'is_admin' => true,
        ]);

        Schedule::create([
            'user_id' => 1,
            'start_time' => Carbon::createFromFormat('H:i:s', '08:00:00')->toTimeString(),
            'first_break' => Carbon::createFromFormat('H:i:s', '10:00:00')->toTimeString(),
            'lunch' => Carbon::createFromFormat('H:i:s', '12:00:00')->toTimeString(),
            'second_break' => Carbon::createFromFormat('H:i:s', '15:00:00')->toTimeString(),
            'end_time' => Carbon::createFromFormat('H:i:s', '17:00:00')->toTimeString(),
        ]);

        Schedule::create([
            'user_id' => 2,
            'start_time' => Carbon::createFromFormat('H:i:s', '08:00:00')->toTimeString(),
            'first_break' => Carbon::createFromFormat('H:i:s', '10:00:00')->toTimeString(),
            'lunch' => Carbon::createFromFormat('H:i:s', '12:00:00')->toTimeString(),
            'second_break' => Carbon::createFromFormat('H:i:s', '15:00:00')->toTimeString(),
            'end_time' => Carbon::createFromFormat('H:i:s', '17:00:00')->toTimeString(),
        ]);

        Schedule::create([
            'user_id' => 3,
            'start_time' => Carbon::createFromFormat('H:i:s', '08:00:00')->toTimeString(),
            'first_break' => Carbon::createFromFormat('H:i:s', '10:00:00')->toTimeString(),
            'lunch' => Carbon::createFromFormat('H:i:s', '12:00:00')->toTimeString(),
            'second_break' => Carbon::createFromFormat('H:i:s', '15:00:00')->toTimeString(),
            'end_time' => Carbon::createFromFormat('H:i:s', '17:00:00')->toTimeString(),
        ]);
    }
}
