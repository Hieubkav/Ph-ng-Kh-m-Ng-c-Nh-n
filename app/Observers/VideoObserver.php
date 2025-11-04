<?php

namespace App\Observers;

use App\Models\Video;
use Illuminate\Support\Facades\Cache;

class VideoObserver
{
    /**
     * Handle the Video "created" event.
     */
    public function created(Video $video): void
    {
        Cache::forget('storefront_videos');
    }

    /**
     * Handle the Video "updated" event.
     */
    public function updated(Video $video): void
    {
        Cache::forget('storefront_videos');
    }

    /**
     * Handle the Video "deleted" event.
     */
    public function deleted(Video $video): void
    {
        Cache::forget('storefront_videos');
    }
}
