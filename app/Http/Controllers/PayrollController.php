<?php

namespace App\Http\Controllers;

use App\Models\Status;
use DateTime;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
//$startTime = $startTime->modify('+1 day');
    public function index()
    {
        // Get all the tags
        $tags = Status::with('user')
            ->whereBetween('created_at', ['2024-08-01', '2025-08-15 23:59:59'])
            ->get();
        // Group the tags by their owner and date
        $userTags = [];
        foreach ($tags as $tag) {
            $tag->username = $tag->user->name;
            $userTags[$tag->user_id][$tag->created_at->format('Y-m-d')][] = $tag;
        }
        // Get the duration of each tags
        foreach ($userTags as $dates) {
            foreach ($dates as &$tags){
                foreach ($tags as $index => $tag){
//                    // TODO
//                    // Need to check the overtime hours/minutes
//                    if($tag->status === 'END OF SHIFT'){
//                        if($tag->created_at->format('H:i:s') > '17:00:00'){
//
//                        }
//                    }
                    if($index >= count($tags) - 1) continue;
                    $startTime = new DateTime($tag->created_at->format('Y-m-d H:i:s'));
                    $endTime = new DateTime($tags[$index + 1]->created_at->format('Y-m-d H:i:s'));
                    $difference = $startTime->diff($endTime);
                    $minutes = ($difference->h * 60) + $difference->i;
                    $tag->duration = $minutes;
                }
            }
        }
        $summary = [];
        foreach ($userTags as $tags){
            foreach ($tags as $tag){
                foreach ($tag as $value){
                    if(!array_key_exists($value->user_id, $summary))
                        $summary[$value->user_id]['duration'] = 0;
                        $summary[$value->user_id]['username'] = $value->username;
                    if($value->created_at->format('H:i:s') < '08:00:00'){
                        $timeIn = new DateTime($value->created_at->format('H:i:s'));
                        $earlyInMinutes = $timeIn->diff(new DateTime('08:00:00'));
                        $value->duration -= ($earlyInMinutes->h * 60) + $earlyInMinutes->i;
                    }
                    if($value->status === 'BREAK' && $value->duration < 15)
                        $summary[$value->user_id]['duration'] += 15 - $value->duration;
                    if($value->status === 'LUNCH' && $value->duration < 60)
                        $summary[$value->user_id]['duration'] += 60 - $value->duration;
                    if($value->status === 'READY')
                        $summary[$value->user_id]['duration'] += $value->duration;
                }
            }
        }
        foreach ($summary as &$tag){
            // Get total hours Worked
            $totalHoursWorked = sprintf('%.2f',  $tag['duration'] / 60);
            // Get total Earnings
            $totalEarnings = $totalHoursWorked * 5;
            $tag['totalHoursWorked'] = $totalHoursWorked;
            $tag['totalEarnings'] = $totalEarnings;
        }

        // Get the total minutes worked
        // Get the total minutes worked
        return view('payroll', ['summary' => $summary]);
    }

    public function processPayroll()
    {
        // Create pdf file of payslip and send it to all employees
        // Note: They have to be notified
    }

}
