<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Carousel;
use App\Models\CatPost;
use App\Models\Doctor;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\ServicePost;
use App\Models\Video;
use App\Observers\CarouselObserver;
use App\Observers\CatPostObserver;
use App\Observers\DoctorObserver;
use App\Observers\PostObserver;
use App\Observers\ScheduleObserver;
use App\Observers\ServiceObserver;
use App\Observers\ServicePostObserver;
use App\Observers\VideoObserver;

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
    Carousel::observe(CarouselObserver::class);
    CatPost::observe(CatPostObserver::class);
        Doctor::observe(DoctorObserver::class);
        Post::observe(PostObserver::class);
        Schedule::observe(ScheduleObserver::class);
        Service::observe(ServiceObserver::class);
        ServicePost::observe(ServicePostObserver::class);
        Video::observe(VideoObserver::class);
    }
}
