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
            $userTags[$tag->user_id][$tag->created_at->format('Y-m-d')][] = $tag;
        }
        // Get the duration of each tags
        foreach ($userTags as $dates) {
            foreach ($dates as &$tags){
                foreach ($tags as $index => $tag){
                    if($tag->status !== 'READY' || $index >= count($tags) - 1) continue;
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
                    $summary[$value->user_id]['duration'] += $value->duration;
                }
            }
        }
        foreach ($summary as &$tag){
            // Get total hours Worked
            $totalHoursWorked = sprintf('%.2f',  $tag['duration'] / 60);
            // Get total Earnings
            $totalEarnings = $totalHoursWorked * 5;
            $tag['totalEarnings'] = $totalEarnings;
        }
        // Get the total minutes worked
        // Get the total minutes worked
        return view('payroll', ['summary' => $summary]);
    }

    function getTags($tags): mixed
    {
        $tags = $tags->map(function ($tag, $index) use ($tags) {
            if ($index < count($tags) - 1) {
                $tagTime = new DateTime($tag->created_at->format('Y-m-d H:i:s'));
                $endTagTime = new DateTime($tags[$index + 1]->created_at->format('Y-m-d H:i:s'));
                $interval = $endTagTime->diff($tagTime);
                $tag->duration = sprintf('%02d:%02d:%02d', $interval->h, $interval->i, $interval->s);
            } else {
                $tag->duration = 'N/A'; // Or some other default value for the last item
            }
            return $tag;
        });
        return $tags;
    }
}
