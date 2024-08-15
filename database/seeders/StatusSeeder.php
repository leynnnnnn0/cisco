<?php

namespace Database\Seeders;

use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['READY', 'LUNCH', 'BREAK', 'PERSONAL TIME'];
        $startDate = Carbon::create(2024, 8, 13, 8);
        $endDate = Carbon::create(2024, 8, 13, 17);  // 5 PM
        Status::create([
            'user_id' => 1,
            'status' => 'READY',
            'created_at' => $startDate,
            'updated_at' => $startDate
        ]);

        Status::create([
            'user_id' => 3,
            'status' => 'READY',
            'created_at' => $startDate,
            'updated_at' => $startDate
        ]);

        Status::create([
            'user_id' => 2,
            'status' => 'READY',
            'created_at' => $startDate,
            'updated_at' => $startDate
        ]);

        while ($startDate->lt($endDate)) {
            DB::table('statuses')->insert([
                'user_id' => rand(1, 3),
                'status' => $statuses[array_rand($statuses)],
                'created_at' => $startDate->format('Y-m-d H:i:s'),
                'updated_at' => $startDate->format('Y-m-d H:i:s')
            ]);

            $startDate->addMinutes(rand(1, 60));
        }
    }
}
