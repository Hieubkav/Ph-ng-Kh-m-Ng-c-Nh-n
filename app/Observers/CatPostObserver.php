<?php

namespace App\Observers;

use App\Models\CatPost;
use Illuminate\Support\Facades\Cache;

class CatPostObserver
{
    /**
     * Handle the CatPost "created" event.
     */
    public function created(CatPost $catPost): void
    {
        Cache::forget('storefront_cat_posts');
    }

    /**
     * Handle the CatPost "updated" event.
     */
    public function updated(CatPost $catPost): void
    {
        Cache::forget('storefront_cat_posts');
    }

    /**
     * Handle the CatPost "deleted" event.
     */
    public function deleted(CatPost $catPost): void
    {
        Cache::forget('storefront_cat_posts');
    }
}
