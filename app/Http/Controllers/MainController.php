<?php

namespace App\Http\Controllers;

use App\Models\Carousel;
use App\Models\CatPost;
use App\Models\Doctor;
use App\Models\Post;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\ServicePost;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MainController extends Controller
{
    public function storeFront()
    {
        $carousels = Cache::remember('storefront_carousels', 3600, function () {
            return Carousel::query()->orderByDesc('created_at')->get();
        });

        $services = Cache::remember('storefront_services', 3600, function () {
            return Service::query()->orderBy('order_service')->get();
        });

        $doctors = Cache::remember('storefront_doctors', 3600, function () {
            return Doctor::all();
        });

        $activeSchedule = Cache::remember('storefront_active_schedule', 3600, function () {
            return Schedule::query()->where('status', 'show')->latest()->first();
        });

        $hotPosts = Cache::remember('storefront_hot_posts', 3600, function () {
            return Post::query()
                ->where('is_hot', 'hot')
                ->orderByDesc('created_at')
                ->get();
        });

        $catPosts = Cache::remember('storefront_cat_posts', 3600, function () {
            return CatPost::query()
                ->where('status', 'show')
                ->with([
                    'posts' => function ($query) {
                        $query->orderByDesc('created_at')
                            ->limit(3);
                    },
                ])
                ->get();
        });

        $videos = Cache::remember('storefront_videos', 3600, function () {
            return Video::query()
                ->where('is_active', true)
                ->orderBy('display_order')
                ->orderByDesc('created_at')
                ->get();
        });

        return view('shop.storeFront', compact(
            'carousels',
            'services',
            'doctors',
            'activeSchedule',
            'hotPosts',
            'catPosts',
            'videos'
        ));
    }

    public function page($id)
    {
        return view('shop.page', ['id' => $id]);
    }

    public function post(string $slug)
    {
        $post = Post::query()
            ->with('cat_post')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('shop.post', [
            'post' => $post,
        ]);
    }

    public function catPost($id)
    {
        return view('shop.catPost', ['id' => $id]);
    }

    public function hiring()
    {
        return view('shop.hiring');
    }

    public function services($id)
    {
        return view('shop.services', ['id' => $id]);
    }

    public function servicePost($serviceId, string $slug)
    {
        $service = Service::query()->findOrFail($serviceId);
        $servicePost = ServicePost::query()
            ->where('service_id', $serviceId)
            ->where('slug', $slug)
            ->firstOrFail();

        return view('shop.servicePost', [
            'service' => $service,
            'servicePost' => $servicePost,
        ]);
    }
}
