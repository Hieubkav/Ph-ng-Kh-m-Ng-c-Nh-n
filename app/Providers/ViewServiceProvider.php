<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Share settings data for specific views
        View::composer(['component.*', 'component.post.*', 'partials.*', 'partials.shop.*', 'partials.shop.carousel.*'], function ($view) {
            $view->with('settings', Setting::first());
        });
    }
}