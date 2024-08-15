<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
