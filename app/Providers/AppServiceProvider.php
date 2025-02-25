<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Livewire::setScriptRoute(function ($handle) {
            return Route::get(config('app.livewire_prefix').'/livewire/livewire.js', $handle);
        });
        if (config('app.livewire_prefix') != ''){
            Livewire::setUpdateRoute(function ($handle) {
                return Route::post(config('app.livewire_prefix').'/livewire/update', $handle);
            });
        }

    }
}
