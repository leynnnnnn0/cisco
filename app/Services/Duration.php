<?php

namespace App\Services;

use DateTime;

class Duration
{
    public function getDurationFromCollection($tags)
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
