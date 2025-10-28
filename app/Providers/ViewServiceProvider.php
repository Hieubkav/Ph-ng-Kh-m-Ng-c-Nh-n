<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Cache và chia sẻ cấu hình hệ thống cho toàn bộ view
        $settings = Cache::remember('app.settings', 600, fn () => Setting::query()->first());

        View::share('settings', $settings);
    }
}
