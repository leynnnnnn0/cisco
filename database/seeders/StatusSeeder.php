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
        $dateCount = 1;
        while($dateCount < 15){
            echo  'running';
            if($dateCount == 6 || $dateCount == 7 || $dateCount == 13 || $dateCount == 14){
                $dateCount++;
                continue;
            }
            $startDate = "2024-08-$dateCount";
            // Create a ready/start tag for each employee
            Status::create([
                'user_id' => 1,
                'status' => 'READY',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 08:00:00')->toDateTime(),
                'updated_at' => $startDate
            ]);

            Status::create([
                'user_id' => 3,
                'status' => 'READY',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 08:32:00')->toDateTime(),
                'updated_at' => $startDate
            ]);

            Status::create([
                'user_id' => 2,
                'status' => 'READY',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 07:57:00')->toDateTime(),
                'updated_at' => $startDate
            ]);

            // First Break
            Status::create([
                'user_id' => 1,
                'status' => 'BREAK',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 10:00:00')->toDateTime(),
                'updated_at' => $startDate
            ]);
            Status::create([
                'user_id' => 1,
                'status' => 'READY',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 10:15:00')->toDateTime(),
                'updated_at' => $startDate
            ]);

            Status::create([
                'user_id' => 3,
                'status' => 'BREAK',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 10:02:00')->toDateTime(),
                'updated_at' => $startDate
            ]);
            Status::create([
                'user_id' => 3,
                'status' => 'READY',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 10:22:00')->toDateTime(),
                'updated_at' => $startDate
            ]);

            Status::create([
                'user_id' => 2,
                'status' => 'BREAK',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 09:45:00')->toDateTime(),
                'updated_at' => $startDate
            ]);
            Status::create([
                'user_id' => 2,
                'status' => 'READY',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 09:59:23')->toDateTime(),
                'updated_at' => $startDate
            ]);

            // LUNCH
            Status::create([
                'user_id' => 1,
                'status' => 'LUNCH',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 12:00:34')->toDateTime(),
                'updated_at' => $startDate
            ]);
            Status::create([
                'user_id' => 1,
                'status' => 'READY',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 13:00:35')->toDateTime(),
                'updated_at' => $startDate
            ]);

            Status::create([
                'user_id' => 3,
                'status' => 'LUNCH',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 12:05:23')->toDateTime(),
                'updated_at' => $startDate
            ]);
            Status::create([
                'user_id' => 3,
                'status' => 'READY',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 13:02:12')->toDateTime(),
                'updated_at' => $startDate
            ]);

            Status::create([
                'user_id' => 2,
                'status' => 'LUNCH',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 12:45:43')->toDateTime(),
                'updated_at' => $startDate
            ]);
            Status::create([
                'user_id' => 2,
                'status' => 'READY',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 13:46:56')->toDateTime(),
                'updated_at' => $startDate
            ]);

            // LAST BREAK
            Status::create([
                'user_id' => 1,
                'status' => 'BREAK',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 15:00:34')->toDateTime(),
                'updated_at' => $startDate
            ]);
            Status::create([
                'user_id' => 1,
                'status' => 'READY',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 15:15:12')->toDateTime(),
                'updated_at' => $startDate
            ]);

            Status::create([
                'user_id' => 3,
                'status' => 'BREAK',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 15:05:34')->toDateTime(),
                'updated_at' => $startDate
            ]);
            Status::create([
                'user_id' => 3,
                'status' => 'READY',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 15:17:12')->toDateTime(),
                'updated_at' => $startDate
            ]);

            Status::create([
                'user_id' => 2,
                'status' => 'BREAK',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 15:12:43')->toDateTime(),
                'updated_at' => $startDate
            ]);
            Status::create([
                'user_id' => 2,
                'status' => 'READY',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 15:27:56')->toDateTime(),
                'updated_at' => $startDate
            ]);


            // END OF SHIFT
            Status::create([
                'user_id' => 1,
                'status' => 'END OF SHIFT',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 17:00:00')->toDateTime(),
                'updated_at' => $startDate
            ]);

            Status::create([
                'user_id' => 3,
                'status' => 'END OF SHIFT',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 17:00:00')->toDateTime(),
                'updated_at' => $startDate
            ]);

            Status::create([
                'user_id' => 2,
                'status' => 'END OF SHIFT',
                'created_at' => Carbon::createFromFormat('Y-m-d H:i:s', $startDate .' 17:00:00')->toDateTime(),
                'updated_at' => $startDate
            ]);
            $dateCount++;
        }
    }
}

//while ($startDate->lt($endDate)) {
//    DB::table('statuses')->insert([
//        'user_id' => rand(1, 3),
//        'status' => $statuses[array_rand($statuses)],
//        'created_at' => $startDate->format('Y-m-d H:i:s'),
//        'updated_at' => $startDate->format('Y-m-d H:i:s')
//    ]);
//
//    $startDate->addMinutes(rand(1, 60));
//}

