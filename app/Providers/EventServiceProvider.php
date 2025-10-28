<?php

namespace App\Providers;

use App\Models\Carousel;
use App\Models\Doctor;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\ServicePost;
use App\Observers\CarouselObserver;
use App\Observers\DoctorObserver;
use App\Observers\PostObserver;
use App\Observers\ScheduleObserver;
use App\Observers\ServiceObserver;
use App\Observers\ServicePostObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Carousel::observe(CarouselObserver::class);
        Doctor::observe(DoctorObserver::class);
        Post::observe(PostObserver::class);
        Schedule::observe(ScheduleObserver::class);
        Service::observe(ServiceObserver::class);
        ServicePost::observe(ServicePostObserver::class);
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
